<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\Incidentreport */

$this->title = 'เลขที่ใบ ' . $model->irID;
$this->params['breadcrumbs'][] = ['label' => 'รายงานอุบัติการณ์', 'url' => ['incidentreport/userindex']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-file-text"></i>  <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">

        <p>
            <?= Html::a('แก้ไข', ['update', 'id' => $model->irID], ['class' => 'btn btn-warning']) ?>
        </p>

        <?=
        DetailView::widget([
            
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->status == 0 ? 
                        '<span class="label label-warning">รอพิจารณา</span>':
                        '<span class="label label-success">พิจารณาแล้ว</span>';
                    }
                ],
                'irID',
                                [
                    'attribute' => 'levelID',
                    'format' => 'html',
                    'value' => function($model) {
                        return Yii::$app->levelStatus->getLavel($model->levelID); 
                    },
                ],
                'riskDate',
                'riskTime',
                'location',
                'suf.sufName',
                'HN',
                'AN',
                'staff',
                'position',
                'tel',
                'issue',
                'detail:ntext',
                'repairable:ntext',
                [
                    'attribute' => 'result',
                    'format' => 'raw',
                    'value' => function($model) {
                        $result = $model->result;
                        if ($result == '1') {
                           return '<span class="label label-success">ควบคุมสถานการณ์ได้</span>';
                        } elseif ($result == '2') {
                            return '<span class="label label-danger">ควบคุมสถานการณ์ไม่ได้</span>';
                        } else {
                            return '<span class="label label-default">ไม่มีการแก้ไข</span>';
                        }
                    }
                ],
                'infrom.infromName',
                'recomment:ntext',
                [
                    'attribute' => 'created_by',
                    'value' => $model->userCreated->username,
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => $model->userUpdated->username,
                ],
                'created_at:date',
                'updated_at:dateTime',
            ],
        ])
        ?>
        <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'riskProname',
                        'label' => 'รายการรหัสความเสี่ยง'
                    ],
                ],
            ])
            ?>
        <?=
            GridView::widget([
                'dataProvider' => $dataProvider2,
                'columns' => [
                    [
                        'attribute' => 'teamName',
                        'label' => 'รายการทีมหรือหน่วยงานที่เกี่ยวข้อง'
                    ],
                ],
            ])
            ?>
    </div>
</div>
  