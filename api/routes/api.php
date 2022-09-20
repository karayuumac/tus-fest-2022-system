<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', [UserController::class, 'get']);

Route::group(['middleware' => 'auth:sanctum'], function () {

  Route::group(['prefix' => 'event'], function () {
    Route::get('/', [EventController::class, 'index'])->name('event.index');
    Route::get('/{id}', [EventController::class, 'get'])->name('event.get')
      ->middleware('event.visible');
    Route::post('/{id}/reserve', [EventController::class, 'reserve'])->name('event.reserve')
      ->middleware('event.visible');

    Route::get('/{id}/seat/reserved/all', [SeatController::class, 'reservedSeats'])->name('seat.reserved');
    Route::get('/{id}/seat/reserved', [SeatController::class, 'reservedSeatsByUser'])->name('seat.reserved.user');
    Route::post('/{id}/seat/reserve', [SeatController::class, 'reserveWithPending'])->name('seats.reserve');
    Route::post('/{id}/seat/release', [SeatController::class, 'releasePendingSeats'])->name('seat.release');

    Route::post('/{id}/seat/validate', [SeatController::class, 'validateToken'])->name('seat.validate');
  });
});
