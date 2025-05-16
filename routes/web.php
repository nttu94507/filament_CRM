<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/admin/login', \App\Filament\Pages\Login::class)->name('filament.admin.auth.login');
Route::get('/admin/auth/redirect/google', [App\Http\Controllers\Auth\GoogleLoginController::class, 'redirect'])->name('login.google');
Route::get('/admin/auth/callback/google', [App\Http\Controllers\Auth\GoogleLoginController::class, 'callback']);

//Route::get('/admin/bookings',[App\Filament\Resources\BookingResource::class,'index'])->name('filament.admin.bookings.index');
Route::get('/reserve/lookup', [BookingLookupController::class, 'showForm']);
Route::post('/reserve/lookup', [BookingLookupController::class, 'lookup']);
Route::post('/reserve/cancel', [BookingLookupController::class, 'cancel'])->name('booking.cancel');
Route::get('/booking/thank-you', [\App\Http\Controllers\BookingThankYouController::class, 'show'])
    ->name('booking.thank-you');

