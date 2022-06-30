<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearModel;
use App\Models\AdmissionModel;
use App\Models\CasteModel;
use App\Models\CategoriesModel;
use App\Models\ClassesModel;
use App\Models\CreateClass;
use App\Models\DistrictModel;
use App\Models\StatesModel;
use App\Models\SubcastModel;
use App\Models\SubdistrictModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    // *************New Admission************************************************************************************************************************************************************************************
    public function newAdmission()
    {

        return view('pages.transactions.new-admission')->with([
            'classes' => ClassesModel::get(),
            'states' => StatesModel::get(),
            'districts' => DistrictModel::select('id', 'name')->get(),
            'castes' => CasteModel::get(),
            'years' => AcademicYearModel::get()
        ]);
    }
    public function getDistrict(Request $req)
    {
        $dist = DistrictModel::select('id', 'name')->where('state', $req->id)->get();


        foreach ($dist as $d) {
            $d['text'] = $d->name;
            unset($d['name']);
        }

        return response()->json($dist);
    }
    public function getTaluk(Request $req)
    {
        $taluk = SubdistrictModel::select('id', 'name')->where('district', $req->id)->get();


        foreach ($taluk as $d) {
            $d['text'] = $d->name;
            unset($d['name']);
        }

        return response()->json($taluk);
    }

    public function getCat(Request $req)
    {
        $cats = CasteModel::select('cat')->where('id', $req->cast)->get();

        $subcast = SubcastModel::select('id', 'name')->where('caste', $req->cast)->get();

        foreach ($cats as $d) {
            $d['category'] = $d->category->name;
        }
        return response()->json(['cats' => $cats, 'subcasts' => $subcast]);
    }
    public function saveAdmission(Request $req)
    {
        $req->validate([
            'admDate' => ['required', 'date'],
            'class' => ['required', 'numeric', 'gt:0'],
            'fname' => ['required', 'regex:/^[\pL\s\-]+$/u'],
        ]);

        $data = [
            "date_of_adm" => $req->admDate,
            "year" => $req->ac_year,
            "caste" => $req->caste,
            "sub_caste" => $req->subc,
            "category" => $req->cat,
            "class" => $req->class,
            "sts" => $req->sts,
            "name" => $req->fname,
            "fname" => $req->father,
            "mname" => $req->mname,
            "lname" => $req->surname,
            "address" => $req->address,
            "city" => $req->city,
            "phone" => $req->phone,
            "mobile" => $req->mobile,
            "dob" => $req->dob,
            "birth_place" => $req->birthPlace,
            "sub_district" => $req->taluk,
            "religion" => $req->religion,
            "nationality" => $req->nationaluty,
            "gender" => $req->gender,
            "handicap" => $req->handicap,
            "prev_school" => $req->prevSchool,
        ];
        AdmissionModel::create($data);

        return redirect()->back()->with(["message" => "success"]);
    }
    // *************New Admission***************


    //*********************Creating Class*************************************************************************************************************************************************
    public function creatingClasses()
    {
        return view('pages.transactions.creating-classes')->with([
            'years' => AcademicYearModel::get(), 
            'classes' => ClassesModel::get()
        ]);
    }

    public function getCurrentClass(Request $req) {
        $year = $req->year;
        $crStudents = CreateClass::where(["year" => $year, "standard" => $req->clas]);

        $newAdmission = AdmissionModel::get();
        return response()->json([
            "new" => $newAdmission,
            "old" => $crStudents
        ]);
        
    }
    //*********************Creating Class*******************


    //*********************Leaving Certificate***************************************************************************************************************************************************************************
    public function leavingCertificate()
    {
        return view('pages.transactions.leaving-certificate');
    }
    //*********************Leaving Certificate*******************

    //*********************Get Student ID*************************************************************************************************************************************
    public function getStudentId()
    {
        return view('pages.transactions.get-student-id');
    }
}
