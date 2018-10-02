<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกเฉพาะโรค แยกตามระดับความรุนแรง เดือน'.$month;

?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('เดือนก่อนหน้า', ['lvsprev'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('สรุปยอดปี '.$y, ['lvsreportall'], ['class' => 'btn btn-info'])?>
            </p>

            <?=
            Highcharts::widget([
                'options' => [
                    'title' => ['text' => 'สรุปการรายงานอุบัติการณ์'],
                    'xAxis' => [
                        'categories' => [
                            'A',
                            'B',
                            'C',
                            'D',
                            'E',
                            'F',
                            'G',
                            'H',
                            'I'
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
                        'attribute' => 'riskProname',
                        'label' => 'รหัสความเสี่ยง'
                    ],
                    [
                        'attribute' => 'lv1',
                        'label' => 'A'
                    ],
                    [
                        'attribute' => 'lv2',
                        'label' => 'B'
                    ],
                    [
                        'attribute' => 'lv3',
                        'label' => 'C'
                    ],
                    [
                        'attribute' => 'lv4',
                        'label' => 'D'
                    ],
                    [
                        'attribute' => 'lv5',
                        'label' => 'E'
                    ],
                    [
                        'attribute' => 'lv6',
                        'label' => 'F'
                    ],[
                        'attribute' => 'lv7',
                        'label' => 'G'
                    ],
                    [
                        'attribute' => 'lv8',
                        'label' => 'H'
                    ],
                    [
                        'attribute' => 'lv9',
                        'label' => 'I'
                    ],
                ],
            ])
            ?>
            <p>***หมายเหตุ ใบรายงานอุบัติการณ์ที่ยังไม่พิจารณาจะไม่แสดงผลภายในกราฟและตารางสรุปผล</p>
        </div>
    </div>
