<?php

namespace App\Http\Controllers;

use App\User;
use App\Week;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        try {
            /** @var User $user */
            $user = User::where('phone_number', '=', $from)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $response = new MessagingResponse();
            $response->message("This is odd... we don't have you in our database...");
            return $response;
        }


        if(Str::contains(strtolower($body), self::PAUSE_WORD)){
            // TODO: Need tests
            $user->update(['paused' => $user->now()->endOfWeek(Carbon::SATURDAY)]);
            $response->message('No problem! I will leave you alone until next week!');
            return $response;
        }

        if(Str::contains(strtolower($body), self::STOP_WORD)){
            $user->update(['paused' => $user->now()->addYears(10)]);
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

        Week::storePrice($from, $body);

        // todo this should be refactored
        $response = new MessagingResponse();
        $response->message("Thanks {$user->name}, we got it!");
        return $response;
    }
}
