<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Finance;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $base = $this->campusOrHqQuery(Payment::class);

        $totalRevenue = clone $base;
        $pendingAmt   = clone $base;

        $payments = $base->with(['campus','payer','initiator'])
            ->when($request->filled('status'), fn($q)=>$q->where('status',$request->status))
            ->when($request->filled('campus_id') && auth()->user()?->hasRole('super_admin'),
                fn($q)=>$q->where('campus_id',$request->campus_id))
            ->latest()
            ->paginate(30);

        return $this->withOrg('finance.index', [
            'payments'  => $payments,
            'totalRevenue'=>$totalRevenue->where('status','completed')->sum('amount'),
            'pendingAmt'  => $pendingAmt->where('status','pending')->sum('amount'),
        ]);
    }

    public function createPayment()
    {
        $students = Student::orderBy('name')->get();
        $campuses = Campus::active()->get();
        return $this->withOrg('finance.create_payment', compact('students','campuses'));
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'payer_id'       => 'required|exists:students,id',
            'amount'         => 'required|numeric|min:0',
            'type'           => 'required|in:installation,one_time,partial,tution,other',
            'payment_method' => 'nullable|in:bank_transfer,cash,card,online',
            'installment_split'=> 'nullable|array|min:2',
            'notes'          => 'nullable|string',
        ]);

        $validated['initiated_by'] = auth()->id();
        Finance::create($validated);

        if ($request->filled('installment_split')) {
            foreach ($request->installment_split as $split) {
                Finance::create([
                    'payer_id'    => $validated['payer_id'],
                    'amount'      => $validated['amount'] / count($request->installment_split),
                    'type'        => $validated['type'],
                    'status'      => 'pending',
                    'initiated_by'=> auth()->id(),
                ]);
            }
        }

        return redirect()->route('finance.index')->with('success','Payment recorded.');
    }

    public function receipt($fin)
    {
        return $this->withOrg('finance-receipt', ['payment'=>Finance::findOrFail($fin)]);
    }
}
