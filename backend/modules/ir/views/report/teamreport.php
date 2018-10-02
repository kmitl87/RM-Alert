<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'รายงานอุบัติการณ์แยกตามหน่วยงานที่เกี่ยวข้อง เดือน' . $month;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('เดือนก่อนหน้า', ['teamprev'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('เดือนถัดไป', ['teamnext'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('สรุปยอดปี ' . $y, ['teamall'], ['class' => 'btn btn-info']) ?>
            </p>
            <?=
            Highcharts::widget([
                'options' => [
                    'title' => ['text' => 'สรุปการรายงานอุบัติการณ์'],
                    'xAxis' => [
                        'categories' => ['หน่วยงานที่เกี่ยวข้อง']
                    ],
                    'yAxis' => [
                        'title' => ['text' => 'จำนวน (ใบ)']
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
                        'label' => 'หน่วยงานที่เกี่ยวข้อง'
                    ],
                    [
                        'attribute' => 'counter',
                        'label' => 'จำนวน (ใบ)'
                    ],
                ],
            ])
            ?>
            <p>***หมายเหตุ ใบรายงานอุบัติการณ์ที่ยังไม่พิจารณาจะไม่แสดงผลภายในกราฟและตารางสรุปผล</p>
        </div>
    </div>
