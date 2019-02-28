<?php

use yii\helpers\Html;

?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                Calendar export link
            </h4>
        </div>
        <div class="modal-body">

            <div class="clearfix">
                <textarea rows="3" class="form-control export-link-txt" spellcheck="false" readonly><?= Html::encode($exportLink) ?></textarea>
                <p class="help-block pull-right">
                    <a href="#" data-action-click="copyToClipboard" data-action-target=".export-link-txt">
                        <i class="fa fa-clipboard" aria-hidden="true"></i> <?= Yii::t('CalendarModule.config', 'Copy to clipboard'); ?>
                    </a>
                </p>
            </div>
        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-primary" data-dismiss="modal">
                <?= Yii::t('CalendarModule.config', 'Close'); ?>
            </button>

            <?= Html::a(Yii::t('CalendarModule.config', 'Download ICal'), $exportLink, ['class' => 'btn btn-primary', 'target' => '_blank']); ?>

        </div>
    </div>
</div>

