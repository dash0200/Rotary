<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateClass extends Model
{
    use HasFactory;

    protected $table = "create_class";
    protected $fillable = [
            "year",
            "standard",
            "student",
            "total",
            "paid",
            "balance",
    ];
}
