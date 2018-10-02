<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'รายงานอุบัติการณ์แยกตามหน่วยงานที่เกี่ยวข้องในปี พ.ศ.'.$y;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('ปีก่อนหน้า', ['teamallp4'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('ปีถัดไป', ['teamallp2'], ['class' => 'btn btn-default'])?>
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
                        'attribute' => 'teamName',
                        'label' => 'หน่วยงานที่เกี่ยวข้อง'
                    ],
                    [
                        'attribute' => 't1',
                        'label' => 'ม.ค.'
                    ],
                    [
                        'attribute' => 't2',
                        'label' => 'ก.พ.'
                    ],
                    [
                        'attribute' => 't3',
                        'label' => 'มี.ค.'
                    ],
                    [
                        'attribute' => 't4',
                        'label' => 'เม.ย.'
                    ],
                    [
                        'attribute' => 't5',
                        'label' => 'พ.ค.'
                    ],
                    [
                        'attribute' => 't6',
                        'label' => 'มิ.ย.'
                    ],[
                        'attribute' => 't7',
                        'label' => 'ก.ค.'
                    ],
                    [
                        'attribute' => 't8',
                        'label' => 'ส.ค.'
                    ],
                    [
                        'attribute' => 't9',
                        'label' => 'ก.ย.'
                    ],
                    [
                        'attribute' => 't10',
                        'label' => 'ต.ค.'
                    ],
                    [
                        'attribute' => 't11',
                        'label' => 'พ.ย.'
                    ],
                    [
                        'attribute' => 't12',
                        'label' => 'ธ.ค.'
                    ],
                ],
            ])
            ?>
            <p>***หมายเหตุ ใบรายงานอุบัติการณ์ที่ยังไม่พิจารณาจะไม่แสดงผลภายในกราฟและตารางสรุปผล</p>
        </div>
    </div>
