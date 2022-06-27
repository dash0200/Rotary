<?php

use App\Http\Controllers\BuildingFundController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FeesDetailsController;
use App\Http\Controllers\GeneralReceiptController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::controller(MastersController::class)->prefix('master')->name('master.')->group(function(){
    //Fees Heads
    Route::view('fees-heads', 'pages.masters.fees-heads')->name('feesHeads');
    Route::post('save-fees-desc', 'saveFeesDesc')->name('saveFeesDesc');
    Route::get('get-fees-desc', 'getFeesDesc')->name('getFeesDesc');
    Route::put('updatefee', 'updateFee')->name('updateFee');

    //Fees Details
    Route::get('fees-details', 'feesDetails')->name('feesDetails');
    Route::post('saveDetails', 'saveDetails')->name('saveDetails');
    Route::get('getDetails', 'getDetails')->name('getDetails');

    //Cast Details
    Route::get('cast-details', 'castDetails')->name('castDetails');
    Route::post('cast-save', 'saveCategory')->name('saveCategory');
    Route::get('get-cats', 'getCategories')->name('getCategories');
    Route::put('update-cats', 'updateCat')->name('updateCat');
    Route::post('save-caste', 'saveCaste')->name('saveCaste');
    Route::get('search-caste', 'searchCast')->name('searchCast');
});


Route::controller(TransactionController::class)->prefix('transaction')->name('trans.')->group(function(){
    Route::get('new-admission', 'newAdmission')->name('newAdmission');
    Route::get('creating-classes', 'creatingClasses')->name('creatingClasses');
    Route::get('leaving-certificate', 'leavingCertificate')->name('leavingCertificate');
    Route::get('get-student-id', 'getStudentId')->name('getStudentId');
});


Route::controller(FeesDetailsController::class)->prefix('fees-details')->name('fees.')->group(function(){
    Route::get('fees-receipts', 'feesReceipts')->name('feesReceipts');
    Route::get('receipt-cancellation', 'receiptCancellation')->name('receiptCancellation');
    Route::get('fees-arrears', 'feesArrears')->name('feesArrears');
    Route::get('day-book', 'dayBook')->name('dayBook');
    Route::get('fees-register', 'feesRegister')->name('feesRegister');
    Route::get('receipt-datewise', 'receiptDatewise')->name('receiptDatewise');
    Route::get('duplicate-receipt', 'duplicateReceipt')->name('duplicateReceipt');
});

Route::controller(ReportsController::class)->prefix('report')->name('report.')->group(function(){
    Route::get('cast-details', 'castDetails')->name('castDetails');
    Route::get('fees-structure', 'feesStructure')->name('feesStructure');
    Route::get('general-register', 'generalRegister')->name('generalRegister');
    Route::get('class-details', 'classDetails')->name('classDetails');
});

Route::controller(CertificateController::class)->prefix('certificate')->name('certificate.')->group(function(){
    Route::get('certificate', 'certificate')->name('certificate');
});

Route::controller(BuildingFundController::class)->prefix('building-fund')->name('building.')->group(function(){
    Route::get('receipt', 'receipt')->name('receipt');
    Route::get('duplicate-receipt', 'duplicateReceipt')->name('duplicateReceipt');
    Route::get('daily-report', 'dailyReport')->name('dailyReport');
    Route::get('report', 'report')->name('report');
    Route::get('receipt-deletion', 'receiptDeletion')->name('receiptDeletion');
});

Route::controller(GeneralReceiptController::class)->prefix('general-receipts')->name('general.')->group(function(){
    Route::get('general-receipts', 'generalReceipts')->name('generalReceipts');
    Route::get('day-book', 'dayBook')->name('dayBook');
    Route::get('datewise', 'datewise')->name('datewise');
});

Route::get("/state", [Controller::class, "state"])->name("state");
Route::get("/dist", [Controller::class, "district"])->name("dist");
Route::get("/subDist", [Controller::class, "subDist"])->name("subDist");
Route::get("/acaYear", [Controller::class, "acaYear"])->name("acaYear");
Route::get("/class", [Controller::class, "classes"])->name("class");