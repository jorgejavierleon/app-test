<?php

use App\Http\Controllers\SubscriberController;
use App\Mail\VerifyEmail;
use App\Models\Subscriber;
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
    return view('landings.index');
});
//Admin Routes
Route::middleware(['auth'])->group(function () {

    Route::get('admin/subscribers', [SubscriberController::class, 'index'])
        ->name('subscribers');
    Route::get('admin/subscribers/create', [SubscriberController::class, 'create'])
        ->name('subscribers.create');
    Route::get('admin/subscribers/{subscriber}', [SubscriberController::class, 'edit'])
        ->name('subscribers.edit');
});

Route::get('mailable', function () {
    $subscriber = Subscriber::first();
    return new VerifyEmail($subscriber);
});

Route::get('verify', [SubscriberController::class, 'verifyEmail'])
    ->middleware('signed')->name('verify');

require __DIR__.'/auth.php';

