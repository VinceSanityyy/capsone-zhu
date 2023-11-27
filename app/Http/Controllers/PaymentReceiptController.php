<?php

namespace App\Http\Controllers;

use App\Models\PaymentReceipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
class PaymentReceiptController extends Controller
{
    public function generatePaymentReceipt($stage, $from, $to)
    {
        $from = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
        $to = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
        // dd($from, $to);
        $receipts = PaymentReceipt::with('user','researchPaper.adviser')
        ->where('stage_submitted', $stage)
        ->where('is_approved', true)
        ->whereBetween('created_at', [$from, $to])
        ->get();
        $totalAmount = $receipts->sum('amount');
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4');

        $stage = strtoupper(str_replace('_', ' ', $stage));
        $pdf->loadView('student-receipts', compact('receipts','totalAmount', 'stage'));
        return $pdf->stream('paymentReceipts.pdf');
    }

    public function generateFinalAdviserFee()
    {
        $advisers = PaymentReceipt::with('user','researchPaper.adviser')
            ->where('is_approved', true)
            ->where('stage_submitted', 'final_submission')
            ->get()
            ->groupBy(function ($receipt) {
                return $receipt->researchPaper->adviser->name; 
            })
            ->map(function ($adviserReceipts) {
                return [
                    'name' => $adviserReceipts->first()->researchPaper->adviser->name,
                    'amount' => $adviserReceipts->sum('amount'),
                ];
            })
            ->values();
       
        $adviserTotalAmount = $advisers->sum('amount');

        $students = PaymentReceipt::with('user','researchPaper.adviser')
            ->where('stage_submitted', 'final_submission')
            ->where('is_approved', true)
            ->get();

        $studentTotalAmount = $students->sum('amount');
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4');
        $pdf->loadView('receipt', compact('advisers','students', 'adviserTotalAmount', 'studentTotalAmount')); 
        
        return $pdf->stream('paymentReceipts.pdf');
    }
}
