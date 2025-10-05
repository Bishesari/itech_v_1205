<?php

namespace App\Http\Controllers;

use App\Services\ParsGreenService;

class SmsTestController extends Controller
{
    public function send()
    {
        $sms = new ParsGreenService();
        $result = $sms->sendSms('09034336111', 'سلام از لاراول ✅');

        return response()->json($result);
    }
}
