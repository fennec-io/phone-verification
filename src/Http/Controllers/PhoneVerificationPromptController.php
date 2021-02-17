<?php

namespace Fennecio\PhoneVerification\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PhoneVerificationPromptController extends Controller
{
    protected $blade;

    public function __construct()
    {
        $this->blade = config('phone_verification.blade_name');
    }

    /**
     * Display the phone verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedPhone()
                    ? redirect()->intended(config('fortify.home'))
                    : Inertia::render($this->blade,[
                        'firebase_config' => Setting::getCurrent()->firebase_config,
                        'sessionInfo' => null,
                        'status' => null
                    ]);
    }

    
    public function sendCode(Request $request)
    {

        $status = null;
        $sessionInfo = null;
        try{

        $resp = $request->user()->sendPhoneVerificationNotification($request->recapchaToken);
        $status = "phone-code-sended" ;
        $sessionInfo = $resp['sessionInfo'];

        }catch(Exception $e){
            $status = "phone-code-notsended"; 
        }
        return $request->wantsJson()
        ? new JsonResponse('', 200)
        : Inertia::render($this->blade,[
            'firebase_config' => Setting::getCurrent()->firebase_config,
            'sessionInfo' => $sessionInfo,
            'status' => $status
        ]);
    }



    public function verify(Request $request)
    {
        try{

         $request->user()->verifyPhone([
            'sessionInfo' => $request->sessionInfo,
            'code' => $request->code
         ]);
        
        }catch(Exception $e){
            return Inertia::render($this->blade,[
                'firebase_config' => Setting::getCurrent()->firebase_config,
                // 'sessionInfo' => $resp['sessionInfo'],
                'status' => "phone-code-invalid"
            ]);
        }


        return $request->wantsJson()
        ? new JsonResponse('', 200)
        : redirect(route('dashboard'));
    }




}
