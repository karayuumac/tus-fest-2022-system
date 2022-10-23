<?php

use App\Http\Controllers\admin\AdminTicketController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;
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
      ->middleware(['event.visible', 'event.not_reserved']);

    Route::get('/{id}/seat/reserved/all', [SeatController::class, 'reservedSeats'])->name('seat.reserved');
    Route::get('/{id}/seat/reserved', [SeatController::class, 'reservedSeatsByUser'])->name('seat.reserved.user');
    Route::post('/{id}/seat/reserve', [SeatController::class, 'reserveWithPending'])->name('seats.reserve')
      ->middleware(['event.visible', 'event.not_reserved']);
    Route::post('/{id}/seat/release', [SeatController::class, 'releasePendingSeats'])->name('seat.release');
  });

  Route::group(['prefix' => 'ticket'], function () {
    Route::get('/', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/{id}/send', [TicketController::class, 'send'])->name('ticket.send');
    Route::get('/{id}/stop-sharing', [TicketController::class, 'stopSharing'])->name('ticket.sharing-stop');
  });

  Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin'
  ], function() {
    Route::post('/event/{id}/scan', [AdminTicketController::class, 'scan'])->name('admin.ticket.scan');
  });
});

Route::get('/ticket/{token}', [TicketController::class, 'show'])->name('ticket.show');
