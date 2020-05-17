<?php

namespace App;

use App\Helpers\AcnhTimeHelper;
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
        'previous_week',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public $trends = [
        null => "IDK",
        0 => 'Fluctuating',
        3 => 'Small Spike',
        1 => 'Large Spike',
        2 => 'Decreasing',
    ];


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    static function storePrice($phoneNumber, $messageBody): void
    {
        try{
            $user = User::where('phone_number', '=', $phoneNumber)->firstOrFail();
        } catch(ModelNotFoundException $e){
            Log::error("Could not find a user with phone {$phoneNumber}");
            return;
        }

        // TODO: This may not handle when someone submits a value on Sunday morning and we need to roll back the week
        $now = Carbon::now($user->timezone);

        $weeks = Week::all();

        $week = Week::where('year', '=', $now->year)
            ->where('week', '=', $now->week)
            ->where('user_id', '=', $user->id)
            ->firstOrCreate([
                'year' => $now->year,
                'week' => $now->week,
                'user_id' => $user->id,
            ]);

        $week->update([
            AcnhTimeHelper::timeDetermine($now) => (int) $messageBody
        ]);

        $week->save();
    }
}
