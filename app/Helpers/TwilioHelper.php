<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioHelper
{
    /** @var Client $client */
    public $client;

    public $fromNumber;

    function __construct()
    {

        $this->client = new Client(
            config("twilio.sid"),
            config("twilio.token")
        );

        $this->fromNumber = config("twilio.from");
    }

    public function sms($destinationNumber, $message)
    {
        try {
            $result = $this->client->messages->create(
                $destinationNumber,
                [
                    'from' => $this->fromNumber,
                    'body' => $message
                ]
            );
        } catch (TwilioException $e) {
            $code = $e->getCode();
            if($code == '21610') {
                // This person has asked for no more SMS updates
                // https://www.twilio.com/docs/api/errors/21610
                // TODO: ensure we set this to ignore
            } elseif ($code == '21617') {
                // This message was over the Twilio SMS limit
                // Break into halves and try again?
                $half = ceil(count(explode(' ', $message)) / 2);
                $this->sms($destinationNumber, substr($message, 0, $half));
                $this->sms($destinationNumber, substr($message, $half));
            } else {
                // If we don't know about this error, we should go ahead and re-throw the exception.
                Log::error("Error sending Twilio SMS to {$destinationNumber}! {$e->getMessage()} {$e->getCode()}");
            }
        }

    }


}