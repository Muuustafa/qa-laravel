<?php

use App\Http\Controllers\CollectiveController;
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

Route::resource('collectives', 'App\Http\Controllers\CollectiveController');
Route::resource('questions', 'App\Http\Controllers\QuestionController');
Route::delete('/delete', [CollectiveController::class, 'destroy'])->name('delete');
Route::get('/{category?}', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/', [CollectiveController::class, 'index'])->name('index');
Route::get('/fetchall', [CollectiveController::class, 'fetchAll'])->name('collectives.fetchAll');
Route::get('/edit', [CollectiveController::class, 'edit'])->name('edit');
Route::post('/update', [CollectiveController::class, 'update'])->name('update');
Route::get('/collective/{id}', [CollectiveController::class, 'edit']);
Route::put('/collective/{id}', [CollectiveController::class, 'update']);