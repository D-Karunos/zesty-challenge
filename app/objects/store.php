<?php
include_once("app/db/sql.php");
include_once("app/interfaces/openingHours.php");

class store implements openingHours
{
    public $timetable;
    public $additionalInfo;

    public function init()
    {
        $this->timetable();
        $now = new DateTime('', new DateTimeZone($_SESSION['timezone']));
        $this->isOpen($now);
        $this->nextOpening($now);
        return [
            'timetable' => $this->timetable,
            'extra' => $this->additionalInfo,
        ];
    }

    public function timetable()
    {
        $this->timetable = (new sql())->getOpeningTimes();
    }
    public function isOpen(DateTime $now)
    {
        $dayFormat = $this->formatDays($now);
        $todaysTimetable = $this->timetable[$dayFormat['weekday']];
        $openNow = ($todaysTimetable['timeOpening'] < $dayFormat['time'] && $todaysTimetable['timeClosing'] > $dayFormat['time']);
        $this->timetable[$dayFormat['weekday']]['openNow'] = $openNow;
        $this->additionalInfo['isOpen'] = $openNow;
    }

    public function nextOpening(DateTime $now)
    {
        //Doing for in case there are no active days so function gracefully dies.
        for ($i = 7; $i > 0; $i--) {
            $nextDay = $now->modify('+1 day');
            $dayFormat = $this->formatDays($nextDay);
            if ($this->checkifActive($this->timetable[$dayFormat['weekday']])) {
                $this->additionalInfo['tomorrow'] = $dayFormat['fullWeekdayName'];
                break;
            }
        }
    }

    private function checkifActive($day)
    {
        if ($day['active'] == 1) {
            return true;
        }
        return false;
    }

    public function formatDays($datetime)
    {
        return [
            'weekday' => $datetime->format('D'),
            'fullWeekdayName' => $datetime->format('l'),
            'time' => $datetime->format('H:i:s'),
        ];
    }
}