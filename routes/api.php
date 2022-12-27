<?php

use App\Http\Controllers\API\ApprovalController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\TravelPaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('payments', PaymentController::class);
    Route::resource('travel_payments', TravelPaymentController::class);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('approve', [ApprovalController::class, 'approvePayment']);
    Route::post('is_approved', [ApprovalController::class, 'isApproved']);
    Route::post('report', [ApprovalController::class, 'reportAllApprovers']);
});

Route::get('/register',  function () {
    return view('register');
});
Route::get('/login', function () {
    return view('login');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


