<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearModel;
use App\Models\CasteModel;
use App\Models\CategoriesModel;
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
            FeesHeadModel::create(['desc' => $req->description]);
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

    // public function feeDelete(Request $req) {
    //     try {
    //         FeesHeadModel::where('id', $req->id)->delete();
    //         return response()->json(['msg' => "success"]);
    //     } catch (Exception $e)  {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }
    
    public function  updateFee(Request $req) {
        try {
            FeesHeadModel::where(['id' => $req->id])->update(['desc' => $req->val]);
            return response()->json(['msg' => "success"]);
        } catch (Exception $e) {
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
                $exist = FeesDetailsModel::where([
                    'year' => $req->year,
                    'fee_head' => $id,
                    'class' => $req->clas
                ])->first();
                if($exist == null ){
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


 //************** Fee caste** ***************
    public function castDetails() {
       
        return view("pages.masters.cast-details")->with(['cats' => CategoriesModel::get(), 'castes' => CasteModel::get()]);
    }

    public function saveCategory(Request $req) {
        try {
            CategoriesModel::create(['name' => $req->name]);
            return response()->json(['msg' => "success"]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getCategories() {
        return response()->json(['cats' => CategoriesModel::get()]);
    }

    public function updateCat(Request $req) {
        try {
            CategoriesModel::where(['id' => $req->id])->update(['name' => $req->val]);
            return response()->json(['msg' => "success"]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function saveCaste(Request $req) {
        
        try {

            $exist = CasteModel::where([
                'cat' => $req->cat,
                'name' => $req->caste
            ])->first();

            if($exist == null) {
                CasteModel::create([
                    'cat' => $req->cat,
                    'name' => $req->caste
                ]);
            }
            return response()->json(['msg' => "success"]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function searchCast(Request $req) {
        $cast = [];
        if($req->cast == null || $req->cast == "") {
            $casts = CasteModel::where('cat',$req->cat)->orWhere('name' ,'LIKE', '%'.$req->cast.'%')->limit(10)->get();
        } else {
            $casts = CasteModel::where('cat',$req->cat)->orWhere('name' ,'LIKE', '%'.$req->cast.'%')->get();
        }
        foreach($casts as $cast) {
            $cast['cat'] = $cast->category;
        }
       return response()->json(['casts' => $casts]);
    }
//************** Fee Caste** ***************
}
