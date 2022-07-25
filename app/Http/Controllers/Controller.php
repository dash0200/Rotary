<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearModel;
use App\Models\AdmissionModel;
use App\Models\ClassesModel;
use App\Models\DistrictModel;
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

    public function getStuddent(Request $req) {
        
        $student = AdmissionModel::where('id', $req->id)->first();
        $student['doy'] = $student->date_of_adm->format("Y");
        return response()->json($student);
    }

    public function getStdId(Request $req) {
        if(!isset($req->term)) {
            return response()->json();
        }
        $q = $req->term;

        $students = AdmissionModel::select('id','date_of_adm','sts','name', 'fname','mname','lname')->where("name", "LIKE", "%".$q."%")
        ->orWhere("id", "LIKE", "%".$q."%")
        ->orWhere("date_of_adm", "LIKE", "%".$q."%")
        ->orWhere("sts", "LIKE", "%".$q."%")
        ->orWhere("fname", "LIKE", "%".$q."%")
        ->orWhere("mname", "LIKE", "%".$q."%")
        ->orWhere("lname", "LIKE", "%".$q."%")
        ->limit(10)->get();

        $student = array();

        foreach($students as $std) {
            $student[] = array('id' => $std->id,
            'text' => $std->id."-".$std->sts.", ".$std->name." ".$std->fname." ".$std->lname.", (".$std->date_of_adm->format("d-m-Y").")");
        }
        return response()->json($student);
    }

    public function state()
    {
        $states = [
            'Andhra Pradesh',
            'Arunachal Pradesh',
            'Assam',
            'Bihar',
            'Chhattisgarh',
            'Goa',
            'Gujarat',
            'Haryana',
            'Himachal Pradesh',
            'Jharkhand',
            'Karnataka',
            'Kerala',
            'Madhya Pradesh',
            'Maharashtra',
            'Manipur',
            'Meghalaya',
            'Mizoram',
            'Nagaland',
            'Odisha',
            'Punjab',
            'Rajasthan',
            'Sikkim',
            'Tamil Nadu',
            'Telangana',
            'Tripura',
            'Uttar Pradesh',
            'Uttarakhand Dehradun ',
            'Gairsain ',
            'West Bengal'
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
            "Bagalkot",
            "Ballari (Bellary)",
            "Belagavi (Belgaum)",
            "Bengaluru (Bangalore) Rural",
            "Bengaluru (Bangalore) Urban",
            "Bidar",
            "Chamarajanagar",
            "Chikballapur",
            "Chikkamagaluru (Chikmagalur)",
            "Chitradurga",
            "Dakshina Kannada",
            "Davangere",
            "Dharwad",
            "Gadag",
            "Hassan",
            "Haveri",
            "Kalaburagi (Gulbarga)",
            "Kodagu",
            "Kolar",
            "Koppal",
            "Mandya",
            "Mysuru (Mysore)",
            "Raichur",
            "Ramanagara",
            "Shivamogga (Shimoga)",
            "Tumakuru (Tumkur)",
            "Udupi",
            "Uttara Kannada (Karwar)",
            "Vijayapura (Bijapur)",
            "Yadgir",
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
                "Jamkhandi",
                "Badami",
                "Hungund",
                "Mudhol",
                "Bagalkot",
                "Bilgi",
                "Mahalingpur",
            ],
            "district_2" => [
                "Hadagalli",
                "Hagaribommanahalli",
                "Hospet",
                "Siruguppa",
                "Bellary",
                "Sandur",
                "Kudligi",
            ],
    
            "district_3" => [
                "Athani",
                "Bailhongal",
                "Belagavi",
                "Chikkodi",
                "Gokak",
                "Hukkeri",
                "Khanapur",
                "Raibag",
                "Ramdurg",
                "Soudatti",
                "Kittur",
                "Nippani",
                "Kagawad",
                "Mudalagi",
                "Yaragatii",
            ],
    
            "district_4" => [
                "Dod Ballapur",
                "Hosakote ",
                "Nelamangala ",
                "Devanahalli ",
            ],
    
            "district_6" => [
                "Aurad",
                "Basavakalyan",
                "Bhalki",
                "Bidar",
                "Humnabad",
            ],
    
            "district_7" => [
                "Kollegal",
                "Chamarajanagar",
                "Gundlupet",
                "Yelandur",
            ],
    
            "district_19" => [
                "Kolar",
                "Bangarpet",
                "Malur",
                "Mulbagilu",
                "Srinivaspura",
                "Kolar Gold Fields",
            ],
            "district_18" => [
                "Somvarpet",
                "Virajpet",
                "Madikeri",
            ],
            "district_17" => [
                "Kalaburagi",
                "Aland",
                "Jewargi",
                "Afzalpur",
                "Kalagi",
                "Kamalapur",
                "Shahbad",
                "Yadrami",
            ],
            "district_16" => [
                "Byadgi",
                "Hangal",
                "Haveri",
                "Hirekerur",
                "Ranebennur",
                "Savanur",
                "Shiggaon",
            ],
            "district_15" => [
                "Alur",
                "Arkalgud",
                "Arsikere",
                "Belur",
                "Channarayapatna",
                "Hassan",
                "Hole Narsipur",
                "Sakleshpur",
            ],
            "district_14" => [
                "Gadag",
                "Ron",
                "Shirhatti",
                "Mundargi",
                "Nargund",
            ],
            "district_13" => [
                "Hubli Dharwad",
                "Dharwad",
                "Navalgund",
                "Kundgol",
                "Kalghatgi",
                "Hubli",
            ],
            "district_12" => [
                "Davanagere",
                "Channagiri",
                "Harapanahalli",
                "Harihar",
                "Honnali",
                "Jagalur",
            ],
            "district_11" => [
                "Mangalore",
                "Bantval",
                "Puttur",
                "Beltangadi",
                "Sulya",
            ],
            "district_10" => [
                "Chitradurga",
                "Challakere",
                "Hiriyur",
                "Hosadurga",
                "Holalkere",
                "Molakalmuru",
            ],
            "district_9" => [
                "Chikmagalur",
                "Kadur",
                "Tarikere",
                "Mudigere",
                "Koppa",
                "Narasimharajapura",
                "Sringeri",
            ],
            "district_8" => [
                "Chintamani",
                "Gauribidanur",
                "Sidlaghatta",
                "Chikkaballapura",
                "Bagepalli",
                "Gudibanda",
            ],
    
            "district_30" => [
                "Shorapur",
                "Shahpur",
                "Yadgir",
            ],
            "district_29" => [
                "Kanamadi",
                "Bijjaragi",
                "Alaginal",
                "Gonasagi",
                "Kallakavatagi",
                "Hubanur",
                "Indiranagar",
                "Yatnal",
                "Takkalaki",
                "Jalageri",
                "Arakeri",
                "Siddapura",
                "Baratagi",
                "Hanchinal",
                "Itangihal",
                "Lohagaon",
                "Sevalalnagar",
                "Dhanaragi",
                "Siddapur",
                "Malakandevarahatti",
                "Somadevarahatti",
                "Babanagar",
                "Honawad",
                "Kotyal",
                "Tajapur",
                "Harnal",
                "Ratnapura",
                "Tikota",
                "Rampur",
            ],
            "district_28" => [
                "Karwar",
                "Supa",
                "Haliyal",
                "Yellapur",
                "Mundgod",
                "Sirsi",
                "Ankola",
                "Kumta",
                "Siddapur",
                "Honavar",
                "Bhatka",
            ],
            "district_27" => [
                "Udupi",
                "Kapu",
                "Brahmavara",
                "Kundapura",
                "Byndoor",
                "Karkala",
                "Hebri",
            ],
            "district_26" => [
                "Chikkanayakanahalli",
                "Gubbi",
                "Koratagere",
                "Kunigal",
                "Madhugiri",
                "Pavagada",
                "Sira",
                "Tiptur",
                "Tumkur",
                "Turuvekere",
            ],
            "district_25" => [
                "Shimoga",
                "Bhadravati",
                "Shikarpur",
                "Sagar",
                "Sorab",
                "Tirthahalli",
                "Hosanagara",
            ],
            "district_24" => [
                "Kanakapura",
                "Ramanagara",
                "Channapatna",
                "Magadi",
            ],
            "district_23" => [
                "Raichur",
                "Sindhnur",
                "Lingsugur",
                "Manvi",
                "Devadurga",
            ],
            "district_22" => [
                "Mysore",
                "Nanjangud",
                "Tirumakudal-Narsipur",
                "Hunsur",
                "Heggadadevankote",
                "Krishnarajanagara",
                "Piriyapatna",
            ],
            "district_21" => [
                "Mandya",
                "Maddur",
                "Malavalli",
                "Krishnarajpet",
                "Nagamangala",
                "Pandavapura",
                "Shrirangapattana",
            ],
            "district_20" => [
                "Yelburga",
                "Kushtagi",
                "Gangavathi",
                "Koppal",
                "Karatagi",
                "Kukanoor",
                "Kanakagiri",
            ],
        ];

        foreach($subDist as $sub) {

            for($j=0; $j<count(array_keys($subDist)); $j++) {
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

    public function acaYear() {
        
        $from = 1950;
        $to = 1951;

        for($i=0; $i<200; $i++) {
            $tt = str_split($to+$i);

            $aca_year = $from+$i."-".$tt[2].$tt[3];
            $s = AcademicYearModel::where('year', $aca_year)->first();
            if ($s == null) {
                AcademicYearModel::create(['year' => $aca_year]);
            }
        }
        return redirect()->back();
    }

    public function classes() {

        for($i=0; $i<=12; $i++) {
            switch($i) {
                case 0:
                    $std = "NURSERY";
                    break;
                case 1:
                    $std = "LKG";
                    break;
                case 2:
                    $std = "UKG";
                    break;
                case 3:
                    $std = "1ST";
                    break;
                case 4:
                    $std = "2ND";
                    break;
                case 5:
                    $std = "3RD";
                    break;
                case 6:
                    $std = "4TH";
                    break;
                case 7:
                    $std = "5TH";
                    break;
                case 8:
                    $std = "6TH";
                    break;
                case 9:
                    $std = "7TH";
                    break;
                case 10:
                    $std = "8TH";
                    break;
                case 11:
                    $std = "9TH";
                    break;
                case 12:
                    $std = "10TH";
                    break;
            }
            
            ClassesModel::create(["name" => $std]);
        }
        return redirect()->back();
    }
}
