<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesHeadsModel extends Model
{
    use HasFactory;

    protected $table = "fees_heads";

    protected $fillable = [
        'description',
    ];
}
