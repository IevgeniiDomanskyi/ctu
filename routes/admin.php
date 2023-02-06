<?php

namespace App\Http\Controllers\Admin;

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

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', 'me');
    Route::delete('/logout', 'logout');
  }
  );
});

Route::controller(PlanController::class)->group(function () {
  Route::middleware('auth:sanctum')->prefix('plan')->group(function () {
    Route::get('/', 'all');
    Route::get('/current', 'current');
    Route::post('/', 'create');

    Route::name('plan')->prefix('{plan}')->group(function () {
      Route::get('/', 'get')
        ->missing(function (Request $request) {
            return response()->missingModelBehavior();
          }
        );
      Route::put('/', 'update')
        ->missing(function (Request $request) {
            return response()->missingModelBehavior();
          }
        );
      Route::delete('/', 'remove')
        ->missing(function (Request $request) {
            return response()->missingModelBehavior();
          }
        );
      Route::get('/current', 'markAsCurrent')
        ->missing(function (Request $request) {
            return response()->missingModelBehavior();
          }
        );
    });
  });
});