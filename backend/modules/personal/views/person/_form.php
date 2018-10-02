<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Team;

/* @var $this yii\web\View */
/* @var $model common\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($user, 'username')->textInput() ?>

    <?= $form->field($user, 'password_hash')->textInput() ?>

    <?= $form->field($model, 'firtname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'Team_teamID')->dropDownList(ArrayHelper::map(Team::find()->all(), 'teamID', 'teamName'), [
        'prompt' => 'เลือกทีมหรือหน่วยงาน..'
    ])
    ?>

    <?=
            $form->field($user, 'role')
            ->dropDownList(['2' => 'ผู้ใช้ทั่วไป (User)',
                '1' => 'คณะกรรมการพิจารณา IR (Manager)'])
    ?>

    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'เพิ่ม' : 'แก้ไข', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>

