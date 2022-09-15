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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\DuelsController::class, 'AllDuels'])->name('AllDuels');

Route::get('/winner', [App\Http\Controllers\winnerController::class, 'index'])->name('winner');

Route::get('/FAQ', [App\Http\Controllers\FAQController::class, 'index'])->name('FAQ');

Route::post('/home', [App\Http\Controllers\MessageRequestController::class, 'index'])->name('sendMessage');

Route::get('/home', [App\Http\Controllers\MessageController::class, 'allChat'])->name('allChat');

Route::get('/home/{id}', [App\Http\Controllers\DuelsController::class, 'redirectDuel'])->name('showOneDuel');

Route::post('/home/{id}', [App\Http\Controllers\MessageRequestController::class, 'index'])->name('sendMessageOneDuel');

//Route::get('/home', [App\Http\Controllers\DuelsController::class, 'check'])->name('check');
// тест пока не трогать!

Auth::routes();



