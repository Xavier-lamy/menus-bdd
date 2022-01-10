<?php

use Illuminate\Support\Facades\Route;

use App\HTTP\Controllers\FrontController;
use App\HTTP\Controllers\StockController;
use App\HTTP\Controllers\ReadController;
use App\HTTP\Controllers\CreateController;
use App\HTTP\Controllers\UpdateController;
use App\HTTP\Controllers\DeleteController;

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
Route:: post('/stock-delete-confirmation', [StockController::class, 'confirm_destroy'])->name('stock-delete-confirmation');
Route:: post('/stocks/delete', [StockController::class, 'destroy'])->name('stock.delete');

/**Total-stocks */
//Read
Route:: get('/total-stocks', [ReadController::class, 'show_total_stocks'])->name('total-stocks');
//Create
Route:: get('/total-stocks/create', [CreateController::class, 'create_command_product'])->name('command.create');
Route:: post('/total-stocks/create', [CreateController::class, 'add_command_product'])->name('command.add');
//Update
Route:: get('/total-stocks/modify/{id}', [UpdateController::class, 'modify_command_product'])->name('command.modify');
Route:: post('/total-stocks/modify', [UpdateController::class, 'apply_command_product_modifications'])->name('command.apply');
//Delete
Route:: post('/command-delete-confirmation', [DeleteController::class, 'delete_command_products_confirmation'])->name('command-delete-confirmation');
Route:: post('/total-stocks/delete', [DeleteController::class, 'delete_command_products'])->name('command.delete');
