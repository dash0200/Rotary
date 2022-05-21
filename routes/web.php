<?php

use App\Http\Controllers\FeesDetailsController;
use App\Http\Controllers\MastersController;
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
    Route::get('/fees-heads', 'feesHeads')->name('feesHeads');
    Route::get('/fees-details', 'feesDetails')->name('feesDetails');
    Route::get('/cast-details', 'castDetails')->name('castDetails');
});


Route::controller(TransactionController::class)->prefix('transaction')->name('trans.')->group(function(){
    Route::get('/new-admission', 'newAdmission')->name('newAdmission');
    Route::get('/creating-classes', 'creatingClasses')->name('creatingClasses');
    Route::get('/leaving-certificate', 'leavingCertificate')->name('leavingCertificate');
    Route::get('/get-student-id', 'getStudentId')->name('getStudentId');
});


Route::controller(FeesDetailsController::class)->prefix('fees-details')->name('fees.')->group(function(){
    Route::get('/fees-receipts', 'feesReceipts')->name('feesReceipts');
    Route::get('/receipt-cancellation', 'receiptCancellation')->name('receiptCancellation');
    Route::get('/fees-arrears', 'feesArrears')->name('feesArrears');
    Route::get('/day-book', 'dayBook')->name('dayBook');
    Route::get('/fees-register', 'feesRegister')->name('feesRegister');
    Route::get('/receipt-datewise', 'receiptDatewise')->name('receiptDatewise');
    Route::get('/duplicate-receipt', 'duplicateReceipt')->name('duplicateReceipt');
});