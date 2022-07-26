<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearModel;
use App\Models\AdmissionModel;
use App\Models\CasteModel;
use App\Models\CategoriesModel;
use App\Models\ClassesModel;
use App\Models\CreateClass;
use App\Models\DistrictModel;
use App\Models\FeesDetailsModel;
use App\Models\StatesModel;
use App\Models\SubcastModel;
use App\Models\SubdistrictModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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

    public function getStdforEdit(Request $req) {
        $stds = AdmissionModel::where('id', 'LIKE', '%'.$req->term.'%')->get();
        return response()->json([
            'stds' => $stds
        ]);
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

    public function getCurrentClass(Request $req)
    {
        $year = $req->year;
        $crStudents = CreateClass::where(["year" => $year - 1, "standard" => $req->clas - 1])->get();

        foreach ($crStudents as $crr) {
            $crr->getStudent;
            $crr->acaYear;
            $crr->standardClass;
        }

        $tuition = FeesDetailsModel::select("amt_per_annum")->where(["year" => $year, "class" => $req->clas])->first()->amt_per_annum;
        $y = date("Y");
        $yr = str_split($y);
        $y1 = $yr[2] . $yr[3];
        $year = $y . "-" . (int)$y1 + 1;

        $added = CreateClass::where(["year" => $req->year, "standard" => $req->clas])->get();
        foreach ($added as $std) {
            $std->getStudent;
            $std->acaYear->year;
        }

        // $year_id = AcademicYearModel::where("year",  $year)->first()->id;
        $createClass = CreateClass::get();
        $newAdmission = AdmissionModel::where("year", $req->year)->get();

        foreach ($createClass as $cr) {
            foreach ($newAdmission as $new) {
                $new->acaYear;
                if ($cr->student == $new->id) {
                    $new['id'] = null;
                }
            }
        }

        foreach($newAdmission as $new) {
            $new['aca_year'] = $new->acaYear;
        }

        return response()->json([
            "new" => $newAdmission,
            "old" => $crStudents,
            "totalAmt" => $tuition,
            "addedStd" => $added
        ]);
    }

    public function createClass(Request $req)
    {

        foreach ($req->stds as $std) {
            $data = [
                "year" => $req->year,
                "standard" => $req->clas,
                "student" => $std["id"],
                "total" => $req->amt,
                "balance" => $req->amt,
            ];
            $exist = CreateClass::where($data)->first();

            if ($exist == null) {
                CreateClass::create($data);
            }
        }

        return response()->json(['msg' => 'success']);
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
