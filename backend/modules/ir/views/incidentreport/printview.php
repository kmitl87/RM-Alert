<?php

use yii\helpers\Html;

$ir = $model->irID;
$l = $model->level->levelName;
$d = $model->detail;

$m = date("m", time());
if ($m == '01') {
    $trans_m = 'มกราคม';
} elseif ($m == '02') {
    $trans_m = 'กุมภาพันธ์';
} elseif ($m == '03') {
    $trans_m = 'มีนาคม';
} elseif ($m == '04') {
    $trans_m = 'เมษายน';
} elseif ($m == '05') {
    $trans_m = 'พฤษภาคม';
} elseif ($m == '06') {
    $trans_m = 'มิถุนายน';
} elseif ($m == '07') {
    $trans_m = 'กรกฎาคม';
} elseif ($m == '08') {
    $trans_m = 'สิงหาคม';
} elseif ($m == '09') {
    $trans_m = 'กันยายน';
} elseif ($m == '10') {
    $trans_m = 'ตุลาคม';
} elseif ($m == '11') {
    $trans_m = 'พฤศจิกายน';
} else {
    $trans_m = 'ธันวาคม';
}
?>
<table class="table_bordered" width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
        <td style="width: 424px; border-color: #000000;">
            <p style="text-align: center;"> <span style="font-size: 14pt;"><strong>แบบติดตามการดำเนินการบริการความเสี่ยง</strong></span></p>
            <p style="text-align: center;"><span style="font-size: 14pt;"><strong>(RISK PREVENTIVE REQUEST)</strong></span></p>
        </td>
        <td style="width: 424px; border-color: #000000; text-align: left;">
            <p><span style="font-size: 14pt;"><strong>กรุณาส่งกลับ ศูนย์พัฒนาคุณภาพ</strong></span></p>
            <p><span style="font-size: 14pt;"><strong>ในวันที่</strong></span></p>
        </td>
    </tr>
</table>

<table class="table_bordered" width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
        <td style="width: 854px; border-color: #000000;" colspan="2">
            <p><strong> ส่วนที่ 1 เรียน</strong> ประธานคณะกรรมการ</p>
            &emsp;&emsp;&emsp;&emsp;<strong>ทีม/หน่วยงาน</strong>
            <?php
            $sql_team = "SELECT t.teamName
            
                FROM incidentreport i
                LEFT JOIN team_list tl ON tl.irID = i.irID
                LEFT JOIN team t ON t.teamID = tl.teamID
                WHERE tl.irID = '" . $ir . "'

                ";
            $data_team = Yii::$app->db->createCommand($sql_team)->queryAll();
            $j = 1;
            foreach ($data_team as $item2 => $val2) { //item is key           
                echo $val2['teamName'];
                echo " / ";
            }
            ?>

            <p> </p>
            &emsp;&emsp;&emsp;&emsp;จากรายงานอุบัติการณ์เลขที่<strong><?= Html::encode(' ' . $ir) ?></strong> ประจำเดือน<strong><?= Html::encode(' ' . $trans_m) ?></strong> ระดับ<strong><?= Html::encode(' ' . $l) ?></strong> รหัสบัญชี 
            <strong><?php
                $sql_risk = "SELECT rl.riskProID
            
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE rl.irID = '" . $ir . "'
                
                ";
                $data_risk = Yii::$app->db->createCommand($sql_risk)->queryAll();
                $i = 1;
                foreach ($data_risk as $item => $val) { //item is key
                    echo $val['riskProID'];
                    echo " / ";
                    $i++;
                }
                ?></strong>
            <p> </p>
            &emsp;&emsp;โดยอุบัติการณ์ที่เกิดขึ้นนี้ มีส่วนเกี่ยวข้องกับหน่วยงานของท่าน ดังนั้นคณะกรรมการบริหารความเสี่ยงโรงพยาบาลเวชการุณรัศมิ์ จึงขอให้หน่วยงานของท่านดำเนินการแก้ไขและป้องกันอย่างเป็นระบบ
            <p> </p>
            &emsp;&emsp;&emsp;&emsp;<strong>รายละเอียดเหตุการณ์</strong>
            <p> </p>
            &emsp;&emsp;&emsp;&emsp;<?= Html::encode(' ' . $d) ?>
            <br/>
            <br/>
            <br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;ลงชื่อ...................................................................คณะกรรมการบริหารความเสี่ยง
            <p>                  </p>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;วันที่............/............/............
        </td>
    </tr>
</table>

<table class="table_bordered" width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
        <td style="width: 854px; border-color: #000000;" colspan="2">
            <p> <strong>ส่วนที่ 2 สาเหตุของอุบัติการณ์ </strong>(หากเนื้อที่ไม่พอทำเป็นเอกสารแนบ)<strong><br /></strong></p>
            &emsp;&emsp;&emsp;&emsp;สาเหตุ............................................................................................................................................................................................................................................................................................................................................................................................................................
            &emsp;&emsp;&emsp;&emsp;มาตราการณ์ป้องกันการเกิดอุบัติการณ์........................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................
            &emsp;&emsp;&emsp;&emsp;กำหนดการแล้วเสร็จ.........................................
            <p> </p>
            <p> </p>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;ลงชื่อ...................................................................ผู้บังคับบัญชาของหน่วยงาน
            <p>                  </p>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;วันที่............/............/............
        </td>
    </tr>
</table>

<table class="table_bordered" width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
        <td style="width: 854px; border-color: #000000;" colspan="2">
            <p>  <strong>ส่วนที่ 3 ผลการติดตามการบริหารความเสี่ยง</strong></p>
            &emsp;&emsp;&emsp;&emsp;...............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;ลงชื่อ...................................................................กรรมการบริหารความเสี่ยง(ผู้ติดตาม)
            <p>                  </p>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;วันที่............/............/............

        </td>
    </tr>
</table>

<table class="table_bordered" width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
        <td style="width: 854px; border-color: #000000;" colspan="2">
            <p>  <strong>ส่วนที่ 4 สรุปการบริหารความเสี่ยง<br /></strong></p>
            &emsp;&emsp;&emsp;&emsp;...............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;ลงชื่อ...................................................................ประธานกรรมการบริหารความเสี่ยง
            <p>                  </p>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;วันที่............/............/............
        </td>
    </tr>
</tbody>
</table>
<p> </p>