<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'จำนวนรายงานอุบัติการณ์ทั้งหมดในปี พ.ศ.'.$y;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('ปีก่อนหน้า', ['irallp'], ['class' => 'btn btn-default']) ?>
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
                        'attribute' => 'ir1',
                        'label' => 'ม.ค.'
                    ],
                    [
                        'attribute' => 'ir2',
                        'label' => 'ก.พ.'
                    ],
                    [
                        'attribute' => 'ir3',
                        'label' => 'มี.ค.'
                    ],
                    [
                        'attribute' => 'ir4',
                        'label' => 'เม.ย.'
                    ],
                    [
                        'attribute' => 'ir5',
                        'label' => 'พ.ค.'
                    ],
                    [
                        'attribute' => 'ir6',
                        'label' => 'มิ.ย.'
                    ],[
                        'attribute' => 'ir7',
                        'label' => 'ก.ค.'
                    ],
                    [
                        'attribute' => 'ir8',
                        'label' => 'ส.ค.'
                    ],
                    [
                        'attribute' => 'ir9',
                        'label' => 'ก.ย.'
                    ],
                    [
                        'attribute' => 'ir10',
                        'label' => 'ต.ค.'
                    ],
                    [
                        'attribute' => 'ir11',
                        'label' => 'พ.ย.'
                    ],
                    [
                        'attribute' => 'ir12',
                        'label' => 'ธ.ค.'
                    ],
                ],
            ])
            ?>
            <p>***หมายเหตุ ใบรายงานอุบัติการณ์ที่ยังไม่พิจารณาจะไม่แสดงผลภายในกราฟและตารางสรุปผล</p>
        </div>
    </div>
