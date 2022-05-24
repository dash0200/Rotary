<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralReceiptController extends Controller
{
    public function generalReceipts() {
        return view('pages.general-receipts.general-receipts');
    }
    public function dayBook() {
        return view('pages.general-receipts.day-book');
    }
    public function datewise() {
        return view('pages.general-receipts.datewise');
    }
}
