<?php

namespace Fennecio\PhoneVerification;

class PhoneFeatures {


    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        return in_array($feature, config('phone_verification.features', []));
    }



    
    /**
     * Enable the phone verification feature.
     *
     * @return string
     */
    public static function phoneVerification()
    {
        return 'phone-verification';
    }
 
}