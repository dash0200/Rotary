<?php

namespace App\Http\Controllers;

use App\Models\FeesHeadsModel;
use App\Models\MetaDataModel;
use Illuminate\Http\Request;

class MastersController extends Controller
{
    // ****Fees Heads
    public function feesHeads() {

        return view("pages.masters.fees-heads");
    }

    public function getFeeDescription() {

        $description = FeesHeadsModel::get();

        return response()->json(['desc' => $description]);

    }

    public function saveFeeDescription(Request $request) {

        $request->validate([
            'description'  => ['required',"min:2", 'unique:fees_heads,description'],
        ]);

        $insertIntoFeesHeads = FeesHeadsModel::create([
            'description' => $request->description
        ]);

        if(isset($insertIntoFeesHeads->id)) {
            return response()->json(['msg' => 1]);
        } else {
            return response()->json(['msg' => 0]);
        }

    }

    // Fees Heads****

    
    // ****Fees Details
    public function feesDetails() {

        return view("pages.masters.fees-details");
    }
    // Fees Details**** 
    
    // ****Cast Details
    public function castDetails() {

        return view("pages.masters.cast-details");
    }
    // Cast Details****
}
