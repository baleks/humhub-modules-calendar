<?php

namespace humhub\modules\calendar\widgets;

use humhub\modules\calendar\interfaces\CalendarService;
use humhub\widgets\BaseMenu;
use Yii;

class ImportExportMenu extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/subTabMenu";

    public function init()
    {
        $controller = Yii::$app->controller;

        /* @var $calendarService CalendarService */
        $calendarService =  Yii::$app->getModule('calendar')->get(CalendarService::class);

        if(!empty($calendarService->getCalendarItemTypes($controller->contentContainer))) {
            $this->addItem([
                'label' => Yii::t('CalendarModule.widgets_ImportExportMenu', 'Import'),
                'url' => $controller->contentContainer->createUrl('/calendar/container-config/import'),
                'sortOrder' => 100,
                'isActive' => ($controller->module && $controller->module->id == 'calendar' && $controller->id == 'container-config' && $controller->action->id == 'import'),
            ]);
        }

        $this->addItem([
            'label' => Yii::t('CalendarModule.widgets_ImportExportMenu', 'Export'),
            'url' => $controller->contentContainer->createUrl('/calendar/container-config/export'),
            'sortOrder' => 200,
            'isActive' => ($controller->module && $controller->module->id == 'calendar' && $controller->id == 'container-config' && $controller->action->id == 'export'),
        ]);

        parent::init();
    }
}