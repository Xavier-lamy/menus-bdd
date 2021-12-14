<?php

use Illuminate\Support\Facades\Route;

use App\HTTP\Controllers\PostController;

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

Route:: get('/', [PostController::class, 'index'])->name('front');
Route:: get('/stocks', [PostController::class, 'stocks'])->name('stocks');
Route:: get('/safety-stocks', [PostController::class, 'safety_stocks'])->name('safety-stocks');
