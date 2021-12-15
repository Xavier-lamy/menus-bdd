<?php

use Illuminate\Support\Facades\Route;

use App\HTTP\Controllers\FrontController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route:: get('/', [FrontController::class, 'index'])->name('front');
Route:: get('/stocks', [FrontController::class, 'stocks'])->name('stocks');
Route:: get('/safety-stocks', [FrontController::class, 'show_safety_stocks'])->name('safety-stocks');
