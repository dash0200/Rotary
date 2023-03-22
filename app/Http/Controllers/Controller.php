<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearModel;
use App\Models\AdmissionModel;
use App\Models\ClassesModel;
use App\Models\CreateClass;
use App\Models\DistrictModel;
use App\Models\FeesDetailsModel;
use App\Models\StatesModel;
use App\Models\SubdistrictModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use LDAP\Result;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function getWord(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees : '') . $paise;
    }

    public function getStuddent(Request $req)
    {

        $student = AdmissionModel::where('id', $req->id)->withTrashed()->first();
        $student['doy'] = $student->date_of_adm->format("Y");
        $student['dob1'] = $student->dob->format("d-m-Y");

        $standard = CreateClass::where("student", $req->id)->orderBy("id", "DESC")->first();
        $fees = FeesDetailsModel::select("fee_head", "amount")->where(["year" => $standard->year, "class" => $standard->standard])->get();

        foreach ($fees as $fee) {
            $fee["name"] = $fee->feeHead->desc;
        }

        $standard["std"] = $standard->standardClass;
        $standard['yr'] = $standard->acaYear;

        $stds = CreateClass::where("student", $req->id)->orderBy("id", "DESC")->get();

        foreach ($stds as $std) {

            $std['fees'] = FeesDetailsModel::select("fee_head", "amount")->where(["year" => $std->year, "class" => $std->standard])->get();

            foreach ($std['fees'] as $fee) {
                $fee["name"] = $fee->feeHead->desc;
            }

            $std["std"] = $std->standardClass;
            $std["yr"] = $std->acaYear;
        }

        return response()->json([$student, $standard, $fees, "prev" => $stds]);
    }

    public function getStdId(Request $req)
    {
        if (!isset($req->term)) {
            return response()->json();
        }
        $q = $req->term;

        $students = AdmissionModel::select('id', 'date_of_adm', 'sts', 'name', 'fname', 'mname', 'lname')->where("name", "LIKE", "%" . $q . "%")
            ->orWhere("fname", "LIKE", "%" . $q . "%")
            ->orWhere("mname", "LIKE", "%" . $q . "%")
            ->orWhere("lname", "LIKE", "%" . $q . "%")
            ->orWhere("id", "LIKE", "%" . $q . "%")
            ->orWhere("date_of_adm", "LIKE", "%" . $q . "%")
            ->orWhere("sts", "LIKE", "%" . $q . "%")
            ->limit(10)->withTrashed()->get();

        $student = array();

        foreach ($students as $std) {
            $student[] = array(
                'id' => $std->id,
                'text' => $std->id . "-" . $std->sts . ", " . $std->name . " " . $std->fname . " " . $std->lname . ", (" . $std->date_of_adm->format("d-m-Y") . ")"
            );
        }
        return response()->json($student);
    }

    public function getAdmStd(Request $req)
    {
        $student = AdmissionModel::where("id", $req->id)->withTrashed()->first();
        $student["doy"] = $student->date_of_adm->format("Y-m-d");
        $student["dobf"] = $student->dob->format("Y-m-d");

        $student['state'] = $student->district->state->state;
        $student['dist'] = $student->district->district;

        return response()->json($student);
    }

    public function dashboard()
    {

        $totalStudents = AdmissionModel::get()->count();

        $nurseryStudents = CreateClass::where("standard", 1)->get()->count();

        $year = '';

        if ((int)date("m") >= 6) {
            $crr = date("Y");
            $nxt = date("Y")[2] . date("Y")[3];
            $year = $crr . "-" . (int)$nxt + 1;
        } else {
            $crr = date("Y") - 1;
            $nxt = date("Y")[2] . date("Y")[3];
            $year = $crr . "-" . (int)$nxt;
        }

        $year = AcademicYearModel::where('year', $year)->first();

        $nurseryStudents = CreateClass::where(["standard" => 1, 'year' => $year->id])->get()->count();
        $lkgStudents = CreateClass::where(["standard" => 2, 'year' => $year->id])->get()->count();
        $ukgStudents = CreateClass::where(["standard" => 3, 'year' => $year->id])->get()->count();
        $firstStudents = CreateClass::where(["standard" => 4, 'year' => $year->id])->get()->count();
        $secondStudents = CreateClass::where(["standard" => 5, 'year' => $year->id])->get()->count();
        $thirdStudents = CreateClass::where(["standard" => 6, 'year' => $year->id])->get()->count();
        $fourthStudents = CreateClass::where(["standard" => 7, 'year' => $year->id])->get()->count();
        $fifthStudents = CreateClass::where(["standard" => 8, 'year' => $year->id])->get()->count();
        $sixthStudents = CreateClass::where(["standard" => 9, 'year' => $year->id])->get()->count();
        $seventhStudents = CreateClass::where(["standard" => 10, 'year' => $year->id])->get()->count();
        $eighthStudents = CreateClass::where(["standard" => 11, 'year' => $year->id])->get()->count();
        $ninethStudents = CreateClass::where(["standard" => 12, 'year' => $year->id])->get()->count();
        $tenthStudents = CreateClass::where(["standard" => 12, 'year' => $year->id])->get()->count();

        $totalStudentThisYear = CreateClass::where(["year" => $year->id])->count();

        return view('dashboard')->with([
            "students" => $totalStudents,

            'nursery' => $nurseryStudents,
            "lkg" => $lkgStudents,
            "ukg" => $ukgStudents,
            "first" => $firstStudents,
            "second" => $secondStudents,
            "third" => $thirdStudents,
            "fourth" => $fourthStudents,
            "fifth" => $fifthStudents,
            "sixth" => $sixthStudents,
            "seventh" => $seventhStudents,
            "eighth" => $eighthStudents,
            "nineth" => $ninethStudents,
            "tenth" => $tenthStudents,

            "year" => $year->year,

            'totalStudentThisYear' => $totalStudentThisYear
        ]);
    }

    public function getCurrentAcadmicYear()
    {

        $crr = date("Y");
        $nxt = date("Y")[2] . date("Y")[3];
        $year = $crr . "-" . (int)$nxt + 1;
        return $year;
    }

    public function moneyFormatIndia($num)
    {
        $explrestunits = "";
        if (strlen($num) > 3) {
            $lastthree = substr($num, strlen($num) - 3, strlen($num));
            $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
            $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for ($i = 0; $i < sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if ($i == 0) {
                    $explrestunits .= (int)$expunit[$i] . ","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i] . ",";
                }
            }
            $thecash = $explrestunits . $lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }

    public function state()
    {
        $states = [
            'ಆಂಧ್ರ ಪ್ರದೇಶ',
            'ಅರುಣಾಚಲ ಪ್ರದೇಶ',
            'ಅಸ್ಸಾಂ',
            'ಬಿಹಾರ',
            'ಛತ್ತೀಸ್‌ಗಢ',
            'ಗೋವಾ',
            'ಗುಜರಾತ್',
            'ಹರಿಯಾಣ',
            'ಹಿಮಾಚಲ ಪ್ರದೇಶ',
            'ಜಾರ್ಖಂಡ್',
            'ಕರ್ನಾಟಕ',
            'ಕೇರಳ',
            'ಮಧ್ಯ ಪ್ರದೇಶ',
            'ಮಹಾರಾಷ್ಟ್ರ',
            'ಮಣಿಪುರ',
            'ಮೇಘಾಲಯ',
            'ಮಿಜೋರಾಂ',
            'ನಾಗಾಲ್ಯಾಂಡ್',
            'ಒಡಿಶಾ',
            'ಪಂಜಾಬ್',
            'ರಾಜಸ್ಥಾನ',
            'ಸಿಕ್ಕಿಂ',
            'ತಮಿಳುನಾಡು',
            'ತೆಲಂಗಾಣ',
            'ತ್ರಿಪುರ',
            'ಉತ್ತರ ಪ್ರದೇಶ',
            'ಉತ್ತರಾಖಂಡ ಡೆಹ್ರಾಡೂನ್',
            'ಗೈರ್ಸೈನ್',
            'ಪಶ್ಚಿಮ ಬಂಗಾಳ',
        ];

        for ($i = 0; $i < count($states); $i++) {
            $s = StatesModel::where('name', $states[$i])->first();

            if ($s == null) {
                StatesModel::create(['name' => $states[$i]]);
            }
        }

        return redirect()->back();
    }

    public function district()
    {
        $district = [
            'ಬಾಗಲಕೋಟೆ',
            'ಬಳ್ಳಾರಿ',
            'ಬೆಳಗಾವಿ',
            'ಬೆಂಗಳೂರು',
            'ಬೆಂಗಳೂರು2',
            'ಬೀದರ್',
            'ಚಾಮರಾಜನಗರ',
            'ಚಿಕ್ಕಬಳ್ಳಾಪುರ',
            'ಚಿಕ್ಕಮಗಳೂರು',
            'ಚಿತ್ರದುರ್ಗ',
            'ದಕ್ಷಿಣ ಕನ್ನಡ',
            'ದಾವಣಗೆರೆ',
            'ಧಾರವಾಡ',
            'ಗದಗ',
            'ಹಾಸನ',
            'ಹಾವೇರಿ',
            'ಕಲಬುರಗಿ',
            'ಕೊಡಗು',
            'ಕೋಲಾರ',
            'ಕೊಪ್ಪಳ',
            'ಮಂಡ್ಯ',
            'ಮೈಸೂರು',
            'ರಾಯಚೂರು',
            'ರಾಮನಗರ',
            'ಶಿವಮೊಗ್ಗ',
            'ತುಮಕೂರು',
            'ಉಡುಪಿ',
            'ಉತ್ತರ ಕನ್ನಡ',
            'ವಿಜಯಪುರ',
            'ಯಾದಗಿರಿ',
            'ಬೆಂಗಳೂರು ಗ್ರಾಮಾಂತರ',
            'ಬೆಂಗಳೂರು ನಗರ',
            'ಹುಬ್ಬಳ್ಳಿ',
            'ಗದಗ',
            'ಹಾಸನ',
            'ಹಾವೇರಿ',
            'ಕಲಬುರಗಿ (ಗುಲ್ಬರ್ಗ)',
            'ಕೊಡಗು',
            'ಕೋಲಾರ',
            'ಕೊಪ್ಪಳ',
            'ಮಂಡ್ಯ',
            'ಮೈಸೂರು (ಮೈಸೂರು)',
            'ರಾಯಚೂರು',
            'ರಾಮನಗರ',
            'ಶಿವಮೊಗ್ಗ (ಶಿವಮೊಗ್ಗ)',
            'ತುಮಕೂರು (ತುಮಕೂರು)',
            'ಉಡುಪಿ',
            'ಉತ್ತರ ಕನ್ನಡ (ಕಾರವಾರ)',
            'ವಿಜಯಪುರ (ಬಿಜಾಪುರ)',
            'ಯಾದಗಿರಿ',
        ];

        for ($i = 0; $i < count($district); $i++) {
            $s = DistrictModel::where('name', $district[$i])->first();

            if ($s == null) {
                DistrictModel::create(['name' => $district[$i], 'state' => 11]);
            }
        }

        return redirect()->back();
    }

    public function subDist()
    {

        $subDist = [
            "district_1" => [
                "ಜಮಖಂಡಿ",
                "ಬಾದಾಮಿ",
                "ಹುನಗುಂಡ್",
                "ಮುಧೋಳ",
                "ಬಾಗಲಕೋಟ",
                "ಬಿಲ್ಗಿ",
                "ಮಹಾಲಿಂಗಪುರ",
            ],
            "district_2" => [
                "ಹಡಗಲ್ಲಿ",
                "ಹಗರಿಬೊಮ್ಮನಹಳ್ಳಿ",
                "ಹೊಸಪೇಟೆ",
                "ಸಿರುಗುಪ್ಪ",
                "ಬಳ್ಳಾರಿ",
                "ಸಂಡೂರ್",
                "ಕೂಡ್ಲಿಗಿ",
            ],

            "district_3" => [
                "ಅಥಣಿ",
                "ಬೈಲಹೊಂಗಲ",
                "ಬೆಳಗಾವಿ",
                "ಚಿಕ್ಕೋಡಿ",
                "ಗೋಕಾಕ್",
                "ಹುಕ್ಕೇರಿ",
                "ಖಾನಾಪುರ",
                "ರಾಯಬಾಗ್",
                "ರಾಮದುರ್ಗ",
                "ಸೌದತ್ತಿ",
                "ಕಿತ್ತೂರು",
                "ನಿಪ್ಪಾಣಿ",
                "ಕಾಗವಾಡ",
                "ಮೂಡಲಗಿ",
                "ಯರಗತಿ",
            ],

            "district_4" => [
                "ದೊಡ್ ಬಳ್ಳಾಪುರ",
                "ಹೊಸಕೋಟೆ",
                "ನೆಲಮಂಗಲ",
                "ದೇವನಹಳ್ಳಿ",
            ],

            "district_6" => [
                "ಔರಾದ್",
                "ಬಸವಕಲ್ಯಾಣ",
                "ಭಾಲ್ಕಿ",
                "ಬೀದರ್",
                "ಹುಮ್ನಾಬಾದ್",
            ],

            "district_7" => [
                "ಕೊಳ್ಳೇಗಾಲ",
                "ಚಾಮರಾಜನಗರ",
                "ಗುಂಡ್ಲುಪೇಟೆ",
                "ಯಳಂದೂರು",
            ],

            "district_19" => [
                "ಕೋಲಾರ",
                "ಬಂಗಾರಪೇಟೆ",
                "ಮಾಲೂರು",
                "ಮುಳಬಾಗಿಲು",
                "ಶ್ರೀನಿವಾಸಪುರ",
                "ಕೋಲಾರ ಗೋಲ್ಡ್ ಫೀಲ್ಡ್ಸ್",
            ],
            "district_18" => [
                "ಸೋಮವಾರಪೇಟೆ",
                "ವಿರಾಜಪೇಟೆ",
                "ಮಡಿಕೇರಿ",
            ],
            "district_17" => [
                "ಕಲಬುರಗಿ",
                "ಅಲಂಡ್",
                "ಜೇವರ್ಗಿ",
                "ಅಫಜಲಪುರ",
                "ಕಳಗಿ",
                "ಕಮಲಾಪುರ",
                "ಶಹಾಬಾದ್",
                "ಯಡ್ರಾಮಿ",
            ],
            "district_16" => [
                "ಬ್ಯಾಡಗಿ",
                "ಹಂಗಲ್",
                "ಹಾವೇರಿ",
                "ಹಿರೇಕೆರೂರು",
                "ರಾಣೆಬೆನ್ನೂರು",
                "ಸವಣೂರು",
                "ಶಿಗ್ಗಾಂವ್",
            ],
            "district_15" => [
                "ಆಲೂರ್",
                "ಅರಕಲಗೂಡು",
                "ಅರಸಿಕೆರೆ",
                "ಬೇಲೂರು",
                "ಚನ್ನರಾಯಪಟ್ಟಣ",
                "ಹಾಸನ",
                "ಹೊಳೆ ನರಸೀಪುರ",
                "ಸಕಲೇಶಪುರ",
            ],
            "district_14" => [
                "ಗದಗ",
                "ರಾನ್",
                "ಶಿರಹಟ್ಟಿ",
                "ಮುಂಡರಗಿ",
                "ನರಗುಂದ",
            ],
            "district_13" => [
                "ಹುಬ್ಬಳ್ಳಿ ಧಾರವಾಡ",
                "ಧಾರವಾಡ",
                "ನವಲಗುಂದ",
                "ಕುಂಡಗೋಲ್",
                "ಕಲಘಟಗಿ",
                "ಹುಬ್ಬಳ್ಳಿ",
            ],
            "district_12" => [
                "ದಾವಣಗೆರೆ",
                "ಚನ್ನಗಿರಿ",
                "ಹರಪನಹಳ್ಳಿ",
                "ಹರಿಹರ",
                "ಹೊನ್ನಾಳಿ",
                "ಜಗಳೂರು",
            ],
            "district_11" => [
                "ಮಂಗಳೂರು",
                "ಬಂಟ್ವಾಳ",
                "ಪುತ್ತೂರು",
                "ಬೆಳ್ತಂಗಡಿ",
                "ಸುಳ್ಯ",
            ],
            "district_10" => [
                "ಚಿತ್ರದುರ್ಗ",
                "ಚಳ್ಳಕೆರೆ",
                "ಹಿರಿಯೂರು",
                "ಹೊಸದುರ್ಗ",
                "ಹೊಳಲ್ಕೆರೆ",
                "ಮೊಳಕಾಲ್ಮುರು",
            ],
            "district_9" => [
                "ಚಿಕ್ಕಮಗಳೂರು",
                "ಕಡೂರ್",
                "ತರೀಕೆರೆ",
                "ಮುದಿಗೆರೆ",
                "ಕೊಪ್ಪ",
                "ನರಸಿಂಹರಾಜಪುರ",
                "ಶೃಂಗೇರಿ",
            ],
            "district_8" => [
                "ಚಿಂತಾಮಣಿ",
                "ಗೌರಿಬಿದನೂರು",
                "ಸಿಡ್ಲಘಟ್ಟ",
                "ಚಿಕ್ಕಬಳ್ಳಾಪುರ",
                "ಬಾಗೇಪಲ್ಲಿ",
                "ಗುಡಿಬಂಡಾ",
            ],

            "district_30" => [
                "ಶೋರಾಪುರ",
                "ಶಹಪುರ್",
                "ಯಾದಗಿರಿ",
            ],
            "district_29" => [
                "ಕನಮಡಿ",
                "ಬಿಜ್ಜರಗಿ",
                "ಅಲಜಿನಲ್",
                "ಗೊಣಸಗಿ",
                "ಕಲ್ಲಕವಟಗಿ",
                "ಹುಬನೂರು",
                "ಇಂದಿರಾನಗರ",
                "ಯತ್ನಾಳ್",
                "ಟಕ್ಕಳಕಿ",
                "ಜಲಗೇರಿ",
                "ಅರಕೇರಿ",
                "ಸಿದ್ದಾಪುರ",
                "ಬರಟಗಿ",
                "ಹಂಚಿನಾಲ್",
                "ಇಟಂಗಿಹಾಳ್",
                "ಲೋಹಗಾಂವ್",
                "ಸೇವಾಲಾಲ್ನಗರ",
                "ಧನರಾಗಿ",
                "ಸಿದ್ದಾಪುರ",
                "ಮಲಕದೇವರಹಟ್ಟಿ",
                "ಸೋಮದೇವರಹಟ್ಟಿ",
                "ಬಾಬಾನಗರ",
                "ಹೊನವಾಡ",
                "ಕೋಟ್ಯಾಲ್",
                "ತಾಜಾಪುರ",
                "ಹರ್ನಾಲ್",
                "ರತ್ನಾಪುರ",
                "ಟಿಕೋಟಾ",
                "ರಾಂಪುರ್",
            ],
            "district_28" => [
                "ಕಾರವಾರ",
                "ಸೂಪಾ",
                "ಹಳಿಯಾಳ",
                "ಯಲ್ಲಾಪುರ",
                "ಮುಂಡಗೋಡ್",
                "ಸಿರ್ಸಿ",
                "ಅಂಕೋಲಾ",
                "ಕುಮಟಾ",
                "ಸಿದ್ದಾಪುರ",
                "ಹೊನಾವರ್",
                "ಭಾಟ್ಕಾ",
            ],
            "district_27" => [
                "ಉಡುಪಿ",
                "ಕಾಪು",
                "ಬ್ರಹ್ಮಾವರ",
                "ಕುಂದಾಪುರ",
                "ಬೈಂದೂರು",
                "ಕಾರ್ಕಳ",
                "ಹೆಬ್ರಿ",
            ],
            "district_26" => [
                "ಚಿಕ್ಕನಾಯಕನಹಳ್ಳಿ",
                "ಗುಬ್ಬಿ",
                "ಕೊರಟಗೆರೆ",
                "ಕುಣಿಗಲ್",
                "ಮಧುಗಿರಿ",
                "ಪಾವಗಡ",
                "ಸಿರಾ",
                "ತಿಪಟೂರು",
                "ತುಮಕೂರು",
                "ತುರುವೇಕೆರೆ",
            ],
            "district_25" => [
                "ಶಿವಮೊಗ್ಗ",
                "ಭದ್ರಾವತಿ",
                "ಶಿಕರಪುರ",
                "ಸಾಗರ್",
                "ಸೊರಬ್",
                "ತೀರ್ಥಹಳ್ಳಿ",
                "ಹೊಸನಗರ",
            ],
            "district_24" => [
                "ಕನಕಪುರ",
                "ರಾಮನಗರ",
                "ಚನ್ನಪಟ್ಟಣ",
                "ಮಾಗಡಿ",
            ],
            "district_23" => [
                "ರಾಯಚೂರು",
                "ಸಿಂಧನೂರು",
                "ಲಿಂಗ್ಸುಗೂರ್",
                "ಮಾನ್ವಿ",
                "ದೇವದುರ್ಗ",
            ],
            "district_22" => [
                "ಮೈಸೂರು",
                "ನಂಜನಗೂಡು",
                "ತಿರುಮಕೂಡಲ್-ನರಸೀಪುರ",
                "ಹುಣಸೂರು",
                "ಹೆಗ್ಗಡದೇವನಕೋಟೆ",
                "ಕೃಷ್ಣರಾಜನಗರ",
                "ಪಿರಿಯಾಪಟ್ಟಣ",
            ],
            "district_21" => [
                "ಮಂಡ್ಯ",
                "ಮದ್ದೂರು",
                "ಮಳವಳ್ಳಿ",
                "ಕೃಷ್ಣರಾಜಪೇಟೆ",
                "ನಾಗಮಂಗಲ",
                "ಪಾಂಡವಪುರ",
                "ಶ್ರೀರಂಗಪಟ್ಟಣ",
            ],
            "district_20" => [
                "ಯೆಲ್ಬುರ್ಗಾ",
                "ಕುಷ್ಟಗಿ",
                "ಗಂಗಾವತಿ",
                "ಕೊಪ್ಪಳ",
                "ಕಾರಟಗಿ",
                "ಕುಕನೂರು",
                "ಕನಕಗಿರಿ",
            ],
        ];

        foreach ($subDist as $sub) {

            for ($j = 0; $j < count(array_keys($subDist)); $j++) {
                $key = array_keys($subDist)[$j];
                // dd($key);

                for ($i = 0; $i < count($subDist[$key]); $i++) {
                    $id = explode("_", $key)[1];
                    $s = SubdistrictModel::where('name', $subDist[$key][$i])->first();

                    if ($s == null) {
                        SubdistrictModel::create(['name' => $subDist[$key][$i], 'district' => $id]);
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function acaYear()
    {

        $from = 1950;
        $to = 1951;

        for ($i = 0; $i < 200; $i++) {
            $tt = str_split($to + $i);

            $aca_year = $from + $i . "-" . $tt[2] . $tt[3];
            $s = AcademicYearModel::where('year', $aca_year)->first();
            if ($s == null) {
                AcademicYearModel::create(['year' => $aca_year]);
            }
        }
        return redirect()->back();
    }

    public function classes()
    {

        for ($i = 0; $i <= 12; $i++) {
            switch ($i) {
                case 0:
                    $std = "ನರ್ಸರಿ";
                    break;
                case 1:
                    $std = "ಎಲ್.ಕೆ.ಜಿ";
                    break;
                case 2:
                    $std = "ಯುಕೆಜಿ";
                    break;
                case 3:
                    $std = "ಯುಕೆಜಿ";
                    break;
                case 4:
                    $std = "2ನೇ";
                    break;
                case 5:
                    $std = "3ನೇ";
                    break;
                case 6:
                    $std = "4ನೇ";
                    break;
                case 7:
                    $std = "5ನೇ";
                    break;
                case 8:
                    $std = "6ನೇ";
                    break;
                case 9:
                    $std = "7ನೇ";
                    break;
                case 10:
                    $std = "8ನೇ";
                    break;
                case 11:
                    $std = "9ನೇ";
                    break;
                case 12:
                    $std = "10ನೇ";
                    break;
            }

            ClassesModel::create(["name" => $std]);
        }
        return redirect()->back();
    }
}
