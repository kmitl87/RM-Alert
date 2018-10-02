<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Incidentreport */

$this->title = 'แก้ไขใบรายงานอุบัติการณ์: ' . $model->irID;
$this->params['breadcrumbs'][] = ['label' => 'รายงานอุบัติการณ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->irID, 'url' => ['view', 'id' => $model->irID]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
<div class="box box-warning box-solid">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-file-text"></i>  <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
