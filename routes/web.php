<?php

use App\Http\Controllers\MastersController;
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

Route::controller(MastersController::class)->name('master.')->group(function(){
    Route::get('feesheads', 'feesHeads')->name('feesHeads');
    Route::get('feesetails', 'feesDetails')->name('feesDetails');
    Route::get('castdetails', 'castDetails')->name('castDetails');
});