<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MastersController extends Controller
{
    public function feesHeads() {

        return view("pages.masters.fees-heads");
    }

    public function feesDetails() {

        return view("pages.masters.fees-details");
    }

    public function castDetails() {

        return view("pages.masters.cast-details");
    }
}
