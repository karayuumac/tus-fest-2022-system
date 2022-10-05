<?php

use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\StripeWebhookController;
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

Route::get('/auth/reset-password/{token}', ResetPasswordController::class)
  ->name('password.reset');

Route::post('stripe/webhook', [StripeWebhookController::class, 'handlePaymentIntentSucceeded']);
