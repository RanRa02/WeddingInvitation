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
        'namespace' => 'WeddingInvitation',
        'as' => 'wedding-invitation.'
    ], function () {
        Route::get('/index', [marriedController::class, 'index'])->name('.index');
    }
);
