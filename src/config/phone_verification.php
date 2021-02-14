<?php

use Fennecio\PhoneVerification\PhoneFeatures;

return [


        'blade_name' => 'PhoneVerify',
        'features' => [
            PhoneFeatures::phoneVerification()
        ]
];