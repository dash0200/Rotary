<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeesDetailsController extends Controller
{
    public function feesReceipts() {
        return view('pages.fees.fees-receipts');
    }
    public function receiptCancellation() {
        return view('pages.fees.receipt-cancellation');
    }
    public function feesArrears() {
        return view('pages.fees.fees-arrears');
    }
    public function dayBook() {
        return view('pages.fees.day-book');
    }
    public function feesRegister() {
        return view('pages.fees.fees-register');
    }
    public function receiptDatewise() {
        return view('pages.fees.receipt-datewise');
    }
    public function duplicateReceipt() {
        return view('pages.fees.duplicate-receipt');
    }
}
