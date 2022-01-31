<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\RecipeController;

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

/**Commands */
//Read
Route:: get('/commands', [CommandController::class, 'index'])->name('commands');
//Create
Route:: get('/commands/create', [CommandController::class, 'create'])->name('command.create');
Route:: post('/commands/create', [CommandController::class, 'store'])->name('command.add');
//Update
Route:: get('/commands/modify/{id}', [CommandController::class, 'edit'])->name('command.modify');
Route:: post('/commands/modify', [CommandController::class, 'update'])->name('command.apply');
//Delete
Route:: post('/command-delete-confirmation', [CommandController::class, 'confirmDestroy'])->name('command-delete-confirmation');
Route:: post('/commands/delete', [CommandController::class, 'destroy'])->name('command.delete');

/**Recipes */
//Read
Route:: get('/recipes', [RecipeController::class, 'index'])->name('recipes');
Route:: get('/recipe/show/{id}', [RecipeController::class, 'show'])->name('recipe.show');
//Create
Route:: get('/recipe/create', [RecipeController::class, 'create'])->name('recipe.create');
Route:: post('/recipe/add', [RecipeController::class, 'store'])->name('recipe.add');
//Update
Route:: get('/recipe/modify/{id}', [RecipeController::class, 'edit'])->name('recipe.modify');
Route:: post('/recipe/apply', [RecipeController::class, 'update'])->name('recipe.apply');
//Delete
Route:: post('/recipe-delete-confirmation', [RecipeController::class, 'confirmDestroy'])->name('recipe-delete-confirmation');
Route:: post('/recipes/delete', [RecipeController::class, 'destroy'])->name('recipe.delete');