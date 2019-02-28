<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\calendar\controllers;

use DateTime;
use humhub\modules\calendar\interfaces\CalendarService;
use humhub\modules\calendar\models\CalendarEntry;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\user\models\User;
use Yii;

class ExportController extends ContentContainerController
{

    public function actionExportEvents()
    {
        $filters = Yii::$app->request->get('filters', []);
        if ($this->contentContainer instanceof User) {
            Yii::$app->user->setIdentity($this->contentContainer);
        }
        $calendars = ! empty($filters['calendars']) ? $filters['calendars'] : CalendarEntry::FILTER_PROFILE_CALENDAR;
        $items = $this->getCalendarItems($calendars, $filters);
        $ics = CalendarEntry::generateMultipleIcs($items);
        return Yii::$app->response->sendContentAsFile($ics, uniqid() . '.ics', ['mimeType' => 'text/calendar']);
    }

    private function getCalendarItems($calendars, $filters)
    {
        $calendarService = $this->module->get(CalendarService::class);
        $start = new DateTime('-6 month');
        $end = new DateTime('+12 month');

        switch ($calendars) {
            case CalendarEntry::FILTER_PROFILE_CALENDAR :
                return $calendarService->getCalendarEntryEvents($start, $end, $this->contentContainer, $filters, null);
            case CalendarEntry::FILTER_PROFILE_SPACES_CALENDARS :
                return $calendarService->getCalendarEntryEvents($start, $end, null, $filters, null);
            case CalendarEntry::FILTER_EXTERNAL_CALENDARS :
                return $calendarService->getCalendarItemsEvents(null, $start, $end, $filters, null, true);
            case CalendarEntry::FILTER_ALL_CALENDARS :
                return $calendarService->getCalendarItems($start, $end, $filters);
            default :
                return [];
        }
    }
}