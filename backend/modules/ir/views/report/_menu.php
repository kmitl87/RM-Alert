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
       <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-green">
        <span class="info-box-icon"><i class="fa fa-print"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Report</span>
            <a class="info-box-link" href="<?php echo $url; ?>"><span class="info-box-number"><?php echo $label; ?></span></a>
            <div class="progress" style="margin-top: 10px;">
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>
</div>
