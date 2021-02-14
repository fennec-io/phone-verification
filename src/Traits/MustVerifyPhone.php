<?php

namespace Fennecio\PhoneVerification\Traits;

trait MustVerifyPhone {

 use GoogleToolkit;


    public function updatePhone(String $phone,$verified=false)
    {
        
        $this->forceFill([

        'phone' => $phone,
        'phone_verified_at' => null
        
        ])->save();

        if($verified)
            $this->forceFill([
            'phone_verified_at' => now(),
            ])->save();
    
    
      
    }

    /**
     * Delete the user's  phone.
     *
     * @return void
     */
    public function deletePhone()
    {
        $this->forceFill([
            'phone' => null,
        ])->save();
        
    }

    /**
     * Get the URL to the user's  phone.
     *
     * @return string
     */
    public function getPhoneCodeAttribute()
    {
        $code = config('phone.code');
        
        return $code ? ($this->phone ? str_replace($code,'0',$this->phone) : null) : null;
    }



    public function verifyPhone($data){
        
        // try{
            
            $this->validateVerificationCode($data);
            
            $this->updatePhone($this->phone,true);

        // }
        // catch(Exception $e){
            
        // }
    }

    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendPhoneVerificationNotification($recaptchaToken)
    {
        return $this->sendVerificationCode($recaptchaToken);
    }

    /**
     * Get the phone address that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification()
    {
        return $this->phone;
    }

    


}