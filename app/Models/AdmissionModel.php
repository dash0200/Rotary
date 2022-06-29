<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionModel extends Model
{
    use HasFactory; use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'admission';
    protected $fillable = [
        "date_of_adm",
        "year",
        "caste",
        "sub_caste",
        "category",
        "class",
        "sts",
        "name",
        "fname",
        "mname",
        "lname",
        "address",
        "city",
        "phone",
        "mobile",
        "dob",
        "birth_place",
        "sub_district",
        "religion",
        "nationality",
        "gender",
        "handicap",
        "prev_school"
    ];
}
