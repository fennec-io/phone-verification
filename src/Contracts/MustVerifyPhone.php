<?php

namespace Fennecio\PhoneVerification\Contracts;

interface MustVerifyPhone
{
    /**
     * Determine if the user has verified their Phone address.
     *
     * @return bool
     */
    public function hasVerifiedPhone();

    /**
     * Mark the given user's Phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified();

    /**
     * Send the Phone verification notification.
     *
     * @return void
     */
    public function sendPhoneVerificationNotification($recaptchaToken);

    /**
     * Get the Phone address that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification();
}
