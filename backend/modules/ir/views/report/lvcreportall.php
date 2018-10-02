<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

$this->title = 'รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกทั่วไป แยกตามระดับความรุนแรง ปี ' . $y;
?>

<div class="incidentreport-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('ปีก่อนหน้า', ['lvcreportall2'], ['class' => 'btn btn-default']) ?>

            </p>
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>มกราคม</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>กุมภาพันธ์</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider2,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>มีนาคม</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider3,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>เมษายน</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider4,
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
                    ], [
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

            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>พฤษภาคม</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider5,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>มิถุนายน</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider6,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>กรกฎาคม</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider7,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>สิงหาคม</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider8,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>กันยายน</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider9,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>ตุลาคม</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider10,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>พฤศจิกายน</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider11,
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
                    ], [
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
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><h2><span style="color:#d35400"><strong>ธันวาคม</strong></span></h2></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider12,
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
                    ], [
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
