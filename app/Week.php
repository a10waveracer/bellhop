<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
