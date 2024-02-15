<?php

use App\Http\Controllers\Api\V1\WelcomeController;
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

// Welcome Page
Route::get('/', [WelcomeController::class, 'index'])->name('user');

// API Routes - Version 1
require __DIR__ . '/api/v1.php';
