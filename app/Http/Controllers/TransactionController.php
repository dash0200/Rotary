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
use App\Models\LCModel;
use App\Models\StatesModel;
use App\Models\SubcastModel;
use App\Models\SubdistrictModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

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
            'years' => AcademicYearModel::get(),
            "id" => AdmissionModel::select("id")->orderBy("id", "DESC")->first()->id + 1,
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
            "sts" => strtolower($req->sts),
            "name" => strtolower($req->fname),
            "fname" => strtolower($req->father),
            "mname" => strtolower($req->mname),
            "lname" => strtolower($req->surname),
            "address" => strtolower($req->address),
            "city" => strtolower($req->city),
            "phone" => $req->phone,
            "mobile" => $req->mobile,
            "dob" => $req->dob,
            "birth_place" => strtolower($req->birthPlace),
            "sub_district" => $req->taluk,
            "religion" => strtolower($req->religion),
            "nationality" => $req->nationaluty,
            "gender" => $req->gender,
            "handicap" => $req->handicap,
            "prev_school" => strtolower($req->prevSchool),
        ];

        if(isset($req->id)) {
            AdmissionModel::where("id", $req->id)->update($data);
        } else {
            AdmissionModel::create($data);
        }

        return redirect()->route("trans.newAdmission");
    }

    public function editPage() {

        return view("pages.transactions.edit-student")->with([
            'classes' => ClassesModel::get(),
            'years' => AcademicYearModel::get()
        ]);
    }

    public function getByID(Request $req) {
        $id = $req->id;

        $std = AdmissionModel::where("id", 'LIKE', '%'.$id.'%')->first();
        $std['dob1'] = $std["dob"]->format("d-m-Y");
        return response()->json($std);
    } 

    public function getBysts(Request $req) {
        $id = $req->id;

        $std = AdmissionModel::where("sts", 'LIKE', '%'.$id.'%')->first();
        $std['dob1'] = $std["dob"]->format("d-m-Y");
        return response()->json($std);
    } 

    public function getByName(Request $req) {

        if($req->year == null ) {
            $stds = AdmissionModel::where("name", 'LIKE', '%'.strtolower($req->name).'%')->limit(10)->get();
            foreach($stds as $std) {
                $std['dob1'] = $std["dob"]->format("d-m-Y");
            }
            return response()->json($stds);
        } else {
            $stds = AdmissionModel::where(["name"=> strtolower($req->name), "year"=>$req->year])->get();
            foreach($stds as $std) {
                $std['dob1'] = $std["dob"]->format("d-m-Y");
            }
            return response()->json($stds);
        }

        
    } 


    public function editStudent( Request $req) {

        $std = AdmissionModel::where("id", $req->id)->first();

        $std['state'] = $std->district->state->state;
        $std['dist'] = $std->district->district;

        $std['doa'] = $std->date_of_adm->format("Y-m-d");
        $std['dob1'] = $std->dob->format("Y-m-d");
        $std['districts'] = DistrictModel::where("state", $std['state'])->get();
        $std['sub_districts'] = SubdistrictModel::where("district", $std['dist'])->get();

        $std["sub_castes"] = SubcastModel::where("caste", $std->caste)->get();

        return view("pages.transactions.edit-admission")->with([
            'classes' => ClassesModel::get(),
            'categories'  => CategoriesModel::get(),
            'states' => StatesModel::get(),
            'districts' => DistrictModel::select('id', 'name')->get(),
            'castes' => CasteModel::get(),
            'years' => AcademicYearModel::get(),
            "std" => $std
        ]);
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
            $new['standard'] = $new->classes;
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

    public function getStuddent(Request $req) {
        
        $student = AdmissionModel::where('id', $req->id)->first();
        $student['c'] = $student->classes;
        $student['year'] = $student->acaYear;
        $student['doy'] = $student->date_of_adm->format("d-m-Y");
        $student['dob1'] = $student->dob->format("d-m-Y");

        $standard = CreateClass::where("student", $req->id)->orderBy("id", "DESC")->first();

        $qualify = ClassesModel::where('id', $standard->standard + 1)->first();

        $standard["std"] = $standard->standardClass;
        $standard['yr'] = $standard->acaYear;



        return response()->json([$student, $standard, $qualify]);
    }

    public function leavingCertificate()
    {
        return view('pages.transactions.leaving-certificate')->with([
            'years' => AcademicYearModel::get(),
            'classes' => ClassesModel::get()
        ]);
    }

    public function saveLc(Request $req) {
        
        $data = [
            "student" => $req->id,
            "studied_till" => $req->stdTill,
            "till_aca_year" => $req->tillYear,
            "was_studying" => $req->wasStd,
            "whether_qualified" => $req->qualified,
            "lt" => $req->la,
            "doa" => Carbon::parse($req->doa)->format("Y-m-d"),
            "doil" => $req->doi,
            "reason" => $req->reason,
        ];

        if( LCModel::where("student", $req->id)->first() == null ) {
            LCModel::create($data);
        } else {
            LCModel::where("student", $req->id)->update($data);
        }

        return response()->json(["msg" => "success"]);
        
    }

    public function searchLC() {
        return view("pages.transactions.search-lc")->with([
            'classes' => ClassesModel::get(),
            'years' => AcademicYearModel::get()
        ]);
    }

    public function printLC(Request $req) {

        $lc = LCModel::where("student", $req->id)->first();

        $lc['student'] = $lc->studentDetails;
        $lc['studied_till'] = $lc->studiedTill;
        $lc['till_aca_year'] = $lc->tillYear;
        $lc['caste'] = $lc->studentDetails->stdCast;
        $lc['subCaste'] = $lc->studentDetails->subCaste;
        $lc['subDistrict'] = $lc->studentDetails->subDistrict;
        $lc['classes'] = $lc->studentDetails->classes;
        $lc['dobWord'] = Controller::getWord($lc->student->dob->format("d")) ."- ".$lc->student->dob->format("F")." - ".Controller::getWord($lc->student->dob->format("Y"));

        $pdf = PDF::loadView('pdfs.LC', ["lc" => $lc]);
        return $pdf->stream($lc->student.'.pdf');
    }

    //*********************Leaving Certificate*******************

    //*********************Get Student ID*************************************************************************************************************************************
    public function getStudentId()
    {
        return view('pages.transactions.get-student-id')->with([
            'classes' => ClassesModel::get(),
            'years' => AcademicYearModel::get()
        ]);
    }

    public function getByInfo(Request $req) {
      
        if($req->dob == null) {

            $stds = AdmissionModel::where("name", 'LIKE', '%'.strtolower($req->name).'%',)
            ->orWhere("fname", 'LIKE', '%'.strtolower($req->fname).'%',)
            ->orWhere("lname",'LIKE', '%'.strtolower($req->lname).'%',)
            ->limit(10)->get();
                foreach($stds as $std) {
                    $std['dob1'] = $std["dob"]->format("d-m-Y");
                }
                return response()->json($stds);
        } else {

            $stds = AdmissionModel::where("name", 'LIKE', '%'.strtolower($req->name).'%',)
            ->orWhere("fname", 'LIKE', '%'.strtolower($req->fname).'%',)
            ->orWhere("lname",'LIKE', '%'.strtolower($req->lname).'%',)
            ->orWhere("dob",'LIKE', '%'.strtolower($req->dob).'%',)
            ->limit(10)->get();
                foreach($stds as $std) {
                    $std['dob1'] = $std["dob"]->format("d-m-Y");
                }
                return response()->json($stds);
        }
     
    }
}
