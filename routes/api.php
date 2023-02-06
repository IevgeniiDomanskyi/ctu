<?php
namespace App\Http\Controllers\Api;

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

Route::controller(AuthController::class)->group(function () {
  Route::post('/login', 'login');
  Route::post('/register', 'register');
  Route::get('/activate/{hash:hash}', 'activate')
    ->missing(function (Request $request) {
      return response()->missingModelBehavior();
    });
  Route::post('/recovery', 'recovery');
  Route::get('/hash/{hash:hash}', 'hash')
    ->missing(function (Request $request) {
      return response()->missingModelBehavior();
    });
  Route::post('/save-password', 'savePassword');

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', 'me');
    Route::post('/change-password', 'changePassword');
    Route::delete('/logout', 'logout');
  });
});

Route::controller(BillingController::class)->group(function () {
  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/setup-indent', 'setupIndent');
    Route::post('/save-payment-method', 'savePaymentMethod');
    Route::get('/subscribe', 'subscribe');
    Route::get('/unsubscribe', 'unsubscribe');
  });
});