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
    Route::get('admin/subscribers/download', [SubscriberController::class, 'export'])
        ->name('subscribers.download');
    Route::get('admin/subscribers/create', [SubscriberController::class, 'create'])
        ->name('subscribers.create');
    Route::get('admin/subscribers/{subscriber}', [SubscriberController::class, 'edit'])
        ->name('subscribers.edit');
});

//To see the email tamplate
Route::get('mailable/{id}', function ($id) {
    $subscriber = Subscriber::find($id);
    return new VerifyEmail($subscriber);
});

//Verify the email
Route::get('verify', [SubscriberController::class, 'verifyEmail'])
    ->middleware('signed')->name('verify');

require __DIR__.'/auth.php';

