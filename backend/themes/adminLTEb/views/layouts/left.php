<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<aside class="main-sidebar">

    <section class="sidebar">
        <?php if(Yii::$app->user->identity->role == '0'): ?>
        <?= dmstr\widgets\Menu::widget 
        (      
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                 
                'items' => [
                    
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'หน้าหลัก', 'icon' => 'home', 'url' => ['/']],
                    ['label' => 'เขียนใบรายงานอุบัติการณ์', 'icon' => 'file-text-o', 'url' => ['/ir/incidentreport/create']],
                    ['label' => 'รายงานอุบัติการณ์ของหน่วยงาน', 'icon' => 'calendar', 'url' => ['/ir/incidentreport/userindex']],
                    ['label' => 'รายงานอุบัติการณ์ทั้งหมด', 'icon' => 'calendar-check-o', 'url' => ['/ir/incidentreport/index']],
                    [
                        'label' => 'สรุปรายงานสถิติต่างๆ',
                        'icon' => 'bar-chart',
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'จำนวนรายงานอุบัติการณ์ในแต่ละเดือน', 'icon' => 'check-circle', 'url' =>['/ir/report/irall']],
                            ['label' => 'รายงานอุบัติการณ์แยกตามหน่วยงานที่แจ้ง', 'icon' => 'check-circle', 'url' =>['/ir/report/reportall']],
                            ['label' => 'รายงานอุบัติการณ์แยกตามรหัสความเสี่ยง', 'icon' => 'check-circle', 'url' =>['/ir/report/riskall']], 
                            ['label' => 'รายงานอุบัติการณ์แยกตามหน่วยงานที่เกี่ยวข้อง', 'icon' => 'check-circle', 'url' =>['/ir/report/teamall']],
                            ['label' => 'รายงานอุบัติการณ์ประเภทความเสี่ยงทั่วไป แยกตามระดับความรุนแรง', 'icon' => 'check-circle', 'url' =>['/ir/report/lvgreportall']],
                            ['label' => 'รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกทั่วไป แยกตามระดับความรุนแรง', 'icon' => 'check-circle', 'url' =>['/ir/report/lvcreportall']],
                            ['label' => 'รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกเฉพาะโรค แยกตามระดับความรุนแรง', 'icon' => 'check-circle', 'url' =>['/ir/report/lvsreportall']],  
                        ],
                    ],
                    ['label' => 'จัดการบัญชีผู้ใช้', 'icon' => 'user', 'url' => ['/personal/person']],
                    //['label' => 'ออกจากระบบ ('.Yii::$app->user->identity->username. ')', 'icon' => 'sign-out', 'url' => ['/site/logout'],'linkOptions'=>['data-mathod'=>'POST']],

                ], 
            ]
        ) ?>
        <?php endif; ?>
    </section>
    <section class="sidebar">
        <?php if(Yii::$app->user->identity->role == '1'): ?>
        <?= dmstr\widgets\Menu::widget 
        (      
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                 
                'items' => [
                    
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'หน้าหลัก', 'icon' => 'home', 'url' => ['/']],
                    ['label' => 'เขียนใบรายงานอุบัติการณ์', 'icon' => 'file-text-o', 'url' => ['/ir/incidentreport/create']],
                    ['label' => 'รายงานอุบัติการณ์ของหน่วยงาน', 'icon' => 'calendar', 'url' => ['/ir/incidentreport/userindex']],
                    ['label' => 'รายงานอุบัติการณ์ทั้งหมด', 'icon' => 'calendar-check-o', 'url' => ['/ir/incidentreport/index']],
                    [
                        'label' => 'สรุปรายงานสถิติต่างๆ',
                        'icon' => 'bar-chart',
                        'url' => ['/ir/report/_menu'],
                        'items' => [
                            ['label' => 'จำนวนรายงานอุบัติการณ์ในแต่ละเดือน', 'icon' => 'check-circle', 'url' =>['/ir/report/irall']],
                            ['label' => 'รายงานอุบัติการณ์แยกตามหน่วยงานที่แจ้ง', 'icon' => 'check-circle', 'url' =>['/ir/report/reportall']],
                            ['label' => 'รายงานอุบัติการณ์แยกตามรหัสความเสี่ยง', 'icon' => 'check-circle', 'url' =>['/ir/report/riskall']], 
                            ['label' => 'รายงานอุบัติการณ์แยกตามหน่วยงานที่เกี่ยวข้อง', 'icon' => 'check-circle', 'url' =>['/ir/report/teamall']],
                            ['label' => 'รายงานอุบัติการณ์ประเภทความเสี่ยงทั่วไป แยกตามระดับความรุนแรง', 'icon' => 'check-circle', 'url' =>['/ir/report/lvgreportall']],
                            ['label' => 'รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกทั่วไป แยกตามระดับความรุนแรง', 'icon' => 'check-circle', 'url' =>['/ir/report/lvcreportall']],
                            ['label' => 'รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกเฉพาะโรค แยกตามระดับความรุนแรง', 'icon' => 'check-circle', 'url' =>['/ir/report/lvsreportall']],  
                        ],
                    ],
                    //['label' => 'ออกจากระบบ ('.Yii::$app->user->identity->username. ')', 'icon' => 'sign-out', 'url' => ['/site/logout'],'linkOptions'=>['data-mathod'=>'post']],

                ], 
            ]
        ) ?>
        <?php endif; ?>
    </section>
    <section class="sidebar">
        <?php if(Yii::$app->user->identity->role == '2'): ?>
        <?= dmstr\widgets\Menu::widget 
        (      
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                 
                'items' => [
                    
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'หน้าหลัก', 'icon' => 'home', 'url' => ['/']],
                    ['label' => 'เขียนใบรายงานอุบัติการณ์', 'icon' => 'file-text-o', 'url' => ['/ir/incidentreport/create']],
                    ['label' => 'รายงานอุบัติการณ์ของหน่วยงาน', 'icon' => 'calendar', 'url' => ['/ir/incidentreport/userindex']],
                    //['label' => 'ออกจากระบบ ('.Yii::$app->user->identity->username. ')', 'icon' => 'sign-out', 'url' => ['/site/logout'],'linkOptions'=>['data-mathod'=>'post']],

                ], 
            ]
        ) ?>
        <?php endif; ?>
    </section>
</aside>
