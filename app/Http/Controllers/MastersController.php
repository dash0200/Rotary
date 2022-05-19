<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MastersController extends Controller
{
    public function feesHeads() {

        return view("pages.masters.feesheads");
    }

    public function feesDetails() {

        return view("pages.masters.feesdetails");
    }

    public function castDetails() {

        return view("pages.masters.castdetails");
    }
}
