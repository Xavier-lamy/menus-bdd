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

/*For stocks */
Route:: get('/stocks', [FrontController::class, 'show_stocks'])->name('stocks');
Route:: get('/stocks/create', [FrontController::class, 'create_stock_product'])->name('stock.create');
Route:: post('/stocks/create', [FrontController::class, 'add_stock_product'])->name('stock.add');
Route:: get('/stocks/modify/{id}', [FrontController::class, 'modify_stock_product'])->name('stock.modify');
Route:: post('/stocks/modify', [FrontController::class, 'apply_stock_product_modifications'])->name('stock.apply');
Route:: post('/stock-delete-confirmation', [FrontController::class, 'delete_stock_products_confirmation'])->name('stock-delete-confirmation');
Route:: post('/stocks/delete', [FrontController::class, 'delete_stock_products'])->name('stock.delete');

/**For total-stocks */
Route:: get('/total-stocks', [FrontController::class, 'show_total_stocks'])->name('total-stocks');
Route:: get('/total-stocks/create', [FrontController::class, 'create_command_product'])->name('command.create');
Route:: post('/total-stocks/create', [FrontController::class, 'add_command_product'])->name('command.add');
