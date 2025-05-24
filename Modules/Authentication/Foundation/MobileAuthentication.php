<?php

namespace Modules\Authentication\Foundation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Authentication\Entities\OtpRequest;
use Modules\User\Entities\User;

trait MobileAuthentication
{
    public static function sendOtp($mobile)
    {
        $userObj = User::where('mobile',$mobile)->first();
        if($userObj && $userObj->logged){
//            return false;
        }

        optional(OtpRequest::where('mobile' , $mobile)->first())->delete();
        return OtpRequest::create(['mobile' => $mobile],['mobile' => $mobile]);
    }
    public static function otpCheck($mobile,$otp)
    {
        $request =  OtpRequest::where(['mobile' => $mobile,'otp' => $otp])->first();
        return $request && !$request->is_expired;
    }

    public function loginOrRegister($mobile, $loginType = 'frontend')
    {
        $user =  User::where('mobile',$mobile)->first();

        if($user){
            $route = 'frontend.home';
        }else{

            $user = User::create(['mobile' => $mobile,'first_login' => 1]);
            $user->refresh();
            $route = 'frontend.profile.edit';
        }

        switch($loginType){
            case 'frontend':
                $this->frontLogin($user);
        }

        return $this->loginReponse($user,$route);
    }

    public function loginReponse($user,$route){

        return $route;
    }

    public function frontLogin($user){
        $this->logoutOtherDevices($user);
        Auth::login($user);
    }

    public function logoutOtherDevices($user)
    {
        $user->update(['logged'=>1, 'password' => bcrypt('password1234')]);
        Auth::logoutOtherDevices('password1234');
        $user->tokens()->delete();
    }
}
