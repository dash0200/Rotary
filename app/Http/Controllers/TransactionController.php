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
use Illuminate\Support\Facades\DB;
use PDF;

class TransactionController extends Controller
{
    // *************New Admission************************************************************************************************************************************************************************************
    public function newAdmission()
    {
        $id = AdmissionModel::select("id")->orderBy("id", "DESC")->withTrashed()->first();
        $id = $id == null ? 1 : $id->id + 1;

        $year = '';

        if((int)date("m") >= 4) {
            $crr = date("Y");
            $nxt = date("Y")[2].date("Y")[3];
            $year = $crr."-".(int)$nxt+1;
        } else {
            $crr = date("Y")-1;
            $nxt = date("Y")[2].date("Y")[3];
            $year = $crr."-".(int)$nxt;
        }

        $year = AcademicYearModel::where('year', $year)->first();

        return view('pages.transactions.new-admission')->with([
            'classes' => ClassesModel::get(),
            'states' => StatesModel::get(),
            'districts' => DistrictModel::select('id', 'name')->get(),
            'castes' => CasteModel::get(),
            'years' => AcademicYearModel::get(),
            'categories' => CategoriesModel::get(),
            'acaYear' => $year->id,
            "id" => $id,
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
        // dd($req->all());
        // $req->validate([
        //     'admDate' => ['required', 'date'],
        //     'class' => ['required', 'numeric', 'gt:0'],
        //     'fname' => ['required', 'regex:/^[\pL\s\-]+$/u'],
        // ]);

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

        $std = AdmissionModel::where("id", 'LIKE', '%'.$id.'%')->withTrashed()->first();

        $std['exist'] = LCModel::where("student", $std->id)->first();
        $std['exist'] = $std['exist'] == null ? "" : 1;

        $std['dob1'] = $std["dob"]->format("d-m-Y");
        return response()->json($std);
    } 

    public function getBysts(Request $req) {
        $id = $req->id;

        $std = AdmissionModel::where("sts", 'LIKE', '%'.$id.'%')->withTrashed()->first();

        $std['exist'] = LCModel::where("student", $std->id)->first();
        $std['exist'] = $std['exist'] == null ? "" : 1;

        $std['dob1'] = $std["dob"]->format("d-m-Y");
        return response()->json($std);
    } 

    public function getByName(Request $req) {

        if($req->year == null ) {
            $stds = AdmissionModel::withTrashed()->where("name", 'LIKE', '%'.strtolower($req->name).'%')->limit(10)->get();
            foreach($stds as $std) {
                $std['dob1'] = $std["dob"]->format("d-m-Y");
                $std['exist'] = LCModel::where("student", $std->id)->first();
                $std['exist'] = $std['exist'] == null ? "" : 1;
            }
            return response()->json($stds);
        } else {
            $stds = AdmissionModel::withTrashed()->where(["name"=> strtolower($req->name), "year"=>$req->year])->get();
            foreach($stds as $std) {
                $std['dob1'] = $std["dob"]->format("d-m-Y");
                $std['exist'] = LCModel::where("student", $std->id)->first();
                $std['exist'] = $std['exist'] == null ? "" : 1;
            }
            return response()->json($stds);
        }

        
    } 


    public function editStudent( Request $req) {

        $std = AdmissionModel::where("id", $req->id)->withTrashed()->first();

        if($std->district !== null) {
            $std['state'] = $std->district->state->state;
            $std['dist'] = $std->district->district;
        }

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
        $stds = AdmissionModel::withTrashed()->where('id', 'LIKE', '%'.$req->term.'%')->get();
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
        
        $prevClassStudents = CreateClass::select('create_class.year','create_class.standard','create_class.student as id', 'admission.name', 'academic_year.year', 'classes.name as current_class')
                    ->join('admission', 'create_class.student', '=', 'admission.id')
                    ->join('academic_year', 'create_class.year', '=', 'academic_year.id')
                    ->join('classes', 'create_class.standard', '=', 'classes.id')
                    ->where('create_class.year', $year - 1)->where('create_class.standard', $req->clas - 1)
                    ->get();

        $tuition = FeesDetailsModel::select("amt_per_annum")->where(["year" => $year, "class" => $req->clas])->first()->amt_per_annum;
        $y = date("Y");
        $yr = str_split($y);
        $y1 = $yr[2] . $yr[3];
        $year = $y . "-" . (int)$y1 + 1;

        $alreadyAddedStudents = CreateClass::select('create_class.year','create_class.standard','create_class.student as id', 'admission.name', 'academic_year.year')
                            ->join('admission', 'create_class.student', '=', 'admission.id')
                            ->join('academic_year', 'create_class.year', '=', 'academic_year.id')
                            ->where('create_class.year', $req->year)->where('create_class.standard', $req->clas)
                            ->get();

        $newAdmissions = AdmissionModel::select('admission.id', 'admission.name', 'admission.class', 'admission.year')
                        ->leftJoin('create_class', 'admission.id', '=', 'create_class.student')
                        ->whereNull('create_class.student')
                        ->where('admission.class', '>=', $req->clas)
                        ->get();
        
        foreach($newAdmissions as $new) {
            $new['class'] = $new->classes->name;
            $new['year'] = $new->acaYear->year;
        }

        return response()->json([
            "new" => $newAdmissions,
            "old" => $prevClassStudents,
            "totalAmt" => $tuition,
            "addedStd" => $alreadyAddedStudents
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
        
        $student = AdmissionModel::withTrashed()->where('id', $req->id)->first();
        $student['c'] = $student->classes;
        $student['year'] = $student->acaYear;
        $student['doy'] = $student->date_of_adm->format("d-m-Y");
        $student['dob1'] = $student->dob->format("d-m-Y");
        $standard = CreateClass::where("student", $req->id)->orderBy("id", "DESC")->first();

        $qualify = $standard == null ? '' : ClassesModel::where('id', $standard->standard + 1)->first();

        if($standard !== null) {
            $standard["std"] = $standard->standardClass;
            $standard['yr'] = $standard->acaYear;
        } else {
            $standard["std"] = '';
            $standard['yr'] = '';
        }

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
            AdmissionModel::where("id", $req->id)->delete();
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

        $lc = LCModel::select(
                    'lc.*', 'admission.id', 'admission.date_of_adm', 'admission.name', 
                    'admission.fname', 'admission.mname', 'admission.lname', 'admission.gender', 'admission.nationality', 'admission.religion',
                    'admission.caste', 'admission.sub_caste', 'admission.dob', 'admission.birth_place', 'admission.sub_district', 'admission.class',
                    'admission.sts'
                    )
                    ->join('admission', 'lc.student', '=', 'admission.id')
                    ->where('lc.student', $req->id)
                    ->first();

        $lc['district'] = '';
        $lc['gender'] = $lc->gender == 1 ? 'Male' : 'Female';

        $lc['studied_till'] = ClassesModel::where('id', $lc->studied_till)->first(['name'])->name;
        $lc['class'] = ClassesModel::where('id', $lc->class)->first(['name'])->name;
        $lc['till_aca_year'] = AcademicYearModel::where('id', $lc->till_aca_year)->first(['year'])->year;
        $lc['caste'] = $lc->caste == null ? '' : CasteModel::where('id', $lc->caste)->first(['name'])->name;

        $lc['lt'] = Carbon::createFromFormat('Y-m-d', $lc->lt)->format('d-m-Y');
        $lc['doa'] = Carbon::createFromFormat('Y-m-d', $lc->doa)->format('d-m-Y');
        $lc['doil'] = Carbon::createFromFormat('Y-m-d', $lc->doil)->format('d-m-Y');
        $lc['date_of_adm'] = Carbon::createFromFormat('Y-m-d', $lc->date_of_adm)->format('d-m-Y');

        $lc['sub_caste'] = $lc->sub_caste == null ? '' : SubcastModel::where('id', $lc->sub_caste)->first(['name'])->name;

        if($lc->sub_district != null) {
            $subid = SubdistrictModel::where('id', $lc->sub_district)->first(['district'])->district;
            $lc['district'] =  DistrictModel::where('id', $subid)->first(['name'])->name;
        }
        // dd($lc->dob);
        $dob = Carbon::createFromFormat('Y-m-d', $lc->dob);
     
        $getW = new Controller();
        $lc['dobWord'] = $getW->getWord($dob->format("d")) ."- ".$dob->format("F")." - ".$getW->getWord($dob->format("Y"));
        $lc['dob'] = Carbon::createFromFormat('Y-m-d', $lc->dob)->format('d-m-Y');
        // dd($lc);
        $pdf = PDF::loadView('pdfs.LC', ["lc" => $lc]);
        return $pdf->stream($lc->id.'.pdf');
    }

    public function printDuplicateLC(Request $req) {

        $lc = LCModel::select(
            'lc.*', 'admission.id', 'admission.date_of_adm', 'admission.name', 
            'admission.fname', 'admission.mname', 'admission.lname', 'admission.gender', 'admission.nationality', 'admission.religion',
            'admission.caste', 'admission.sub_caste', 'admission.dob', 'admission.birth_place', 'admission.sub_district', 'admission.class',
            'admission.sts'
            )
            ->join('admission', 'lc.student', '=', 'admission.id')
            ->where('lc.student', $req->id)
            ->first();

        $lc['district'] = '';
        $lc['gender'] = $lc->gender == 1 ? 'Male' : 'Female';

        $lc['studied_till'] = ClassesModel::where('id', $lc->studied_till)->first(['name'])->name;
        $lc['class'] = ClassesModel::where('id', $lc->class)->first(['name'])->name;
        $lc['till_aca_year'] = AcademicYearModel::where('id', $lc->till_aca_year)->first(['year'])->year;
        $lc['caste'] = $lc->caste == null ? '' : CasteModel::where('id', $lc->caste)->first(['name'])->name;

        $lc['lt'] = Carbon::createFromFormat('Y-m-d', $lc->lt)->format('d-m-Y');
        $lc['doa'] = Carbon::createFromFormat('Y-m-d', $lc->doa)->format('d-m-Y');
        $lc['doil'] = Carbon::createFromFormat('Y-m-d', $lc->doil)->format('d-m-Y');
        $lc['date_of_adm'] = Carbon::createFromFormat('Y-m-d', $lc->date_of_adm)->format('d-m-Y');

        $lc['sub_caste'] = $lc->sub_caste == null ? '' : SubcastModel::where('id', $lc->sub_caste)->first(['name'])->name;

        if($lc->sub_district != null) {
            $subid = SubdistrictModel::where('id', $lc->sub_district)->first(['district'])->district;
            $lc['district'] =  DistrictModel::where('id', $subid)->first(['name'])->name;
        }
        // dd($lc->dob);
        $dob = Carbon::createFromFormat('Y-m-d', $lc->dob);

        $getW = new Controller();
        $lc['dobWord'] = $getW->getWord($dob->format("d")) ."- ".$dob->format("F")." - ".$getW->getWord($dob->format("Y"));
        $lc['dob'] = Carbon::createFromFormat('Y-m-d', $lc->dob)->format('d-m-Y');
        $pdf = PDF::loadView('pdfs.LC', ["lc" => $lc, "duplicate" => "1"]);
        return $pdf->stream($lc->id.'.pdf');
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
            $stds = AdmissionModel::withTrashed()->where("name", 'LIKE', '%'.strtolower($req->name).'%',)
            ->limit(10)->get();
                foreach($stds as $std) {
                    $std['dob1'] = $std["dob"]->format("d-m-Y");
                }
                return response()->json($stds);
        } else {

            $stds = AdmissionModel::withTrashed()->where("name", 'LIKE', '%'.strtolower($req->name).'%',)
            ->orWhere("dob",'LIKE', '%'.strtolower($req->dob).'%',)
            ->limit(10)->get();
                foreach($stds as $std) {
                    $std['dob1'] = $std["dob"]->format("d-m-Y");
                }
                return response()->json($stds);
        }
     
    }

    public function autoAddclass() {
        $stds = AdmissionModel::where("date_of_adm", "LIKE", '%'.'2022'.'%')->where('class', 2)->get();
        dd($stds);
    }
}
