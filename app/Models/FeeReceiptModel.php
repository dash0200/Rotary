<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeReceiptModel extends Model
{
    use HasFactory;

    protected $table = "fee_receipt";

    protected $fillable = [
            "student",
            "amt_paid",
            "receipt_no",
            "year",
            "class",
    ];
}
