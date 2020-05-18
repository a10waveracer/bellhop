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

    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::create(2020, 5, 3, 12, 2, 0, 'America/New_York'));
        $this->user = User::create([
            'name' => $this->faker->firstName,
            'timezone' => 'America/New_York',
            'phone_number' => '+13030123123',
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddingStartingPriceForUser()
    {
        $targetPrice = 101;
        $now = Carbon::now();

        Week::storePrice($this->user->phone_number,$targetPrice);

        /** @var Week $week */
        $week = Week::where('year', '=', $now->year)
            ->where('week', '=', $now->week)
            ->where('user_id', '=', $this->user->id)
            ->first();

        $this->assertEquals(
            $week->price_start,
            $targetPrice,
            'Could not assert price_start was set on the correct week'
        );
        $this->assertNull($week->price_monday_morning);
    }

    public function testAddingStartingPriceAndMondayPriceForUser()
    {
        $targetPrice = 33;
        $this->testAddingStartingPriceForUser();

        // Move forward to Monday
        $now = Carbon::now();
        Carbon::setTestNow($now->addDay());

        Week::storePrice($this->user->phone_number, $targetPrice);

        /** @var Week $week */
        $week = Week::where('year', '=', $now->year)
            ->where('week', '=', $now->week)
            ->where('user_id', '=', $this->user->id)
            ->first();

        $all = Week::all();

        $this->assertNotNull($week->price_start);
        $this->assertNull($week->price_monday_morning);
        $this->assertEquals(
            $week->price_monday_night,
            $targetPrice,
            'Could not assert price_monday_morning was set on the correct week'
        );
        $this->assertNull($week->price_monday_morning);
    }

    public function testAddingTrendForUser()
    {
        $trend = 3;
        $now = Carbon::now();

        Week::storePrice($this->user->phone_number, $trend);

        /** @var Week $week */
        $week = Week::where('year', '=', $now->year)
            ->where('week', '=', $now->week)
            ->where('user_id', '=', $this->user->id)
            ->first();

        $this->assertEquals(
            $week->previous_trend,
            $trend,
            'Could not assert price_start was set on the correct week'
        );
        $this->assertNull($week->price_monday_morning);
        $this->assertNull($week->price_start);
    }


}
