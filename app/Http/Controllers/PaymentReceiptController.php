<?php

namespace App\Http\Controllers;

use App\Models\PaymentReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
class PaymentReceiptController extends Controller
{
    public function generatePaymentReceipt($stage)
    {
        $receipts = PaymentReceipt::with('user','researchPaper.adviser')
        ->where('stage_submitted', $stage)
        ->where('is_approved', true)->get();
        
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
