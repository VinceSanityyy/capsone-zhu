<?php

namespace App\Http\Controllers;

use App\Models\PaymentReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
class PaymentReceiptController extends Controller
{
    public function generatePaymentReceipt()
    {
        $receipts = PaymentReceipt::with('user','researchPaper.adviser')->where('is_approved', true)->get();
        $totalAmount = $receipts->sum('amount');
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4');
        $pdf->loadView('receipt', compact('receipts','totalAmount'));   
        // return $pdf->stream();
        return $pdf->download('paymentReceipts.pdf');
    }
}
