<?php

namespace Fennecio\PhoneVerification\Http\Middleware;

use Closure;
use Fennecio\PhoneVerification\Contracts\MustVerifyPhone;
use Fennecio\PhoneVerification\PhoneFeatures;
class EnsurePhoneVerified
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Closure  $next
    //  * @param  string|null  $redirectToRoute
    //  * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
    //  */
   
    public function handle($request, Closure $next)
    {
        // dd($request->user());
        if(PhoneFeatures::enabled(PhoneFeatures::phoneVerification())){
        if (
            ($request->user() instanceof MustVerifyPhone &&
            ! $request->user()->hasVerifiedPhone())) {
                
                return redirect(route('phone.notice'));
                // return Redirect::guest(URL::route('phone.notice'));
           }
        }
        
        return $next($request);
    }
}
