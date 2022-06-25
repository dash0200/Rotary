<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearModel;
use App\Models\ClassesModel;
use App\Models\FeesDetailsModel;
use App\Models\FeesHeadModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MastersController extends Controller
{
    //************** Fee Head** ***************
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
     //************** Fee Head** ***************

     
     //************** Fee Details*****************
    public function feesDetails() {
        $academicYear = AcademicYearModel::get();
        $classes = ClassesModel::get();
        $fees = FeesHeadModel::orderBy('id')->get();
        return view("pages.masters.fees-details")->with(['years' => $academicYear, 'classes' => $classes, 'fees' => $fees]);
    }

    public function saveDetails(Request $req) {
        try {
            foreach($req->fees as $id) {
                $isExist = FeesDetailsModel::where([
                    'year' => $req->year,
                    'fee_head' => $id,
                    'class' => $req->clas
                ])->first();
                if($isExist == null ){
                    FeesDetailsModel::create([
                        'year' => $req->year,
                        'fee_head' => $id,
                        'class' => $req->clas
                    ]);
                }
                
            }
            return response()->json(['msg' => "success"]);
        } catch (Exception $e)  {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getDetails(Request $req) {
      $feeDetails = FeesDetailsModel::where(['year' => $req->year, 'class' => $req->clas])->orderBy('id')->get();
      
      return response()->json(['feeDetails' =>$feeDetails ]);
    }
 //************** Fee Details** ***************


 //************** Fee Details** ***************
    public function castDetails() {
       
        return view("pages.masters.cast-details");
    }
//************** Fee Details** ***************
}
