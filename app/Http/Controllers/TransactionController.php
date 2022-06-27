<?php

namespace App\Http\Controllers;

use App\Models\ClassesModel;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function newAdmission() {
        return view('pages.transactions.new-admission')->with(['classes' => ClassesModel::get()]);
    }
    public function creatingClasses() {
        return view('pages.transactions.creating-classes');
    }
    public function leavingCertificate() {
        return view('pages.transactions.leaving-certificate');
    }
    public function getStudentId() {
        return view('pages.transactions.get-student-id');
    }
}
