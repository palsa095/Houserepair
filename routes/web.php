<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProgressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(LandingController::class)->group(function () {
    Route::get('/', 'home')->name('landing.home');
    Route::get('/about', 'about')->name('landing.about');
    Route::get('/order', 'order')->name('landing.order');
    Route::get('/order/{id}', 'form')->name('landing.order.form');
    Route::get('/invoice', 'invoice')->name('landing.invoice')->middleware('auth');
    Route::get('/invoice/{invoice}', 'showinvoice')->name('landing.showinvoice');
});

Route::resource('customers', CustomerController::class)->middleware('auth');
Route::resource('surveys', SurveyController::class);
Route::resource('materials', MaterialController::class);
Route::resource('progress', ProgressController::class);
Route::resource('invoices', InvoiceController::class)->middleware('auth');

Route::get('/dashboard', function () {
    $totalHasilSurvey = App\Models\Survey::count();
    $totalBarang = App\Models\Material::count();
    $jumlahTransaksi = App\Models\Invoice::count();

    return view('dashboard',  [
        'totalHasilSurvey' => $totalHasilSurvey, 
        'totalBarang' => $totalBarang,           
        'jumlahTransaksi' => $jumlahTransaksi
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
