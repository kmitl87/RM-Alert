<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;
use kartik\widgets\DepDrop;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use common\models\Sufferer;
use common\models\Infrom;
use common\models\Level;
use common\models\Team;
use common\models\RiskType;
use common\models\RiskProfile;
use common\models\RiskList;

/* @var $this yii\web\View */
/* @var $model common\models\Incidentreport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="incidentreport-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3 col-md-3">
            <?=
            $form->field($model, 'riskDate')->widget(
                    DatePicker::className(), [
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกวันที่เกิดเหตุ ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-3 col-md-3">
            <?=
            $form->field($model, 'riskTime')->widget(MaskedInput::className(), ['mask' => '99:99']
            )
            ?>
        </div>
    </div>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-4">
            <?=
                    $form->field($model, 'sufID')->textInput()
                    ->dropDownList(ArrayHelper::map(Sufferer::find()->all(), 'sufID', 'sufName'), [
                        'prompt' => 'เลือกผู้ประสบปัญหา..'
                            ]
            );
            ?>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4">
            <?= $form->field($model, 'HN')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?= $form->field($model, 'AN')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-4">
            <?= $form->field($model, 'staff')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4">
            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
        </div>
    </div> 

    <?= $form->field($model, 'issue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?=
    $form->field($model, 'items')->label(false)->widget(MultipleInput::className(), [
        'max' => 10, 
        'allowEmptyList' => false,
        'min' => 1, 
        'columns' => [
            [
                'name' => 'id',
                'title' => 'ID',
                'enableError' => true,
                'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
            ],
            [
                'name' => 'riskProID',
                'title' => 'รายการรหัสความเสี่ยง*',
                'type' => MultipleInputColumn::TYPE_DROPDOWN,
                'value' => function($data) {
                    return $data['riskProID'];
                },
                'items' => ArrayHelper::map(RiskProfile::find()->all(), 'riskProID', 'riskProName'),
                'enableError' => true,
                'options' => [
                    'class' => 'new_class',
                    'prompt' => 'เลือกรหัสความเสี่ยง..',
                    'onchange' => '$(this).init_change();' //ส่งค่าไปเรียก Ajax
                ]
            ],
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'teams')->label(false)->widget(MultipleInput::className(), [
        'max' => 5, 
        'allowEmptyList' => false,
        'min' => 1, 
        'columns' => [
            [
                'name' => 'id',
                'title' => 'ID',
                'enableError' => true,
                'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
            ],
            [
                'name' => 'teamID',
                'title' => 'รายการทีมหรือหน่วยงานที่เกี่ยวข้อง*',
                'type' => MultipleInputColumn::TYPE_DROPDOWN,
                'value' => function($data) {
                    return $data['teamID'];
                },
                'items' => ArrayHelper::map(Team::find()->all(), 'teamID', 'teamName'),
                'enableError' => true,
                'options' => [
                    'class' => 'new_class',
                    'prompt' => 'เลือกทีมหรือหน่วยงาน..',
                    'onchange' => '$(this).init_change();' //ส่งค่าไปเรียก Ajax
                ]
            ],
        ],
    ]);
    ?>

    <?= $form->field($model, 'repairable')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-sm-3 col-md-3">
            <?= $form->field($model, 'result')->radioList(array('1' => 'ควบคุมสถานการณ์ได้', '2' => 'ควบคุมสถานการณ์ไม่ได้')) ?>
        </div>
    </div>

    <?=
            $form->field($model, 'infromID')
            ->dropDownList(ArrayHelper::map(infrom::find()->all(), 'infromID', 'infromName'), [
                'prompt' => 'เลือกการรายงานผู้บังคับบัญชา..'
    ]);
    ?>

    <?=
            $form->field($model, 'levelID')
            ->dropDownList(ArrayHelper::map(level::find()->all(), 'levelID', 'levelDet'), [
                'prompt' => 'เลือกระดับความรุนแรง..'
                    ]
    );
    ?>                                               

    <?= $form->field($model, 'recomment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'บันทึก' : 'แก้ไข', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    $('#w1').on('afterInit', function(){
            console.log('calls on after initialization event');
        }).on('beforeAddRow', function(e) {
            console.log('calls on before add row event');
        }).on('afterAddRow', function(e) {
            console.log('calls on after add row event');
        }).on('beforeDeleteRow', function(e, item){
            console.log(item);
            return confirm('คุณแน่ใจนะว่าต้องการลบ?'); 
        }).on('afterDeleteRow', function(e, item){
            var rl_id = item.find('.list-cell__riskProID').find('input[id*=\"incidentreport-items-\"][id$=\"-id\"]').val();
            console.log(rl_id);
            //alert(id_case + from_id);
            $.get(\"" . Url::to(['/ir/incidentreport/delete?risklist_id=']) . "\" + rl_id,
                function(data, status){
                    //alert(\"Data: \" + data); // + \"Status: \" + status
                }
            );
    });
    
    $('#w2').on('afterInit', function(){
            console.log('calls on after initialization event');
        }).on('beforeAddRow', function(e) {
            console.log('calls on before add row event');
        }).on('afterAddRow', function(e) {
            console.log('calls on after add row event');
        }).on('beforeDeleteRow', function(e, item){
            console.log(item);
            return confirm('คุณแน่ใจนะว่าต้องการลบ?'); 
        }).on('afterDeleteRow', function(e, item){
            var t_id = item.find('.list-cell__teamID').find('input[id*=\"incidentreport-teams-\"][id$=\"-id\"]').val();
            console.log(t_id);
            //alert(id_case + from_id);
            $.get(\"" . Url::to(['/ir/incidentreport/delete?teamlist_id=']) . "\" + t_id,
                function(data, status){
                    //alert(\"Data: \" + data); // + \"Status: \" + status
                }
            );
    });

")?>