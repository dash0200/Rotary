<?php

namespace App\Http\Controllers;

use App\Models\FeesHeadModel;
use Exception;
use Illuminate\Http\Request;

class MastersController extends Controller
{
    public function  saveFeesDesc(Request $req) {

        $req->validate([
            'description' => ['required', 'unique:fees_heads,desc']
        ]);

       try {
            FeesHeadModel::create(['desc' => $req->desc]);
            return response()->json(['msg' => 'success']);
       } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);        
       }
    }

    public function getFeesDesc()  {

        try {
            return response()->json(['fees' => FeesHeadModel::get()]);
        } catch (Exception $e)  {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function feeDelete(Request $req) {
        try {
            FeesHeadModel::where('id', $req->id)->delete();
            return response()->json(['msg' => "success"]);
        } catch (Exception $e)  {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function feesDetails() {

        return view("pages.masters.fees-details");
    }

    public function castDetails() {

        return view("pages.masters.cast-details");
    }
}
