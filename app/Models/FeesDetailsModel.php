<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'states';
    protected $fillable = [
        'name',
    ];
}
