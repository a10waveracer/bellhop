<?php


namespace App\Helpers;


use Carbon\Carbon;

class AcnhTimeHelper
{

    /**
     * ACNH rules are that
     *  - stalk prices change at 0000 and 1200
     *  - Shop opens at 0800
     *  - Shop closes at 2200
     *  - Daisy Mae shows up between 0400 and 1200 on Sundays
     *
     * Therefore between Sunday 0400 and Monday 0800 we'll assume the user
     *  is setting the bell cost price. Otherwise it's the most recent 'window'.
     *
     * // TODO: Add tests
     *
     */
    static function timeDetermine(Carbon $submissionTime)
    {
        if(self::_isSettingBellStartingPrice($submissionTime)){
            return 'price_start';
        }

        $dayToStore = self::_determineWhichDay($submissionTime);
        $nightOrDayToStore = self::_determineMorningNight($submissionTime);

        return "price_{$dayToStore}_{$nightOrDayToStore}";
    }

    static function _isSettingBellStartingPrice(Carbon $submissionTime)
    {
        if($submissionTime->dayOfWeek == 0 && $submissionTime->hour >= 4){
            return true;
        }
        if($submissionTime->dayOfWeek == 1 && $submissionTime->hour < 8){
            return true;
        }
        return false;
    }

    static function _determineWhichDay(Carbon $submissionTime)
    {
        if($submissionTime->hour < 8){
            $timeCopy = $submissionTime->copy();
            $timeCopy->subDay();
            return strtolower($timeCopy->englishDayOfWeek);
        } else {
            return strtolower($submissionTime->englishDayOfWeek);
        }
    }

    static function _determineMorningNight(Carbon $submissionTime)
    {
        if($submissionTime->hour < 12 && $submissionTime->hour >= 8){
            return 'morning';
        } else {
            return 'night';
        }
    }

}