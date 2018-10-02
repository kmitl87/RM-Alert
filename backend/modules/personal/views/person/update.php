<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = 'แก้ไขข้อมูล: ' . ' ' . $model->firtname.' '.$model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลผู้ใช้งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->firtname.' '.$model->lastname, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-user-circle"></i>  <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">

        <?=
        $this->render('_form', [
            'model' => $model,
            'user' => $user,
        ])
        ?>

    </div>
</div>
