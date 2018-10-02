<?php

namespace backend\modules\ir\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;

class ReportController extends \yii\web\Controller {

    public function behaviors() {
        $userrule = [];
        if (Yii::$app->user->identity->role == '2') {
            $userrule = [
                [
                    'actions' => ['login', 'error'],
                    'allow' => true,
                    'roles' => ['?']
                ],
                [
                    'actions' =>['irall','irallp','irallp2','irallp3','irallp4','irallp5',
                                  'report', 'reportnext', 'reportprev', 'reportall',
                                  'riskreport', 'risknext', 'riskprev', 'riskall',
                                  'teamreport', 'teamnext', 'teamprev', 'teamall',
                                  'lvgreport', 'lvgnext', 'lvgprev',
                                  'lvcreport', 'lvcnext', 'lvcprev',
                                  'lvsreport', 'lvsnext', 'lvsprev',
                                ],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' =>['irall','irallp','irallp2','irallp3','irallp4','irallp5',
                                  'report', 'reportnext', 'reportprev', 'reportall',
                                  'riskreport', 'risknext', 'riskprev', 'riskall',
                                  'teamreport', 'teamnext', 'teamprev', 'teamall',
                                  'lvgreport', 'lvgnext', 'lvgprev',
                                  'lvcreport', 'lvcnext', 'lvcprev',
                                  'lvsreport', 'lvsnext', 'lvsprev',
                                ],
                    'allow' => false,
                    'roles' => ['?']
                ],
            ];
        } else {
            $userrule = [
                [
                    'actions' => ['error'],
                    'allow' => true,
                    'roles' => ['?']
                ],
                [
                    'actions' =>['irall','irallp','irallp2','irallp3','irallp4','irallp5',
                                  'report', 'reportnext', 'reportprev', 'reportall',
                                  'riskreport', 'risknext', 'riskprev', 'riskall',
                                  'teamreport', 'teamnext', 'teamprev', 'teamall',
                                  'lvgreport', 'lvgnext', 'lvgprev',
                                  'lvcreport', 'lvcnext', 'lvcprev',
                                  'lvsreport', 'lvsnext', 'lvsprev',
                                ],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ];
        }
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $userrule,
            ],
        ];
    }

    public function actionIrall() {

        $y = date("Y", time());

        $sql = "SELECT i.irID, 
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS ir1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS ir2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS ir3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS ir4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS ir5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS ir6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS ir7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS ir8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS ir9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS ir10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS ir11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS ir12
              
                FROM incidentreport i
                WHERE YEAR(i.created_at)= '" . $y . "' AND i.status = '1'
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => 'รายงานอุบัติการณ์ทั้งหมด',
                'data' => [
                    intval($d['ir1']),
                    intval($d['ir2']),
                    intval($d['ir3']),
                    intval($d['ir4']),
                    intval($d['ir5']),
                    intval($d['ir6']),
                    intval($d['ir7']),
                    intval($d['ir8']),
                    intval($d['ir9']),
                    intval($d['ir10']),
                    intval($d['ir11']),
                    intval($d['ir12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [ 'ir1', 'ir2', 'ir3', 'ir4', 'ir5', 'ir6', 'ir7', 'ir8', 'ir9', 'ir10', 'ir11', 'ir12',]
            ]
        ]);

        return $this->render('irall', [
                    'y' => $y + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIrallp() {

        $y = date("Y", time());
        $y_prev = $y-'1';

        $sql = "SELECT i.irID, 
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS ir1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS ir2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS ir3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS ir4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS ir5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS ir6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS ir7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS ir8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS ir9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS ir10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS ir11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS ir12
              
                FROM incidentreport i
                WHERE YEAR(i.created_at)= '" . $y_prev . "' AND i.status = '1'
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => 'รายงานอุบัติการณ์ทั้งหมด',
                'data' => [
                    intval($d['ir1']),
                    intval($d['ir2']),
                    intval($d['ir3']),
                    intval($d['ir4']),
                    intval($d['ir5']),
                    intval($d['ir6']),
                    intval($d['ir7']),
                    intval($d['ir8']),
                    intval($d['ir9']),
                    intval($d['ir10']),
                    intval($d['ir11']),
                    intval($d['ir12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [ 'ir1', 'ir2', 'ir3', 'ir4', 'ir5', 'ir6', 'ir7', 'ir8', 'ir9', 'ir10', 'ir11', 'ir12',]
            ]
        ]);

        return $this->render('irallp', [
                    'y' => $y_prev + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIrallp2() {

        $y = date("Y", time());
        $y_prev = $y-'2';

        $sql = "SELECT i.irID, 
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS ir1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS ir2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS ir3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS ir4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS ir5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS ir6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS ir7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS ir8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS ir9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS ir10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS ir11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS ir12
              
                FROM incidentreport i
                WHERE YEAR(i.created_at)= '" . $y_prev . "' AND i.status = '1'
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => 'รายงานอุบัติการณ์ทั้งหมด',
                'data' => [
                    intval($d['ir1']),
                    intval($d['ir2']),
                    intval($d['ir3']),
                    intval($d['ir4']),
                    intval($d['ir5']),
                    intval($d['ir6']),
                    intval($d['ir7']),
                    intval($d['ir8']),
                    intval($d['ir9']),
                    intval($d['ir10']),
                    intval($d['ir11']),
                    intval($d['ir12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [ 'ir1', 'ir2', 'ir3', 'ir4', 'ir5', 'ir6', 'ir7', 'ir8', 'ir9', 'ir10', 'ir11', 'ir12',]
            ]
        ]);

        return $this->render('irallp2', [
                    'y' => $y_prev + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
        public function actionIrallp3() {

        $y = date("Y", time());
        $y_prev = $y-'3';

        $sql = "SELECT i.irID, 
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS ir1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS ir2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS ir3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS ir4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS ir5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS ir6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS ir7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS ir8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS ir9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS ir10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS ir11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS ir12
              
                FROM incidentreport i
                WHERE YEAR(i.created_at)= '" . $y_prev . "' AND i.status = '1'
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => 'รายงานอุบัติการณ์ทั้งหมด',
                'data' => [
                    intval($d['ir1']),
                    intval($d['ir2']),
                    intval($d['ir3']),
                    intval($d['ir4']),
                    intval($d['ir5']),
                    intval($d['ir6']),
                    intval($d['ir7']),
                    intval($d['ir8']),
                    intval($d['ir9']),
                    intval($d['ir10']),
                    intval($d['ir11']),
                    intval($d['ir12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [ 'ir1', 'ir2', 'ir3', 'ir4', 'ir5', 'ir6', 'ir7', 'ir8', 'ir9', 'ir10', 'ir11', 'ir12',]
            ]
        ]);

        return $this->render('irallp3', [
                    'y' => $y_prev + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
        public function actionIrallp4() {

        $y = date("Y", time());
        $y_prev = $y-'4';

        $sql = "SELECT i.irID, 
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS ir1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS ir2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS ir3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS ir4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS ir5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS ir6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS ir7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS ir8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS ir9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS ir10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS ir11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS ir12
              
                FROM incidentreport i
                WHERE YEAR(i.created_at)= '" . $y_prev . "' AND i.status = '1'
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => 'รายงานอุบัติการณ์ทั้งหมด',
                'data' => [
                    intval($d['ir1']),
                    intval($d['ir2']),
                    intval($d['ir3']),
                    intval($d['ir4']),
                    intval($d['ir5']),
                    intval($d['ir6']),
                    intval($d['ir7']),
                    intval($d['ir8']),
                    intval($d['ir9']),
                    intval($d['ir10']),
                    intval($d['ir11']),
                    intval($d['ir12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [ 'ir1', 'ir2', 'ir3', 'ir4', 'ir5', 'ir6', 'ir7', 'ir8', 'ir9', 'ir10', 'ir11', 'ir12',]
            ]
        ]);

        return $this->render('irallp4', [
                    'y' => $y_prev + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
        public function actionIrallp5() {

        $y = date("Y", time());
        $y_prev = $y-'5';

        $sql = "SELECT i.irID, 
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS ir1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS ir2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS ir3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS ir4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS ir5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS ir6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS ir7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS ir8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS ir9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS ir10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS ir11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS ir12
              
                FROM incidentreport i
                WHERE YEAR(i.created_at)= '" . $y_prev . "' AND i.status = '1'
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => 'รายงานอุบัติการณ์ทั้งหมด',
                'data' => [
                    intval($d['ir1']),
                    intval($d['ir2']),
                    intval($d['ir3']),
                    intval($d['ir4']),
                    intval($d['ir5']),
                    intval($d['ir6']),
                    intval($d['ir7']),
                    intval($d['ir8']),
                    intval($d['ir9']),
                    intval($d['ir10']),
                    intval($d['ir11']),
                    intval($d['ir12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [ 'ir1', 'ir2', 'ir3', 'ir4', 'ir5', 'ir6', 'ir7', 'ir8', 'ir9', 'ir10', 'ir11', 'ir12',]
            ]
        ]);

        return $this->render('irallp5', [
                    'y' => $y_prev + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    /* รายรายงานอุบัติการณ์แยกตามหน่วยงานที่แจ้ง */
    public function actionReport() {

        $d = date("d", time());
        $y = date("Y", time());
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
        $sql = "SELECT COUNT(t.teamID) AS counter, t.teamName
                FROM incidentreport i
                LEFT JOIN person p ON p.user_id = i.created_by
                LEFT JOIN team t ON t.teamID = p.Team_teamID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY i.created_by
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['teamName'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['teamName', 'counter']
            ]
        ]);

        return $this->render('report', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportprev() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '12';
            $y = $y - '1';
        } elseif ($m_now == '02') {
            $m = '01';
        } elseif ($m_now == '03') {
            $m = '02';
        } elseif ($m_now == '04') {
            $m = '03';
        } elseif ($m_now == '05') {
            $m = '04';
        } elseif ($m_now == '06') {
            $m = '05';
        } elseif ($m_now == '07') {
            $m = '06';
        } elseif ($m_now == '08') {
            $m = '07';
        } elseif ($m_now == '09') {
            $m = '08';
        } elseif ($m_now == '10') {
            $m = '09';
        } elseif ($m_now == '11') {
            $m = '10';
        } else {
            $m = '11';
        }

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
        $sql = "SELECT COUNT(t.teamID) AS counter, t.teamName
                FROM incidentreport i
                LEFT JOIN person p ON p.user_id = i.created_by
                LEFT JOIN team t ON t.teamID = p.Team_teamID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY i.created_by
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['teamName'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['teamName', 'counter']
            ]
        ]);

        return $this->render('reportprev', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y,
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportnext() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '02';
        } elseif ($m_now == '02') {
            $m = '03';
        } elseif ($m_now == '03') {
            $m = '04';
        } elseif ($m_now == '04') {
            $m = '05';
        } elseif ($m_now == '05') {
            $m = '06';
        } elseif ($m_now == '06') {
            $m = '07';
        } elseif ($m_now == '07') {
            $m = '08';
        } elseif ($m_now == '08') {
            $m = '09';
        } elseif ($m_now == '09') {
            $m = '10';
        } elseif ($m_now == '10') {
            $m = '11';
        } elseif ($m_now == '11') {
            $m = '12';
        } else {
            $m = '01';
            $y = $y + '1';
        }

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
        $sql = "SELECT COUNT(t.teamID) AS counter, t.teamName
                FROM incidentreport i
                LEFT JOIN person p ON p.user_id = i.created_by
                LEFT JOIN team t ON t.teamID = p.Team_teamID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY i.created_by
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['teamName'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['teamName', 'counter']
            ]
        ]);

        return $this->render('reportnext', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y,
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportall() {

        $y = date("Y", time());

        $sql = "SELECT t.teamName,
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS i1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS i2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS i3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS i4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS i5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS i6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS i7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS i8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS i9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS i10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS i11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS i12
              
                FROM incidentreport i
                LEFT JOIN person p ON p.user_id = i.created_by
                LEFT JOIN team t ON t.teamID = p.Team_teamID
                WHERE YEAR(i.created_at)= '" . $y . "' AND i.status = '1'
                GROUP BY i.created_by

                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => $d['teamName'],
                'data' => [
                    intval($d['i1']),
                    intval($d['i2']),
                    intval($d['i3']),
                    intval($d['i4']),
                    intval($d['i5']),
                    intval($d['i6']),
                    intval($d['i7']),
                    intval($d['i8']),
                    intval($d['i9']),
                    intval($d['i10']),
                    intval($d['i11']),
                    intval($d['i12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['teamName', 'i1', 'i2', 'i3', 'i4', 'i5', 'i6', 'i7', 'i8', 'i9', 'i10', 'i11', 'i12',]
            ]
        ]);

        return $this->render('reportall', [
                    'y' => $y + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /* รายรายงานอุบัติการณ์แยกตามรหัสความเสี่ยง */

    public function actionRiskreport() {

        $d = date("d", time());
        $y = date("Y", time());
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
        $sql = "SELECT COUNT(p.riskProID) AS counter, p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'counter']
            ]
        ]);

        return $this->render('riskreport', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRiskprev() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '12';
            $y = $y - '1';
        } elseif ($m_now == '02') {
            $m = '01';
        } elseif ($m_now == '03') {
            $m = '02';
        } elseif ($m_now == '04') {
            $m = '03';
        } elseif ($m_now == '05') {
            $m = '04';
        } elseif ($m_now == '06') {
            $m = '05';
        } elseif ($m_now == '07') {
            $m = '06';
        } elseif ($m_now == '08') {
            $m = '07';
        } elseif ($m_now == '09') {
            $m = '08';
        } elseif ($m_now == '10') {
            $m = '09';
        } elseif ($m_now == '11') {
            $m = '10';
        } else {
            $m = '11';
        }

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
        $sql = "SELECT COUNT(p.riskProID) AS counter, p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY rl.riskProID
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'counter']
            ]
        ]);

        return $this->render('riskprev', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y,
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRisknext() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '02';
        } elseif ($m_now == '02') {
            $m = '03';
        } elseif ($m_now == '03') {
            $m = '04';
        } elseif ($m_now == '04') {
            $m = '05';
        } elseif ($m_now == '05') {
            $m = '06';
        } elseif ($m_now == '06') {
            $m = '07';
        } elseif ($m_now == '07') {
            $m = '08';
        } elseif ($m_now == '08') {
            $m = '09';
        } elseif ($m_now == '09') {
            $m = '10';
        } elseif ($m_now == '10') {
            $m = '11';
        } elseif ($m_now == '11') {
            $m = '12';
        } else {
            $m = '01';
            $y = $y + '1';
        }

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
        $sql = "SELECT COUNT(p.riskProID) AS counter, p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY rl.riskProID
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'counter']
            ]
        ]);

        return $this->render('risknext', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y,
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRiskall() {

        $y = date("Y", time());

        $sql = "SELECT p.riskProName,
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS p1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS p2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS p3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS p4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS p5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS p6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS p7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS p8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS p9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS p10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS p11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS p12
              
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE YEAR(i.created_at)= '" . $y . "' AND i.status = '1'
                GROUP BY rl.riskProID

                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => $d['riskProName'],
                'data' => [
                    intval($d['p1']),
                    intval($d['p2']),
                    intval($d['p3']),
                    intval($d['p4']),
                    intval($d['p5']),
                    intval($d['p6']),
                    intval($d['p7']),
                    intval($d['p8']),
                    intval($d['p9']),
                    intval($d['p10']),
                    intval($d['p11']),
                    intval($d['p12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProName', 'p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p7', 'p8', 'p9', 'p10', 'p11', 'p12',]
            ]
        ]);

        return $this->render('riskall', [
                    'y' => $y + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /* รายรายงานอุบัติการณ์แยกตามหน่วยงวนที่เกี่ยวข้อง */

    public function actionTeamreport() {

        $d = date("d", time());
        $y = date("Y", time());
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
        $sql = "SELECT COUNT(t.teamID) AS counter, t.teamName
                FROM incidentreport i
                LEFT JOIN team_list tl ON tl.irID = i.irID
                LEFT JOIN team t ON t.teamID = tl.teamID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY tl.teamID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['teamName'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['teamName', 'counter']
            ]
        ]);

        return $this->render('teamreport', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeamprev() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '12';
            $y = $y - '1';
        } elseif ($m_now == '02') {
            $m = '01';
        } elseif ($m_now == '03') {
            $m = '02';
        } elseif ($m_now == '04') {
            $m = '03';
        } elseif ($m_now == '05') {
            $m = '04';
        } elseif ($m_now == '06') {
            $m = '05';
        } elseif ($m_now == '07') {
            $m = '06';
        } elseif ($m_now == '08') {
            $m = '07';
        } elseif ($m_now == '09') {
            $m = '08';
        } elseif ($m_now == '10') {
            $m = '09';
        } elseif ($m_now == '11') {
            $m = '10';
        } else {
            $m = '11';
        }

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
        $sql = "SELECT COUNT(t.teamID) AS counter, t.teamName
                FROM incidentreport i
                LEFT JOIN team_list tl ON tl.irID = i.irID
                LEFT JOIN team t ON t.teamID = tl.teamID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY tl.teamID
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['t.teamName'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['t.teamName', 'counter']
            ]
        ]);

        return $this->render('teamprev', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y,
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeamnext() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '02';
        } elseif ($m_now == '02') {
            $m = '03';
        } elseif ($m_now == '03') {
            $m = '04';
        } elseif ($m_now == '04') {
            $m = '05';
        } elseif ($m_now == '05') {
            $m = '06';
        } elseif ($m_now == '06') {
            $m = '07';
        } elseif ($m_now == '07') {
            $m = '08';
        } elseif ($m_now == '08') {
            $m = '09';
        } elseif ($m_now == '09') {
            $m = '10';
        } elseif ($m_now == '10') {
            $m = '11';
        } elseif ($m_now == '11') {
            $m = '12';
        } else {
            $m = '01';
            $y = $y + '1';
        }

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
        $sql = "SELECT COUNT(t.teamID) AS counter, t.teamName
                FROM incidentreport i
                LEFT JOIN team_list tl ON tl.irID = i.irID
                LEFT JOIN team t ON t.teamID = tl.teamID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1'
                GROUP BY tl.teamID
                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['t.teamName'],
                'data' => [intval($d['counter'])]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['t.teamName', 'counter']
            ]
        ]);

        return $this->render('teamnext', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y,
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeamall() {

        $y = date("Y", time());

        $sql = "SELECT t.teamName,
                COUNT(IF(MONTH(i.created_at) = 1,i.irID,NULL)) AS t1,
                COUNT(IF(MONTH(i.created_at) = 2,i.irID,NULL)) AS t2,
                COUNT(IF(MONTH(i.created_at) = 3,i.irID,NULL)) AS t3,
                COUNT(IF(MONTH(i.created_at) = 4,i.irID,NULL)) AS t4,
                COUNT(IF(MONTH(i.created_at) = 5,i.irID,NULL)) AS t5,
                COUNT(IF(MONTH(i.created_at) = 6,i.irID,NULL)) AS t6,
                COUNT(IF(MONTH(i.created_at) = 7,i.irID,NULL)) AS t7,
                COUNT(IF(MONTH(i.created_at) = 8,i.irID,NULL)) AS t8,
                COUNT(IF(MONTH(i.created_at) = 9,i.irID,NULL)) AS t9,
                COUNT(IF(MONTH(i.created_at) = 10,i.irID,NULL)) AS t10,
                COUNT(IF(MONTH(i.created_at) = 11,i.irID,NULL)) AS t11,
                COUNT(IF(MONTH(i.created_at) = 12,i.irID,NULL)) AS t12
              
                FROM incidentreport i
                LEFT JOIN team_list tl ON tl.irID = i.irID
                LEFT JOIN team t ON t.teamID = tl.teamID
                WHERE YEAR(i.created_at)= '" . $y . "' AND i.status = '1'
                GROUP BY tl.teamID

                ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'line',
                'name' => $d['teamName'],
                'data' => [
                    intval($d['t1']),
                    intval($d['t2']),
                    intval($d['t3']),
                    intval($d['t4']),
                    intval($d['t5']),
                    intval($d['t6']),
                    intval($d['t7']),
                    intval($d['t8']),
                    intval($d['t9']),
                    intval($d['t10']),
                    intval($d['t11']),
                    intval($d['t12']),
                ]
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['teamName', 't1', 't2', 't3', 't4', 't5', 't6', 't7', 't8', 't9', 't10', 't11', 't12',]
            ]
        ]);

        return $this->render('teamall', [
                    'y' => $y + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
    /* รายงานอุบัติการณ์ประเภทความเสี่ยงทั่วไป แยกตามระดับความรุนแรง */

public function actionLvgreport() {

        $d = date("d", time());
        $y = date("Y", time());
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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgreport', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLvgprev() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '12';
            $y = $y - '1';
        } elseif ($m_now == '02') {
            $m = '01';
        } elseif ($m_now == '03') {
            $m = '02';
        } elseif ($m_now == '04') {
            $m = '03';
        } elseif ($m_now == '05') {
            $m = '04';
        } elseif ($m_now == '06') {
            $m = '05';
        } elseif ($m_now == '07') {
            $m = '06';
        } elseif ($m_now == '08') {
            $m = '07';
        } elseif ($m_now == '09') {
            $m = '08';
        } elseif ($m_now == '10') {
            $m = '09';
        } elseif ($m_now == '11') {
            $m = '10';
        } else {
            $m = '11';
        }

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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgprev', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLvgnext() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '02';
        } elseif ($m_now == '02') {
            $m = '03';
        } elseif ($m_now == '03') {
            $m = '04';
        } elseif ($m_now == '04') {
            $m = '05';
        } elseif ($m_now == '05') {
            $m = '06';
        } elseif ($m_now == '06') {
            $m = '07';
        } elseif ($m_now == '07') {
            $m = '08';
        } elseif ($m_now == '08') {
            $m = '09';
        } elseif ($m_now == '09') {
            $m = '10';
        } elseif ($m_now == '10') {
            $m = '11';
        } elseif ($m_now == '11') {
            $m = '12';
        } else {
            $m = '01';
            $y = $y + '1';
        }

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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgnext', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
/* รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกทั่วไป แยกตามระดับความรุนแรง */
    
public function actionLvcreport() {

        $d = date("d", time());
        $y = date("Y", time());
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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcreport', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLvcprev() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '12';
            $y = $y - '1';
        } elseif ($m_now == '02') {
            $m = '01';
        } elseif ($m_now == '03') {
            $m = '02';
        } elseif ($m_now == '04') {
            $m = '03';
        } elseif ($m_now == '05') {
            $m = '04';
        } elseif ($m_now == '06') {
            $m = '05';
        } elseif ($m_now == '07') {
            $m = '06';
        } elseif ($m_now == '08') {
            $m = '07';
        } elseif ($m_now == '09') {
            $m = '08';
        } elseif ($m_now == '10') {
            $m = '09';
        } elseif ($m_now == '11') {
            $m = '10';
        } else {
            $m = '11';
        }

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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcprev', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLvcnext() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '02';
        } elseif ($m_now == '02') {
            $m = '03';
        } elseif ($m_now == '03') {
            $m = '04';
        } elseif ($m_now == '04') {
            $m = '05';
        } elseif ($m_now == '05') {
            $m = '06';
        } elseif ($m_now == '06') {
            $m = '07';
        } elseif ($m_now == '07') {
            $m = '08';
        } elseif ($m_now == '08') {
            $m = '09';
        } elseif ($m_now == '09') {
            $m = '10';
        } elseif ($m_now == '10') {
            $m = '11';
        } elseif ($m_now == '11') {
            $m = '12';
        } else {
            $m = '01';
            $y = $y + '1';
        }

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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcnext', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
/* รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกเฉพาะโรค แยกตามระดับความรุนแรง */
    
public function actionLvsreport() {

        $d = date("d", time());
        $y = date("Y", time());
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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsreport', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLvsprev() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '12';
            $y = $y - '1';
        } elseif ($m_now == '02') {
            $m = '01';
        } elseif ($m_now == '03') {
            $m = '02';
        } elseif ($m_now == '04') {
            $m = '03';
        } elseif ($m_now == '05') {
            $m = '04';
        } elseif ($m_now == '06') {
            $m = '05';
        } elseif ($m_now == '07') {
            $m = '06';
        } elseif ($m_now == '08') {
            $m = '07';
        } elseif ($m_now == '09') {
            $m = '08';
        } elseif ($m_now == '10') {
            $m = '09';
        } elseif ($m_now == '11') {
            $m = '10';
        } else {
            $m = '11';
        }

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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsprev', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLvsnext() {

        $d = date("d", time());
        $y = date("Y", time());
        $m_now = date("m", time());
        if ($m_now == '01') {
            $m = '02';
        } elseif ($m_now == '02') {
            $m = '03';
        } elseif ($m_now == '03') {
            $m = '04';
        } elseif ($m_now == '04') {
            $m = '05';
        } elseif ($m_now == '05') {
            $m = '06';
        } elseif ($m_now == '06') {
            $m = '07';
        } elseif ($m_now == '07') {
            $m = '08';
        } elseif ($m_now == '08') {
            $m = '09';
        } elseif ($m_now == '09') {
            $m = '10';
        } elseif ($m_now == '10') {
            $m = '11';
        } elseif ($m_now == '11') {
            $m = '12';
        } else {
            $m = '01';
            $y = $y + '1';
        }

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
        $sql = "SELECT 
                COUNT(i.levelID) = 1 AS lv1,
                COUNT(i.levelID) = 2 AS lv2,
                COUNT(i.levelID) = 3 AS lv3,
                COUNT(i.levelID) = 4 AS lv4,
                COUNT(i.levelID) = 5 AS lv5,
                COUNT(i.levelID) = 6 AS lv6,
                COUNT(i.levelID) = 7 AS lv7,
                COUNT(i.levelID) = 8 AS lv8,
                COUNT(i.levelID) = 9 AS lv9,
                p.riskProname
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE MONTH(i.created_at)= '" . $m . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $graph = [];
        foreach ($data as $d) {
            $graph[] = [
                'type' => 'column',
                'name' => $d['riskProname'],
                'data' => [
                    intval($d['lv1']),
                    intval($d['lv2']),
                    intval($d['lv3']),
                    intval($d['lv4']),
                    intval($d['lv5']),
                    intval($d['lv6']),
                    intval($d['lv7']),
                    intval($d['lv8']),
                    intval($d['lv9'])],
            ];
        }

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsnext', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'month' => $trans_m,
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }    
}
