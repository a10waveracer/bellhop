<?php

namespace Tests\Unit;

use App\Helpers\AcnhTimeHelper;
use Carbon\Carbon;
use Tests\TestCase;;

class AcnhTimeHelperTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSundays()
    {
        $time = Carbon::create(2020, 5, 3, 3);
        $this->assertEquals(
            'price_saturday_night',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 3, 5);
        $this->assertEquals(
            'price_start',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 3, 12);
        $this->assertEquals(
            'price_start',
        AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 3, 23);
        $this->assertEquals(
            'price_start',
            AcnhTimeHelper::timeDetermine($time));
    }

    public function testMondays()
    {
        $time = Carbon::create(2020, 5, 4, 4);
        $this->assertEquals(
            'price_start',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 4, 8);
        $this->assertEquals(
            'price_monday_morning',
            AcnhTimeHelper::timeDetermine($time));


        $time = Carbon::create(2020, 5, 4, 11, 59);
        $this->assertEquals(
            'price_monday_morning',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 4, 12);
        $this->assertEquals(
            'price_monday_night',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 4, 23);
        $this->assertEquals(
            'price_monday_night',
            AcnhTimeHelper::timeDetermine($time));
    }

    public function testTuesdays()
    {
        $time = Carbon::create(2020, 5, 5, 4);
        $this->assertEquals(
            'price_monday_night',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 5, 8);
        $this->assertEquals(
            'price_tuesday_morning',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 5, 11, 59);
        $this->assertEquals(
            'price_tuesday_morning',
            AcnhTimeHelper::timeDetermine($time));

        $time = Carbon::create(2020, 5, 5, 12);
        $this->assertEquals(
            'price_tuesday_night',
            AcnhTimeHelper::timeDetermine($time));
    }
}
