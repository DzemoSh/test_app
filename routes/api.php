<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShiftController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('createShift', [ShiftController::class, 'createShift'])->name('createShift');
Route::get('getShifts', [ShiftController::class, 'getShifts'])->name('getShifts');
Route::get('getWorkers', [ShiftController::class, 'getWorkers'])->name('getWorkers');
Route::post('updateShift', [ShiftController::class, 'updateShift'])->name('updateShift');
Route::post('deleteShift', [ShiftController::class, 'deleteShift'])->name('deleteShift');
Route::post('getEmployeeDetails', [ShiftController::class, 'getEmployeeDetails'])->name('getEmployeeDetails');
Route::post('uploadCSV', [ShiftController::class, 'uploadCSV'])->name('uploadCSV');