<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'รายงานอุบัติการณ์แยกแยกตามรหัสความเสี่ยงในปี พ.ศ.'.$y;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('ปีก่อนหน้า', ['riskallp4'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('ปีถัดไป', ['riskallp2'], ['class' => 'btn btn-default'])?>
            </p>
            <?=
            Highcharts::widget([
                'options' => [
                    'title' => ['text' => 'สรุปการรายงานอุบัติการณ์'],
                    'xAxis' => [
                        'categories' => [
                            'ม.ค.',
                            'ก.พ.',
                            'มี.ค.',
                            'เม.ย.',
                            'พ.ค.',
                            'มิ.ย.',
                            'ก.ค.',
                            'ส.ค',
                            'ก.ย.',
                            'ต.ค.',
                            'พ.ย.',
                            'ธ.ค.',
                        ]
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
                        'attribute' => 'riskProName',
                        'label' => 'รหัสความเสี่ยง'
                    ],
                    [
                        'attribute' => 'p1',
                        'label' => 'ม.ค.'
                    ],
                    [
                        'attribute' => 'p2',
                        'label' => 'ก.พ.'
                    ],
                    [
                        'attribute' => 'p3',
                        'label' => 'มี.ค.'
                    ],
                    [
                        'attribute' => 'p4',
                        'label' => 'เม.ย.'
                    ],
                    [
                        'attribute' => 'p5',
                        'label' => 'พ.ค.'
                    ],
                    [
                        'attribute' => 'p6',
                        'label' => 'มิ.ย.'
                    ],[
                        'attribute' => 'p7',
                        'label' => 'ก.ค.'
                    ],
                    [
                        'attribute' => 'p8',
                        'label' => 'ส.ค.'
                    ],
                    [
                        'attribute' => 'p9',
                        'label' => 'ก.ย.'
                    ],
                    [
                        'attribute' => 'p10',
                        'label' => 'ต.ค.'
                    ],
                    [
                        'attribute' => 'p11',
                        'label' => 'พ.ย.'
                    ],
                    [
                        'attribute' => 'p12',
                        'label' => 'ธ.ค.'
                    ],
                ],
            ])
            ?>
            <p>***หมายเหตุ ใบรายงานอุบัติการณ์ที่ยังไม่พิจารณาจะไม่แสดงผลภายในกราฟและตารางสรุปผล</p>
        </div>
    </div>
