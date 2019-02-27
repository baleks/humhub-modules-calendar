<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

use humhub\modules\calendar\models\CalendarEntry;
use humhub\modules\calendar\widgets\ContainerConfigMenu;
use humhub\modules\calendar\widgets\GlobalConfigMenu;
use humhub\modules\space\widgets\SpacePickerField;
use humhub\widgets\ModalButton;

/* @var $this \humhub\components\View */
/* @var $contentContainer \humhub\modules\content\components\ContentContainerActiveRecord */
/* @var $filters */
/* @var $spaces */
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

        <?php $form = \yii\widgets\ActiveForm::begin() ?>
        <div class="calendar-filters">
            <div class="row">
                <div class="col-sm-3">
                    <strong style="padding-left:10px;">
                        <?= Yii::t('CalendarModule.views_export_index', 'Filter events'); ?>
                    </strong>
                </div>
                <div class="col-sm-3">
                    <strong style="padding-left:10px;">
                        <?= Yii::t('CalendarModule.views_export_index', 'Only space events'); ?>
                    </strong>
                </div>
                <div class="col-sm-4">
                    <strong style="padding-left:10px;">
                        <?= Yii::t('CalendarModule.views_export_index', 'Calendar type'); ?>
                    </strong>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-3">
                    <div class="checkbox">
                        <label class="calendar_filter_participate">
                            <input type="checkbox" name="filters[]" class="filterCheckbox" value="<?= CalendarEntry::FILTER_PARTICIPATE; ?>"
                                   <?php if (in_array(CalendarEntry::FILTER_PARTICIPATE, $filters)): ?>checked="checked"<?php endif; ?>>
                            <?= Yii::t('CalendarModule.views_global_index', 'Only I\'m participating'); ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label class="calendar_filter_mine">
                            <input type="checkbox" name="filters[]" class="filterCheckbox" value="<?= CalendarEntry::FILTER_MINE; ?>"
                                   <?php if (in_array(CalendarEntry::FILTER_MINE, $filters)): ?>checked="checked"<?php endif; ?>>
                            <?= Yii::t('CalendarModule.views_global_index', 'Only my events'); ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label class="calendar_filter_mine">
                            <input type="checkbox" name="filters[]" class="filterCheckbox" value="<?= CalendarEntry::FILTER_PUBLIC; ?>"
                                   <?php if (in_array(CalendarEntry::FILTER_PUBLIC, $filters)): ?>checked="checked"<?php endif; ?>>
                            <?= Yii::t('CalendarModule.views_global_index', 'Only public events'); ?>
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?= \humhub\modules\ui\filter\widgets\PickerFilterInput::widget([
                        'changeAction' => null,
                        'picker' => SpacePickerField::class,
                        'pickerOptions' => [
                            'name' => 'spaces',
                            'defaultResults' => $spaces,
                        ]
                    ])?>
                </div>
                <div class="col-sm-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="calendars" value="<?= CalendarEntry::FILTER_PROFILE_CALENDAR; ?>" checked="checked" />
                            <?= Yii::t('CalendarModule.views_global_index', 'Profile calendar'); ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="calendars" value="<?= CalendarEntry::FILTER_PROFILE_SPACES_CALENDARS; ?>" />
                            <?= Yii::t('CalendarModule.views_global_index', 'Profile and spaces calendars'); ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="calendars" value="<?= CalendarEntry::FILTER_EXTERNAL_CALENDARS; ?>" />
                            <?= Yii::t('CalendarModule.views_global_index', 'External calendars'); ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="calendars" value="<?= CalendarEntry::FILTER_ALL_CALENDARS; ?>" />
                            <?= Yii::t('CalendarModule.views_global_index', 'All calendars'); ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <?= ModalButton::submitModal($contentContainer->createUrl('/calendar/container-config/generate-export-link'), Yii::t('CalendarModule.config', 'Generate export Url')); ?>

        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
</div>