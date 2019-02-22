<?php

/**
 *Original script: https://gist.github.com/jakebellacera/635416
 */

namespace humhub\modules\calendar\models;

use DateInterval;
use DateTime;
use Yii;

class MultipleIcs
{
    const DT_FORMAT_TIME = 'php:His';
    const DT_FORMAT_DAY = 'php:Ymd';

    protected $events;

    /**
     * MultipleIcs constructor.
     * @param $events
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    public function __toString()
    {
        $rows = $this->buildProps();
        $string =  implode("\r\n", $rows);
        return $string;
    }

    private function buildProps()
    {
        $ics_calendar = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//hacksw/handcal//NONSGML v1.0//EN',
            'CALSCALE:GREGORIAN',
        ];

        foreach ($this->events as $event) {
            $end_datetime = $event->all_day ? (new DateTime($event->end_datetime))->add(new DateInterval('P1D')) : $event->end_datetime;
            $ics_event = [
                'BEGIN:VEVENT',
                'LOCATION:',
                'DESCRIPTION:' . $this->escapeString($event->description),
                'DTSTART:' . $this->formatTimestamp($event->start_datetime, $event->all_day),
                'DTEND:' . $this->formatTimestamp($end_datetime, $event->all_day),
                'SUMMARY:' . $this->escapeString($event->title),
                'URL:',
                'DTSTAMP:' . $this->formatTimestamp('now'),
                'UID:' . uniqid(),
                'END:VEVENT'
            ];
            $ics_calendar = array_merge($ics_calendar, $ics_event);
        }
        $ics_calendar[] = 'END:VCALENDAR';
        return $ics_calendar;
    }

    private function formatTimestamp($timestamp, $allDay = false)
    {
        $dt = ($timestamp instanceof DateTime) ? $timestamp : new DateTime($timestamp);
        $result =  Yii::$app->formatter->asDate($dt, self::DT_FORMAT_DAY);

        if(!$allDay) {
            $result .= "T".  Yii::$app->formatter->asTime($dt, self::DT_FORMAT_TIME);
        }

        return $result;
    }

    private function escapeString($str)
    {
        return preg_replace('/([\,;])/','\\\$1', $str);
    }
}
