<?php

namespace App\Http\Controllers;

use App\Models\CasteModel;
use App\Models\CategoriesModel;
use App\Models\ClassesModel;
use App\Models\DistrictModel;
use App\Models\StatesModel;
use App\Models\SubdistrictModel;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // *************New Admission***************
    public function newAdmission()
    {

        return view('pages.transactions.new-admission')->with([
            'classes' => ClassesModel::get(),
            'states' => StatesModel::get(),
            'districts' => DistrictModel::select('id','name')->get(),
            'castes' => CasteModel::get()
        ]);
    }
    public function getDistrict(Request $req)
    {
        $dist = DistrictModel::select('id','name')->where('state', $req->id)->get();


        foreach ($dist as $d) {
            $d['text'] = $d->name;
            unset($d['name']);
        }

        return response()->json($dist);
    }
    public function getTaluk(Request $req)
    {
        $taluk = SubdistrictModel::select('id','name')->where('district', $req->id)->get();


        foreach ($taluk as $d) {
            $d['text'] = $d->name;
            unset($d['name']);
        }

        return response()->json($taluk);
    }

    public function getCat(Request $req)
    {
        $cats = CasteModel::select('cat')->where('name', $req->cast)->get();

        foreach ($cats as $d) {
            $d['text'] = $d->category->name;
        }
        return response()->json($cats);
    }
    // *************New Admission***************


    //*********************Creating Class*******************
    public function creatingClasses()
    {
        return view('pages.transactions.creating-classes');
    }
    //*********************Creating Class*******************


    //*********************Leaving Certificate*******************
    public function leavingCertificate()
    {
        return view('pages.transactions.leaving-certificate');
    }
    //*********************Leaving Certificate*******************

    //*********************Get Student ID*******************
    public function getStudentId()
    {
        return view('pages.transactions.get-student-id');
    }
}
