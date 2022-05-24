<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function castDetails() {
        return view('pages.reports.cast-details');
    }
    public function feesStructure() {
        return view('pages.reports.fees-structure');
    }
    public function generalRegister() {
        return view('pages.reports.general-register');
    }
    public function classDetails() {
        return view('pages.reports.class-details');
    }
}
