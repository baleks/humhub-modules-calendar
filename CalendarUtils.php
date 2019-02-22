<?php

namespace humhub\modules\calendar;

use DateTime;
use humhub\modules\calendar\models\CalendarEntry;

/**
 * Description of CalendarUtils
 *
 * @author luke
 */
class CalendarUtils
{

    /**
     *
     * @param DateTime $date1
     * @param DateTime $date2
     * @param type $endDateMomentAfter
     * @return boolean
     */
    public static function isFullDaySpan(DateTime $date1, DateTime $date2, $endDateMomentAfter = false)
    {
        $dateInterval = $date1->diff($date2, true);

        if ($endDateMomentAfter) {
            if ($dateInterval->days > 0 && $dateInterval->h == 0 && $dateInterval->i == 0 && $dateInterval->s == 0) {
                return true;
            }
        } else {
            if ($dateInterval->h == 23 && $dateInterval->i == 59) {
                return true;
            }
        }


        return false;
    }

    public static function getFirstEventStartDate()
    {
        return CalendarEntry::find()->select('start_datetime')->orderBy('start_datetime ASC')->one()->start_datetime;
    }

    public static function getLastEventEndDate()
    {
        return CalendarEntry::find()->select('end_datetime')->orderBy('end_datetime DESC')->one()->end_datetime;
    }

}
