<?php
namespace App\Services;
use App\Models\Mobile;
use App\Models\OtpLog;
use Carbon\Carbon;

class OtpService
{
    public static function sendOtp($mobile_nu, $n_code)
    {
        // Send Otp
        $otp = NumericOTP();
        $mobile = Mobile::where('mobile_nu', $mobile_nu)->first();
        $mobile->otp = $otp;
        $mobile->otp_sent_qty += 1;
//        $mobile->otp_next_try_time = Carbon::now('Asia/Tehran')->addMinutes(2);
        $mobile->otp_next_try_time = time()+120;
        $mobile->save();
        // Log Sent


    }

}
