<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GuestController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OptionController;

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

/*Authentification routes */
Route:: get('/guest', [GuestController::class, 'notLoggedIn'])->name('guest');

Route:: get('/register', [UserController::class, 'create'])->name('register');
Route:: post('/register', [UserController::class, 'store'])->name('user.store');
Route:: get('/login', [UserController::class, 'login'])->name('login');
Route:: post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
Route:: get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    /*Front */
    Route:: get('/', [FrontController::class, 'index'])->name('front');

    /*options */
    Route::name('options.')->group(function() {
        Route::get('/options', [OptionController::class, 'index'])->name('index');
    });

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

    /**Menus */
    //Read
    Route:: get('/menus', [MenuController::class, 'index'])->name('menus');
    Route:: get('/menu/show/{id}', [MenuController::class, 'show'])->name('menu.show');
    //Create
    Route:: get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route:: post('/menu/add', [MenuController::class, 'store'])->name('menu.add');
    //Update
    Route:: get('/menu/modify/{id}', [MenuController::class, 'edit'])->name('menu.modify');
    Route:: post('/menu/apply/{id}', [MenuController::class, 'update'])->name('menu.apply');
    //Delete
    Route:: post('/menu-delete-confirmation', [MenuController::class, 'confirmDestroy'])->name('menu-delete-confirmation');
    Route:: post('/menus/delete', [MenuController::class, 'destroy'])->name('menu.delete');
});
