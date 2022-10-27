<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RecordController;

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
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/playground', function () {
    return view('playground');
})->name('playground');

// Route::view('/', 'home')->name('home');
// Route::view('/contact', 'contact')->name('contact');

Route::prefix('admin')->name('admin.')->group(function(){
    Route::redirect('/', '/admin/records');
    Route::get('records', [RecordController::class, 'index'])->name('records.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});