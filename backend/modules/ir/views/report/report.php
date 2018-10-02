<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'รายงานอุบัติการณ์แยกตามหน่วยงานที่แจ้ง เดือน' . $month;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('เดือนก่อนหน้า', ['reportprev'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('เดือนถัดไป', ['reportnext'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('สรุปยอดปี ' . $y, ['reportall'], ['class' => 'btn btn-info']) ?>
            </p>
            <?=
            Highcharts::widget([
                'options' => [
                    'title' => ['text' => 'สรุปการรายงานอุบัติการณ์'],
                    'xAxis' => [
                        'categories' => ['หน่วยงาน']
                    ],
                    'yAxis' => [
                        'title' => ['text' => 'จำนวน (ครั้ง)']
                    ],
                    'series' => $graph,
                ]
            ])
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'teamName',
                        'label' => 'หน่วยงานที่แจ้ง'
                    ],
                    [
                        'attribute' => 'counter',
                        'label' => 'จำนวน (ครั้ง)'
                    ],
                ],
            ])
            ?>
            <p>***หมายเหตุ ใบรายงานอุบัติการณ์ที่ยังไม่พิจารณาจะไม่แสดงผลภายในกราฟและตารางสรุปผล</p>
        </div>
    </div>
