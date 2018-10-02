<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = $model->firtname . ' ' . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'ขัอมูลผู้ใช้งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if($model->user->role == '1'){
    $userRole = 'คณะกรรมการพิจารณา IR';
}else{
    $userRole = 'ผู้ใช้ทั่วไป';
}
?>
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-user"></i>  <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">

        <p>
            <?= Html::a('แก้ไข', ['update', 'id' => $model->user_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบ', ['delete', 'id' => $model->user_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'คุณแน่ใจแล้วหรือไม่..ที่จะลบบัญชีผู้ใช้นี้?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <div class="text-center">
            <?= Html::img('uploads/person/'. $model->photo, ['class' => 'thumbnail','width'=>350])?>
        </div>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'user.username',
                'firtname',
                'lastname',
                //'photo',
                'teamTeam.teamName',
                [
                    'label' => 'สิทธิการเช้าใช้งาน',
                    'value' => $userRole,
                ]
            ],
        ])
        ?>

    </div>
</div>
