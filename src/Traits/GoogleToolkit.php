<?php
namespace Fennecio\PhoneVerification\Traits;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Http;


trait GoogleToolkit {

    public  $URL_VERIFICATION_CODE ="https://www.googleapis.com/identitytoolkit/v3/relyingparty/sendVerificationCode?key="; 
    public  $URL_VERIFICATION_PHONE_NUMBER ="https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPhoneNumber?key="; 


    public function sendVerificationCode($recaptchaToken){
        // phone number
        // repactcha token
        $resp = Http::post($this->URL_VERIFICATION_CODE.Setting::getCurrent()->firebase_api_key,[
            "phoneNumber"=>$this->phone,
            "recaptchaToken"=>$recaptchaToken
        ])->onError(
            function (\Illuminate\Http\Client\Response $error){
                if($error->clientError())
                throw new Exception($error->json()['error']['message']);          
                
                throw new Exception('Unknown Error');
            }
        );
            
        return $resp->json();
    }


    public function validateVerificationCode($data){
        // session info 
        // code 
        $resp = Http::post($this->URL_VERIFICATION_PHONE_NUMBER.Setting::getCurrent()->firebase_api_key,[
            "sessionInfo"=>$data['sessionInfo'],
            "code"=> $data['code']
        ])->onError(
            function (\Illuminate\Http\Client\Response $error){
                if($error->clientError())
                throw new Exception($error->json()['error']['message']);          
                
                throw new Exception('Unknown Error');
            }
        );;
        

        return $resp->json();
    }



}