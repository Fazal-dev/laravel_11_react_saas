<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\Feature1Controller;
use App\Http\Controllers\Feature2Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::post('/buy-credits/webhook', [CreditController::class, 'webhook'])->name('credit.webhook');
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get(
        '/dashboard',
        [DashbordController::class, 'index']
    )->name('dashboard');
});


Route::get('/feature1', [Feature1Controller::class, 'index'])->name('feature1.index');
Route::post('/feature1/calculate', [Feature1Controller::class, 'calculate'])->name('feature1.calculate');

Route::get('/feature2', [Feature2Controller::class, 'index'])->name('feature2.index');
Route::post('/feature2/calculate', [Feature2Controller::class, 'calculate'])->name('feature2.calculate');

Route::get('/buy-credits', [CreditController::class, 'index'])->name('credit.index');
Route::get('/buy-credits/success', [CreditController::class, 'success'])->name('credit.success');
Route::get('/buy-credits/cancel', [CreditController::class, 'cancel'])->name('credit.cancel');

Route::post('/buy-credits/{package}', [CreditController::class, 'buyCredits'])->name('credit.buy');


require __DIR__ . '/auth.php';
