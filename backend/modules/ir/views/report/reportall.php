<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'รายงานอุบัติการณ์แยกตามหน่วยงานที่แจ้งในปี พ.ศ.'.$y;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('ปีก่อนหน้า', ['reportallp'], ['class' => 'btn btn-default']) ?>
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
                        'attribute' => 'i1',
                        'label' => 'ม.ค.'
                    ],
                    [
                        'attribute' => 'i2',
                        'label' => 'ก.พ.'
                    ],
                    [
                        'attribute' => 'i3',
                        'label' => 'มี.ค.'
                    ],
                    [
                        'attribute' => 'i4',
                        'label' => 'เม.ย.'
                    ],
                    [
                        'attribute' => 'i5',
                        'label' => 'พ.ค.'
                    ],
                    [
                        'attribute' => 'i6',
                        'label' => 'มิ.ย.'
                    ],[
                        'attribute' => 'i7',
                        'label' => 'ก.ค.'
                    ],
                    [
                        'attribute' => 'i8',
                        'label' => 'ส.ค.'
                    ],
                    [
                        'attribute' => 'i9',
                        'label' => 'ก.ย.'
                    ],
                    [
                        'attribute' => 'i10',
                        'label' => 'ต.ค.'
                    ],
                    [
                        'attribute' => 'i11',
                        'label' => 'พ.ย.'
                    ],
                    [
                        'attribute' => 'i12',
                        'label' => 'ธ.ค.'
                    ],
                ],
            ])
            ?>
            <p>***หมายเหตุ ใบรายงานอุบัติการณ์ที่ยังไม่พิจารณาจะไม่แสดงผลภายในกราฟและตารางสรุปผล</p>
        </div>
    </div>
