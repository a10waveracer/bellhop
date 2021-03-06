<?php

namespace App;

use App\Helpers\AcnhTimeHelper;
use App\Helpers\TwilioHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class Week extends Model
{
    protected $fillable = [
        'year',
        'week',
        'price_start',
        'price_monday_morning',
        'price_monday_night',
        'price_tuesday_morning',
        'price_tuesday_night',
        'price_wednesday_morning',
        'price_wednesday_night',
        'price_thursday_morning',
        'price_thursday_night',
        'price_friday_morning',
        'price_friday_night',
        'price_saturday_morning',
        'price_saturday_night',
        'user_id',
        'previous_trend',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    const TRENDS = [
        0 => 'Fluctuating',
        1 => 'Large Spike',
        2 => 'Decreasing',
        3 => 'Small Spike',
        4 => "IDK", // It's actually null, but this will make it easier
    ];


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    // TODO: Send in user
    static function storePrice($phoneNumber, $messageBody): bool
    {
        try {
            /** @var User $user */
            $user = User::where('phone_number', '=', $phoneNumber)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Log::error("Could not find a user with phone {$phoneNumber}");
            return false;
        }

        // TODO: This may not handle when someone submits a value on Sunday morning and we need to roll back the week
        $now = $user->now();
        $week = Week::where('year', '=', $now->year)
            ->where('week', '=', $now->week)
            ->where('user_id', '=', $user->id)
            ->firstOrCreate([
                'year' => $now->year,
                'week' => $now->week,
                'user_id' => $user->id,
            ]);

        if (Week::_shouldStoreTrend($user, $messageBody)) {
            $key = 'previous_trend';
        } else {
            $key = AcnhTimeHelper::timeDetermine($now);
        }

        $week->update([
            $key => (int)$messageBody
        ]);

        if($key == 'previous_trend'){
            return false;
        } else {
            return true;
        }
    }

    static function _shouldStoreTrend(User $user, $messagebody): bool
    {
        // We'll use 0-10 for reserved events; bells should never be this cheap
        if($messagebody >= 10){
            return false;
        }
        // todo: refactor this into a separate event or somesuch
        $twilio = new TwilioHelper();
        $twilio->sms(
            $user->phone_number,
            "Great, thanks! What is Daisy Mae's stalk buy price today?");
        return true;
    }

    public function getUrlAttribute()
    {
        return "https://turnipprophet.io/?prices={$this->price_start}.".
            "{$this->price_monday_morning}.{$this->price_monday_night}." .
            "{$this->price_tuesday_morning}.{$this->price_tuesday_night}." .
            "{$this->price_wednesday_morning}.{$this->price_wednesday_night}." .
            "{$this->price_thursday_morning}.{$this->price_thursday_night}." .
            "{$this->price_friday_morning}.{$this->price_friday_night}." .
            "{$this->price_saturday_morning}.{$this->price_saturday_night}." .
            "&pattern={$this->previous_trend}";
    }

    public function getPricesAttribute()
    {
        // We really do need price_start twice, for the prediction.js API
        return "{$this->price_start}.{$this->price_start}." .
            "{$this->price_monday_morning}.{$this->price_monday_night}." .
            "{$this->price_tuesday_morning}.{$this->price_tuesday_night}." .
            "{$this->price_wednesday_morning}.{$this->price_wednesday_night}." .
            "{$this->price_thursday_morning}.{$this->price_thursday_night}." .
            "{$this->price_friday_morning}.{$this->price_friday_night}." .
            "{$this->price_saturday_morning}.{$this->price_saturday_night}.";
    }

    public function getLastUpdatedAttribute()
    {
        if ($this->price_saturday_night) {
            return "Saturday PM";
        } else if ($this->price_saturday_morning) {
            return "Saturday AM";
        } else if ($this->price_friday_night) {
            return "Friday PM";
        } else if ($this->price_friday_morning) {
            return "Friday AM";
        } else if ($this->price_thursday_night) {
            return "Thursday PM";
        } else if ($this->price_thursday_morning) {
            return "Thursday AM";
        } else if ($this->price_wednesday_night) {
            return "Wednesday PM";
        } else if ($this->price_wednesday_morning) {
            return "Wednesday AM";
        } else if ($this->price_tuesday_night) {
            return "Tuesday PM";
        } else if ($this->price_tuesday_morning) {
            return "Tuesday AM";
        } else if ($this->price_monday_night) {
            return "Monday PM";
        } else if ($this->price_monday_morning) {
            return "Monday AM";
        } else if ($this->price_start) {
            return "Sunday";
        }
        return "--";
    }

    public function getPreviousTrendAttribute()
    {
        return $this->attributes['previous_trend'] == 4 ? null : $this->attributes['previous_trend'];
    }
}
