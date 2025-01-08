<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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
})->name('/');

Route::post('/event/register', [EventController::class, 'store'])->name('event.store');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/view-mail-status', [App\Http\Controllers\EmailManagementController::class, 'index'])->name('view-mail-status');
Route::get('/events/data', [App\Http\Controllers\EmailManagementController::class,'getEventsData'])->name('events.data');
Route::post('/events/resend-mail/{event}', [App\Http\Controllers\EmailManagementController::class, 'resendMail'])->name('events.resendMail');