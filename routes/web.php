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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/representative/index', [App\Http\Controllers\RepresentativeController::class, 'index'])->name('representatives.index');
    Route::get('/representative/create', [App\Http\Controllers\RepresentativeController::class, 'create'])->name('representatives.create');
    Route::post('/representative/store', [App\Http\Controllers\RepresentativeController::class, 'store'])->name('representatives.store');
    // Fix Later
    //Route::get('/representative/edit/{representative_id}', [App\Http\Controllers\RepresentativeController::class, 'edit'])->name('representatives.edit');
    //Route::patch('/representative/update', [App\Http\Controllers\RepresentativeController::class, 'update'])->name('representatives.update');
    Route::get('/representative/delete/{representative_id}', [App\Http\Controllers\RepresentativeController::class, 'delete'])->name('representatives.delete');
    Route::delete('/representative/destroy/{id}', [App\Http\Controllers\RepresentativeController::class, 'destroy'])->name('representatives.destroy');

    Route::get('/calls/index', [App\Http\Controllers\CallController::class, 'index'])->name('calls.index');
    Route::get('/calls/create', [App\Http\Controllers\CallController::class, 'create'])->name('calls.create');
    Route::post('/calls/store', [App\Http\Controllers\CallController::class, 'store'])->name('calls.store');
    Route::get('/calls/edit/{id}', [App\Http\Controllers\CallController::class, 'edit'])->name('calls.edit');
    Route::patch('/calls/update', [App\Http\Controllers\CallController::class, 'update'])->name('calls.update');
    Route::get('/calls/delete/{id}', [App\Http\Controllers\CallController::class, 'delete'])->name('calls.delete');
    Route::delete('/calls/destroy/{id}', [App\Http\Controllers\CallController::class, 'destroy'])->name('calls.destroy');
    Route::get('/calls/display_for_user/{representative_id}', [App\Http\Controllers\CallController::class, 'display_for_user'])->name('calls.display_for_user');
    
    Route::get('/calls/generate_summary_with_users', [App\Http\Controllers\CallController::class, 'generate_summary_with_users'])->name('calls.generate_summary_with_users');
    Route::get('/calls/generate_summary_without_users', [App\Http\Controllers\CallController::class, 'generate_summary_without_users'])->name('calls.generate_summary_without_users');
    Route::post('/calls/retrieve_summary_with_users', [App\Http\Controllers\CallController::class, 'retrieve_summary_with_users'])->name('calls.retrieve_summary_with_users');    
    Route::post('/calls/retrieve_summary_without_users', [App\Http\Controllers\CallController::class, 'retrieve_summary_without_users'])->name('calls.retrieve_summary_without_users');    
    
    Route::get('/calls/result_of_summary_with_users', [App\Http\Controllers\CallController::class, 'result_of_summary_with_users'])->name('calls.result_of_summary_with_users');
    Route::get('/calls/result_of_summary_without_users', [App\Http\Controllers\CallController::class, 'result_of_summary_without_users'])->name('calls.result_of_summary_without_users');
});

