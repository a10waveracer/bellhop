<?php

namespace App\Console\Commands;

use App\Helpers\TwilioHelper;
use App\User;
use App\Week;
use Illuminate\Console\Command;

class SendMessages extends Command
{
    protected $signature = 'bellhop:send';

    protected $description = 'Send SMS to users';

    public TwilioHelper $twilio;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->twilio = new TwilioHelper();
        $users = User::all();
        foreach($users as $user){
            if($user->needsMessageSent()){
                if($user->now()->isSunday()){
                    $this->sendSundayMorningMessage($user);
                } else {
                    $this->sendWeeklyMessages($user);
                }
            }
        }
    }

    public function sendSundayMorningMessage(User $user)
    {
        \Log::info("Sending message to {$user->name} at {$user->phone_number}");
        $message = "Happy Stalkday! What was last week's trend?\n";
        foreach(Week::TRENDS as $key => $trendName){
            $message .= "{$key} => {$trendName}\n";
        }
        $this->twilio->sms(
            $user->phone_number,
            'Happy Sunday'
        );

    }

    public function sendWeeklyMessages(User $user)
    {

    }

}
