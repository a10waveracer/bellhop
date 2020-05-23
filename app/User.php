<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'phone_number',
        'paused',
        'timezone',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public int $sundaySendHour = 11;

    public int $morningSendHour = 8;

    public int $eveningSendHour = 12;


    public function group()
    {
        return $this->belongsTo(\App\Group::class);
    }

    public function needsMessageSent()
    {
        // TODO: tests
        $now = $this->now();

        if($this->hasPaused($now)){
            return false;
        }
        if($now->isSunday()){
            return $now->hour == $this->sundaySendHour;
        }
        if($now->hour == $this->morningSendHour || $now->hour == $this->eveningSendHour){
            return true;
        }
        return false;
    }

    public function hasPaused($now): bool
    {
        // Needs to be <= because it's a date field, so we'll snooze until saturday
        // So if it's a saturday we should also not message.
        return $now <= $this->paused;
    }

    public function now(): Carbon
    {
        return Carbon::now($this->timezone);
    }

}
