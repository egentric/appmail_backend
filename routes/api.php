<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Appmail_contactController;
use App\Http\Controllers\API\Appmail_categoryController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('current-user', 'currentUser')->middleware('auth:api');
});


// Route::apiResource("appmail_contacts", Appmail_contactController::class);
Route::controller(Appmail_contactController::class)->group(function () {
    Route::get('appmail_contacts', 'index')->middleware('auth:api');
    Route::post('appmail_contacts', 'store')->middleware('auth:api');
    Route::get('appmail_contacts/{appmail_contact}', 'show')->middleware('auth:api');
    Route::post('appmail_contacts/{appmail_contact}', 'update')->middleware('auth:api');
    Route::delete('appmail_contacts/{appmail_contact}', 'destroy')->middleware('auth:api');
    Route::get('contacts_filter', 'indexFilterBusiness')->middleware('auth:api');
    Route::get('appmail_contacts/category/{appmail_category}', 'indexFilterCategory')->middleware('auth:api');
});

// Route::apiResource("appmail_categories", Appmail_categoryController::class);
Route::controller(Appmail_categoryController::class)->group(function () {
    Route::get('appmail_categories', 'index')->middleware('auth:api');
    Route::post('appmail_categories', 'store')->middleware('auth:api');
    Route::get('appmail_categories/{appmail_category}', 'show')->middleware('auth:api');
    Route::post('appmail_categories/{appmail_category}', 'update')->middleware('auth:api');
    Route::delete('appmail_categories/{appmail_category}', 'destroy')->middleware('auth:api');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users', 'index')->middleware('auth:api');
    // Route::post('users', 'store');
    Route::get('users/{user}', 'show')->middleware('auth:api');
    Route::post('users/{user}', 'update')->middleware('auth:api');
    Route::delete('users/{user}', 'destroy')->middleware('auth:api');
});
