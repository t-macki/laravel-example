<?php
namespace Domain\Services\Shared;

use Carbon\Carbon;

class DataService
{
    public static function checkDataMax(string $at, string $add)
    {
        $max = new Carbon($at);
        $max->addDay($add);
        $now = new Carbon();
        if ($now->gt($max)) {
            return false;
        }
        return true;
    }

    public static function getYearList()
    {

        $startdt = new Carbon('1930-01-01');
        $enddt = new Carbon();
        $enddt->addYear();

        $yearList = [];
        while ($startdt->lte($enddt)) {
            $yearList[$startdt->year] = $startdt->year;
            $startdt->addYear();
        }

        return $yearList;
    }

    public static function getMonthList()
    {
        $monthList = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthList[$i] = $i;
        }
        return $monthList;
    }

    public static function getDayList()
    {
        $dayList = [];
        for ($i = 1; $i <= 31; $i++) {
            $dayList[$i] = $i;
        }
        return $dayList;
    }

    public static function getHourList()
    {
        $hourList = [];
        for ($i = 1; $i <= 24; $i++) {
            $hour = sprintf('%02d', $i);
            $hourList[$hour] = $hour;
        }
        return $hourList;
    }

    public static function getMinuteList()
    {
        return [
            '00' => '00',
            '30' => '30',
        ];
    }
}
