<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UIController;
use App\Http\Controllers\ParserController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware'=>'auth:sanctum'], function () {
    Route::get('/main-menu', [UIController::class, 'main_menu']);
    Route::get('/auth-page', [UIController::class, 'auth_page']);
    Route::post('/parse', [ParserController::class, 'parse']);
    Route::get('/process-statuses', [ParserController::class, 'process_statuses']);
    Route::get('/process-status', [ParserController::class, 'process_status']);
});
