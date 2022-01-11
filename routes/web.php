<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CommandController;

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

/*Front */
Route:: get('/', [FrontController::class, 'index'])->name('front');

/*Stocks */
//Read
Route:: get('/stocks', [StockController::class, 'index'])->name('stocks');
//Create
Route:: get('/stocks/create', [StockController::class, 'create'])->name('stock.create');
Route:: post('/stocks/create', [StockController::class, 'store'])->name('stock.add');
//Update
Route:: get('/stocks/modify/{id}', [StockController::class, 'edit'])->name('stock.modify');
Route:: post('/stocks/modify', [StockController::class, 'update'])->name('stock.apply');
//Delete
Route:: post('/stock-delete-confirmation', [StockController::class, 'confirmDestroy'])->name('stock-delete-confirmation');
Route:: post('/stocks/delete', [StockController::class, 'destroy'])->name('stock.delete');

/**Total-stocks */
//Read
Route:: get('/total-stocks', [CommandController::class, 'index'])->name('total-stocks');
//Create
Route:: get('/total-stocks/create', [CommandController::class, 'create'])->name('command.create');
Route:: post('/total-stocks/create', [CommandController::class, 'store'])->name('command.add');
//Update
Route:: get('/total-stocks/modify/{id}', [CommandController::class, 'edit'])->name('command.modify');
Route:: post('/total-stocks/modify', [CommandController::class, 'update'])->name('command.apply');
//Delete
Route:: post('/command-delete-confirmation', [CommandController::class, 'confirmDestroy'])->name('command-delete-confirmation');
Route:: post('/total-stocks/delete', [CommandController::class, 'destroy'])->name('command.delete');
