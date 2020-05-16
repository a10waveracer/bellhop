<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Twilio\TwiML\MessagingResponse;

class TwilioController extends Controller
{
    const PAUSE_WORD = 'snooze';
    const STOP_WORD = 'halt';

    function store(Request $request)
    {
        $response = new MessagingResponse();
        $from = $request->From;
        $body = $request->Body;

        if(Str::contains(strtolower($body), self::PAUSE_WORD)){
            // TODO: store the pause
            $response->message('No problem! I will leave you alone until next week!');
            return $response;
        }

        if(Str::contains(strtolower($body), self::STOP_WORD)){
            // TODO: store the stop
            $response->message('Understood, we will never message you again. Enjoy ACNH!');
            return $response;
        }

        $validator = Validator::make($request->all(), [
            'Body' => 'required:numeric'
        ]);
        if($validator->fails()){
            Log::info("Unable to parse message from '{$from}' with content '{$body}'");
            $response->message("Sorry, that was not a number we can understand. Either type a bell price, '" .
                self::PAUSE_WORD. "' or '". self::STOP_WORD ."'");
            return $response;
        }

        // TODO: Store this info on the Week
        $response = new MessagingResponse();
        // TODO: Add in user name here
        $response->message('Thanks, we have logged your bell price.');
        return $response;
    }
}
