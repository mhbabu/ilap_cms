<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Campus;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $q = Enrollment::query()->with(['student','classData.module','campus'])->latest();
        if ($request->filled('campus')) $q->where('campus_id',$request->campus);
        if ($request->filled('status')) $q->where('status',$request->status);
        if ($request->filled('class')) $q->where('class_id',$request->class);
        return $this->withOrg('enrollments.index', ['enrollments'=>$q->paginate(20)]);
    }

    public function create(Request $request)
    {
        $classId = $request->get('class');
        $classes = ClassRoom::all();
        $students = Student::all();
        $campuses = Campus::all();
        return $this->withOrg('enrollments.create', compact('classes','students','campuses','classId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'     => 'required|exists:students,id',
            'class_id'       => 'required|exists:class_rooms,id',
            'campus_id'      => 'required|exists:campuses,id',
            'enrollment_date'=> 'required|date',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date',
            'payment_amount' => 'nullable|numeric|min:0',
            'status'         => 'required|in:registered,enrolled,documents_verified,completed',
            'notes'          => 'nullable|string',
            'payment_method' => 'nullable|in:cash,card,bkash,nagad,online',
            'payment_status' => 'nullable|in:pending,completed,failed,refunded',
            'transaction_ref'=> 'nullable|string|max:255',
        ]);
        $data['approved_by_hq'] = false;
        $enrollment = Enrollment::create($data);

        if ($request->has('payment_amount') && $request->filled('payment_amount')) {
            \App\Models\Payment::create([
                'payer_id'        => $data['student_id'],
                'campus_id'       => $data['campus_id'],
                'student_id'      => $data['student_id'],
                'amount'          => $data['payment_amount'],
                'type'            => 'tuition',
                'status'          => $data['payment_status'] ?? 'pending',
                'account_name'    => '',
                'bank_name'       => $data['payment_method'] ?? 'online',
                'account_number'  => '',
                'transaction_ref' => $data['transaction_ref'] ?? '',
                'notes'           => $data['notes'] ?? '',
                'is_hq_visible'   => true,
            ]);
        }

        return redirect()->route('enrollments.show',$enrollment)->with('success','Student enrolled.');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student','classData.module','campus','classData.records']);
        return $this->withOrg('enrollments.show', compact('enrollment'));
    }

    public function approve(Request $request, Enrollment $enrollment)
    {
        $enrollment->update([
            'approved_by_hq' => true,
            'status'         => 'enrolled',
        ]);
        return back()->with('success','Enrollment approved.');
    }

    public function reject(Request $request, Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'rejected',
        ]);
        return back()->with('success','Enrollment rejected.');
    }

    public function edit(Enrollment $enrollment)
    {
        $this->authorize('update', $enrollment);
        $classes = ClassRoom::all();
        $students = Student::all();
        $campuses = Campus::all();
        return $this->withOrg('enrollments.edit', compact('enrollment','classes','students','campuses'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $this->authorize('update', $enrollment);
        $data = $request->validate([
            'student_id'      => 'required|exists:students,id',
            'class_id'        => 'required|exists:class_rooms,id',
            'campus_id'       => 'required|exists:campuses,id',
            'enrollment_date' => 'required|date',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date',
            'payment_amount'  => 'nullable|numeric|min:0',
            'status'          => 'required|in:registered,enrolled,documents_verified,completed',
            'notes'           => 'nullable|string',
            'payment_method'  => 'nullable|in:cash,card,bkash,nagad,online',
            'payment_status'  => 'nullable|in:pending,completed,failed,refunded',
            'transaction_ref' => 'nullable|string|max:255',
        ]);
        $enrollment->update($data);
        return redirect()->route('enrollments.show', $enrollment)->with('success','Enrollment updated.');
    }
}
