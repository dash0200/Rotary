<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearModel;
use App\Models\AdmissionModel;
use App\Models\ClassesModel;
use App\Models\CreateClass;
use App\Models\StudyCertificate;
use Illuminate\Http\Request;
use PDF;

class CertificateController extends Controller
{
    public function certificate() {

        return view('pages.certificate.certificate')->with(['years' => AcademicYearModel::get()]);
    }

        public function studyCertificate(Request $req) {

            $exist = StudyCertificate::where("student", $req->id)->first();
            $print = false;

            if($exist !== null) {
                $print = true;
            }


            $student = AdmissionModel::where("id", $req->id)->first();

            $std_from = CreateClass::where("student", "$req->id")->orderBy('id', 'ASC')->first();
            $from_year = $std_from->acaYear->year;
            $std_from = $std_from->standardClass->name;

            $std_to = CreateClass::where("student", "$req->id")->orderBy('id', 'DESC')->first();
            $to_year = $std_to->acaYear->year;
            $std_to = $std_to->standardClass->name;
            
            $caste = $student->stdCast->name;
            $subCaste = $student->subCaste == null ? '-' : $student->subCaste->name;
            
            return view("pages.certificate.study")->with([
                "student" => $student,
                "std_from" => $std_from,
                "std_to" => $std_to,
                "from_year" => $from_year,
                "to_year" => $to_year,
                "caste" => $caste,
                "subCaste" => $subCaste,
                'classes' => ClassesModel::get(),
                'years' => AcademicYearModel::get(),
                "print" => $print
            ]);
        }

        public function saveStudyCertificate(Request $req) {
            $data = [
                "student"=>$req->id,
                "from_stdy"=>$req->from_year,
                "to_stdy"=>$req->to_year,
                "from_year"=>$req->std_from,
                "to_year"=>$req->std_to,
                "mother_lang"=>$req->mt,
            ];

            $exist = StudyCertificate::where("student", $req->id)->first();

            if($exist == null) {
                StudyCertificate::create($data);
            } else {
                StudyCertificate::where("student", $req->id)->update($data);
            }

            return response()->json([
                'msg' => 'success'
            ]);

        }

        public function pdfStudyCertificate(Request $req) {

            $stdcert = StudyCertificate::where("student", $req->id)->first();
 
            $pdf = PDF::loadView('pdfs.study', ["study" => $stdcert]);
            return $pdf->stream($stdcert->student.'.pdf');
        }

        public function bonafiedCertificate(Request $req) {
            
            return view("pages.certificate.bonafied");
        }

        public function casteCertificate(Request $req) {
            
            return view("pages.certificate.caste");
        }
        
        public function characterCertificate(Request $req) {
            
            return view("pages.certificate.character");
        }

        public function certificateCertificate(Request $req) {
            
            return view("pages.certificate.certify");
        }
}
