<?php

namespace App\Http\Controllers;

use App\Models\CreateClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeesDetailsController extends Controller
{
    public function feesReceipts() {
        return view('pages.fees.fees-receipts');
    }

    public function feePaying(Request $req) {

        Validator::make($req->all(), [
                "id" => ["required", "numeric"],
                "annualFee" => ["required", "numeric"],
                "feesPaid" => ["required", "numeric"],
                "balance" => ["required", "numeric"],
                "paying" => ["required", "numeric"],
        ])->validate();

        $paying = $req->paying + $req->feesPaid;
        $balance = $req->annualFee - $paying;
        
        if(CreateClass::where("id", $req->id)->update([
            "paid" =>$paying,
            "balance" => $balance
           ]) > 0) {
            return response()->json(["msg" => "success"]);
        } else {
            return response()->json(["msg" => "failed"]);
        }

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
