<?php

use Fennecio\PhoneVerification\Http\Controllers\PhoneVerificationPromptController;
use Illuminate\Support\Facades\Route;
use Fennecio\PhoneVerification\PhoneFeatures;

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {

if (PhoneFeatures::enabled(PhoneFeatures::phoneVerification())) {

    Route::get('/phone/verify', [PhoneVerificationPromptController::class, '__invoke'])
        ->middleware(['auth'])
        ->name('phone.notice');
        
    Route::post('/phone/verify', [PhoneVerificationPromptController::class, 'sendCode'])
        ->middleware(['auth'])
        ->name('phone.verify');

    Route::post('/phone/verify/code', [PhoneVerificationPromptController::class,'verify'])
        ->middleware(['auth'])
        ->name('phone.verify.code');
}
});
