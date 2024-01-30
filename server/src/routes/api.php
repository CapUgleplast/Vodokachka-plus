<?php

use App\Http\Controllers\Api\BillsController;
use App\Http\Controllers\Api\mixed\RecsAndTariffsController;
use App\Http\Controllers\Api\PeriodsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ResidentsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('jwt.auth')->apiResource('residents', ResidentsController::class);

Route::group(['prefix' => 'management'], function (){
    Route::middleware('jwt.auth')->get('/current', [RecsAndTariffsController::class, 'getCurrentSQL']);
    Route::middleware('jwt.auth')->get('/previous', [RecsAndTariffsController::class, 'getPreviousSQL']);
    Route::middleware('jwt.auth')->get('/planned', [RecsAndTariffsController::class, 'getPlannedSQL']);
    Route::middleware('jwt.auth')->put('/{id}', [RecsAndTariffsController::class, 'update']);
    Route::middleware('jwt.auth')->delete('/{id}', [RecsAndTariffsController::class, 'destroy']);
});

Route::middleware('jwt.auth')->apiResource('periods', PeriodsController::class);

Route::middleware('jwt.auth')->apiResource('bills', BillsController::class);
Route::middleware('jwt.auth')->post('/bills/monthly', [BillsController::class, 'getListByMonth']);

Route::post('/login', [UserController::class, 'login']);


