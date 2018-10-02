<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Team;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\personal\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'จัดการข้อมูลผู้ใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i>  <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('เพิ่มผู้ใช้งาน', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                /* ['class' => 'yii\grid\SerialColumn'],
                  [
                  'attribute' => 'photo',
                  'format' =>'html',
                  'value' => function($model){
                  return Html::img('uploads/person/'.$model->photo, ['class' => 'thumbnail', 'width'=>120]);

                  }
                  ], */
                'user.username',
                'firtname',
                'lastname',
                [
                    'attribute' => 'Team_teamID',
                    'value' => function($model) {
                        return $model->teamTeam->teamName;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'Team_teamID', ArrayHelper::map(Team::find()->all(), 'teamID', 'teamName'), ['class' => 'form-control']),
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
    </div>
</div>