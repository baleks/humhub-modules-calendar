<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

use humhub\modules\calendar\widgets\ContainerConfigMenu;
use humhub\modules\calendar\widgets\GlobalConfigMenu;
use yii\helpers\Html;

/* @var $this \humhub\components\View */
/* @var $contentContainer \humhub\modules\content\components\ContentContainerActiveRecord */
?>



<div class="panel panel-default">

    <div class="panel-heading"><?= Yii::t('CalendarModule.config', '<strong>Calendar</strong> module configuration'); ?></div>

    <?php if($contentContainer === null) : ?>
        <?= GlobalConfigMenu::widget() ?>
    <?php else: ?>
        <?= ContainerConfigMenu::widget()?>
    <?php endif; ?>

    <div class="panel-body">
        <div class="clearfix">
            <h4>
                <?= Yii::t('CalendarModule.config', 'Other Calendars Configuration'); ?>
            </h4>

            <div class="help-block">
                <?= Yii::t('CalendarModule.config', 'Here you can create an ICal export link.') ?>
            </div>

        </div>

        <?= \humhub\modules\calendar\widgets\ImportExportMenu::widget(); ?>

        <?= Html::a(Yii::t("CalendarModule.config", "Generate export Url"),
                    $contentContainer->createUrl('/calendar/container-config/generate-export-link'),
                    ['class' => 'btn btn-primary', 'data-target' => '#globalModal']
        ); ?>
    </div>
</div>