<?php

namespace Tests\Unit;

use App\User;
use App\Week;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeekTest extends TestCase
{
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddingForUser()
    {
        Carbon::setTestNow(Carbon::create(2020, 5, 3, 12));

        $user = User::create([
            'name' => $this->faker->firstName,
            'timezone' => 'America/New_York',
            'phone_number' => '+13030123123',
        ]);
        $now = Carbon::now();

        Week::storePrice($user->phone_number,
        101);

        $allWeeks = Week::all();

        $week = Week::where('year', '=', $now->year)
            ->where('week', '=', $now->weekOfYear)
            ->where('user_id', '=', $user->id)
            ->first();

        $this->assertEquals(
            $week->price_start,
            101,
            'Could not assert price_start was set on the correct week'
        );
    }
}
