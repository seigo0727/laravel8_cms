<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('master')->name('master.')->group(function () {
    Route::prefix('side_menu_items')->name('side_menu_item.')->group(function () {
        Route::get('/', [App\Http\Controllers\Master\SideMenuItemController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Master\SideMenuItemController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [App\Http\Controllers\Master\SideMenuItemController::class, 'edit'])->name('edit');
        Route::get('/index_json', [App\Http\Controllers\Master\SideMenuItemController::class, 'indexJson'])->name('index_json');
    });
});