<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Level;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ir\models\IncidentreportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานอุบัติการณ์ทั้งหมด';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning box-solid">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-file-text"></i>  <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'irID',
                'riskDate',
                //'riskTime',
                //'location',
                //'sufID',
                //'HN',
                //'AN',
                //'staff',
                //'position',
                //'tel',
                'issue',
                //'detail:ntext',
                //'repairable:ntext',
                //'result',
                //'infromID',
                [
                    'attribute' => 'levelID',
                    'format' => 'html',
                    'value' => function($model) {
                        return Yii::$app->levelStatus->getLavel($model->levelID); 
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'levelID', ArrayHelper::map(Level::find()->all(), 'levelID', 'levelName'), ['class' => 'form-control']),
                ],
                //'recomment:ntext',
                //'created_by',
                //'updated_by',
                //'created_at',
                //'updated_at',
                [
                    'attribute' => 'status',
                    'filter' => [0 => 'รอพิจารณา', 1 => 'พิจารณาแล้ว'], //กำหนด filter แบบ dropDownlist จากข้อมูล array
                    'format' => 'raw',
                    'value' => function($model, $key, $index, $column) {
                        return $model->status == 0 ? 
                        '<span class="label label-warning">รอพิจารณา</span>':
                        '<span class="label label-success">พิจารณาแล้ว</span>';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',

                ],
            ],
        ]);
        ?>
    </div>
</div>