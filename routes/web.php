<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RecordController;
use App\Http\Livewire\Shop;
use App\Http\Livewire\Itunes;
use App\Http\Livewire\admin\genres;
use App\Http\Livewire\admin\records;

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

Route::get('shop', Shop::class)->name('shop');
Route::get('itunes', Itunes::class)->name('itunes');

Route::middleware(['auth', 'active', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/records');
    Route::get('genres', Genres::class)->name('genres');
    Route::get('records_old', [RecordController::class, 'index'])->name('records.old');
    Route::get('records', Records::class)->name('records');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'active'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
