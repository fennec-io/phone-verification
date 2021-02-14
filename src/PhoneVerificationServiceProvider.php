<?php

namespace Fennecio\PhoneVerification;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PhoneVerificationServiceProvider extends ServiceProvider {



    public function register()
    {
        
        $this->mergeConfigFrom(__DIR__.'/config/phone_verification.php', 'phone_verification');

    }


    public function boot(){
        // publish 
        $this->publishes([
            __DIR__.'/config/phone_verification.php' => config_path('phone_verification.php'),

        ],'phone-verification-config');

        // components 
        $this->publishes([
            __DIR__.'/resources/js/Pages/PhoneVerify.vue' => resource_path('js/Pages/PhoneVerify.vue'),
           ], 'phone-verification-components');

        // routes
        $this->publishes([
            __DIR__.'/routes/phone_verification.php' => base_path('routes/phone_verification.php'),
        ], 'phone_verification-routes');


        Route::group([
            'namespace' => 'Fennecio\PhoneVerification\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/routes/phone_verification.php');
        });
    }


}