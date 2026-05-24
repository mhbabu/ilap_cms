<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Finance;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Ticket;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $campuses = Campus::active()->get();
        $reports  = collect();
        return $this->withOrg('reports.index', compact('campuses','reports'));
    }

    public function students(Request $request)
    {
        $campusId = $request->filled('campus_id') ? $request->campus_id : null;
        $export   = $request->filled('export');

        $q = Student::with(['campus','handler']);
        if ($campusId) $q->where('campus_id',$campusId);

        if ($export) {
            $data = $q->get();
            return $this->exportCsv('students-'.now()->format('Y-m-d'), [
                'ID','Name','Phone','Email','Campus','Handler','Step','IELTS'
            ], $data->map(fn($s)=>[
                $s->unique_id, $s->name, $s->phone, $s->email,
                $s->campus?->name, $s->handler?->name, $s->current_step, $s->ielts_score
            ])->toArray());
        }

        return $this->withOrg('reports.students', ['students'=>$q->paginate(50)]);
    }

    public function payments(Request $request)
    {
        $campusId = $request->filled('campus_id') ? $request->campus_id : null;
        $q = Payment::with(['campus','payer','initiator']);
        if ($campusId) $q->where('campus_id',$campusId);

        return $this->withOrg('reports.payments', ['payments'=>$q->latest()->paginate(50)]);
    }

    public function tickets(Request $request)
    {
        $campusId = $request->filled('campus_id') ? $request->campus_id : null;
        $q = Ticket::with(['campus','creator']);
        if ($campusId) $q->where('campus_id',$campusId);

        return $this->withOrg('reports.tickets', ['tickets'=>$q->latest()->paginate(50)]);
    }

    public function campus(Campus $campus)
    {
        $campus->load(['students','enrollments','payments','tickets']);
        $enrollmentSummary = \App\Models\Enrollment::where('campus_id',$campus->id)
            ->selectRaw('status, count(*) as c')->groupBy('status')->pluck('c','status');
        $studentsByStep = $campus->students->groupBy('current_step')->map->count();

        return $this->withOrg('reports.campus', compact('campus','enrollmentSummary','studentsByStep'));
    }

    public function leadStatus()
    {
        $byStatus = Lead::query()->selectRaw('status, count(*) as c')
            ->whereNotIn('status',['converted','lost'])->groupBy('status')->pluck('c','status');
        $bySource = Lead::query()->selectRaw('source, count(*) as c')
            ->groupBy('source')->pluck('c','source');
        return $this->withOrg('reports.lead-status', compact('byStatus','bySource'));
    }

    public function handlerPerformance()
    {
        $handlers = \App\Models\Handler::with(['students','leads'])->get();
        foreach ($handlers as $h) {
            $h->student_count = $h->students()->count();
            $h->lead_count    = $h->leads()->count();
        }

        return $this->withOrg('reports.handler-performance', compact('handlers'));
    }

    public function export(Request $request,string $type): Response
    {
        return match($type) {
            'students'=> $this->exportStudents(),
            'payments'=> $this->exportPayments(),
            default    => back()->with('error','Unknown export type.'),
        };
    }

    private function exportStudents(): Response
    {
        $data = Student::with(['campus','handler'])->get();
        return $this->exportCsv('students-'.now()->format('Y-m-d'), [
            'ID','Name','Phone','Email','IELTS','Campus','Handler','Status','Step'
        ], $data->map(function($s) {
            return [$s->unique_id,$s->name,$s->phone,$s->email,
                $s->ielts_score,$s->campus?->name,$s->handler?->name,$s->status,$s->current_step];
        })->toArray());
    }

    private function exportPayments(): Response
    {
        $data = Payment::with(['campus','initiator'])->latest()->get();
        return $this->exportCsv('payments-'.now()->format('Y-m-d'), [
            'ID','Amount','Type','Status','Campus','Initiated By','Received','Transaction Ref'
        ], $data->map(function($p) {
            return [$p->id,$p->amount,$p->type,$p->status,$p->campus?->name,
                $p->initiator?->name,$p->created_at,$p->transaction_ref];
        })->toArray());
    }

    private function exportCsv(string $filename, array $headers, array $rows): Response
    {
        ob_start();
        $h = fopen('php://output','w');
        fputcsv($h, $headers);
        foreach ($rows as $row) fputcsv($h, $row);
        fclose($h);
        $csv = ob_get_clean();

        return response($csv,200,[
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ]);
    }
}
