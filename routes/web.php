<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\marriedController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'wedding-invitation',
    'as' => 'wedding-invitation.'
], function () {
    Route::get('{uuid}/index', [\App\Http\Controllers\marriedController::class, 'index'])
        ->name('index');
});

