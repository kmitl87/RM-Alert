<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\ir\models\IncidentreportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="incidentreport-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'irID') ?>

    <?= $form->field($model, 'riskDate') ?>

    <?= $form->field($model, 'riskTime') ?>

    <?= $form->field($model, 'location') ?>

    <?= $form->field($model, 'sufID') ?>

    <?php // echo $form->field($model, 'HN') ?>

    <?php // echo $form->field($model, 'AN') ?>

    <?php // echo $form->field($model, 'staff') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'issue') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'repairable') ?>

    <?php // echo $form->field($model, 'result') ?>

    <?php // echo $form->field($model, 'infromID') ?>

    <?php // echo $form->field($model, 'levelID') ?>

    <?php // echo $form->field($model, 'recomment') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
