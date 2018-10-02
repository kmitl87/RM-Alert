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
                    'actions' => ['irall', 'irallp', 'irallp2', 'irallp3', 'irallp4', 'irallp5',
                        'reportall', 'reportallp', 'reportallp2', 'reportallp3', 'reportallp4', 'reportallp5',
                        'riskall', 'riskallp', 'riskallp2', 'riskallp3', 'riskallp4', 'riskallp5',
                        'teamall', 'teamallp', 'teamallp2', 'teamallp3', 'teamallp4', 'teamallp5',
                        'lvgreportall', 'lvgreportall2', 'lvgreportall3', 'lvgreportall4', 'lvgreportall5', 'lvgreportall6',
                        'lvcreportall', 'lvcreportall2', 'lvcreportall3', 'lvcreportall4', 'lvcreportall5', 'lvcreportall6',
                        'lvsreportall', 'lvsreportall2', 'lvsreportall3', 'lvsreportall4', 'lvsreportall5', 'lvsreportall6',
                    ],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['irall', 'irallp', 'irallp2', 'irallp3', 'irallp4', 'irallp5',
                        'reportall', 'reportallp', 'reportallp2', 'reportallp3', 'reportallp4', 'reportallp5',
                        'riskall', 'riskallp', 'riskallp2', 'riskallp3', 'riskallp4', 'riskallp5',
                        'teamall', 'teamallp', 'teamallp2', 'teamallp3', 'teamallp4', 'teamallp5',
                        'lvgreportall', 'lvgreportall2', 'lvgreportall3', 'lvgreportall4', 'lvgreportall5', 'lvgreportall6',
                        'lvcreportall', 'lvcreportall2', 'lvcreportall3', 'lvcreportall4', 'lvcreportall5', 'lvcreportall6',
                        'lvsreportall', 'lvsreportall2', 'lvsreportall3', 'lvsreportall4', 'lvsreportall5', 'lvsreportall6',
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
                    'actions' => ['irall', 'irallp', 'irallp2', 'irallp3', 'irallp4', 'irallp5',
                        'reportall', 'reportallp', 'reportallp2', 'reportallp3', 'reportallp4', 'reportallp5',
                        'riskall', 'riskallp', 'riskallp2', 'riskallp3', 'riskallp4', 'riskallp5',
                        'teamall', 'teamallp', 'teamallp2', 'teamallp3', 'teamallp4', 'teamallp5',
                        'lvgreportall', 'lvgreportall2', 'lvgreportall3', 'lvgreportall4', 'lvgreportall5', 'lvgreportall6',
                        'lvcreportall', 'lvcreportall2', 'lvcreportall3', 'lvcreportall4', 'lvcreportall5', 'lvcreportall6',
                        'lvsreportall', 'lvsreportall2', 'lvsreportall3', 'lvsreportall4', 'lvsreportall5', 'lvsreportall6',
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
        $y_prev = $y - '1';

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
        $y_prev = $y - '2';

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
        $y_prev = $y - '3';

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
        $y_prev = $y - '4';

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
        $y_prev = $y - '5';

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

    public function actionReportallp() {

        $y = date("Y", time());
        $y_pre = $y - '1';

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
                WHERE YEAR(i.created_at)= '" . $y_pre . "' AND i.status = '1'
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

        return $this->render('reportallp', [
                    'y' => $y_pre + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportallp2() {

        $y = date("Y", time());
        $y_pre = $y - '2';

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
                WHERE YEAR(i.created_at)= '" . $y_pre . "' AND i.status = '1'
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

        return $this->render('reportallp2', [
                    'y' => $y_pre + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportallp3() {

        $y = date("Y", time());
        $y_pre = $y - '3';

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
                WHERE YEAR(i.created_at)= '" . $y_pre . "' AND i.status = '1'
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

        return $this->render('reportallp3', [
                    'y' => $y_pre + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportallp4() {

        $y = date("Y", time());
        $y_pre = $y - '4';

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
                WHERE YEAR(i.created_at)= '" . $y_pre . "' AND i.status = '1'
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

        return $this->render('reportallp4', [
                    'y' => $y_pre + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportallp5() {

        $y = date("Y", time());
        $y_pre = $y - '5';

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
                WHERE YEAR(i.created_at)= '" . $y_pre . "' AND i.status = '1'
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

        return $this->render('reportallp5', [
                    'y' => $y_pre + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /* รายรายงานอุบัติการณ์แยกตามรหัสความเสี่ยง */

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

    public function actionRiskallp() {

        $y = date("Y", time());
        $y_pr = $y - '1';

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
                WHERE YEAR(i.created_at)= '" . $y_pr . "' AND i.status = '1'
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

        return $this->render('riskallp', [
                    'y' => $y_pr + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRiskallp2() {

        $y = date("Y", time());
        $y_pr = $y - '2';

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
                WHERE YEAR(i.created_at)= '" . $y_pr . "' AND i.status = '1'
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

        return $this->render('riskallp2', [
                    'y' => $y_pr + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRiskallp3() {

        $y = date("Y", time());
        $y_pr = $y - '3';

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
                WHERE YEAR(i.created_at)= '" . $y_pr . "' AND i.status = '1'
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

        return $this->render('riskallp3', [
                    'y' => $y_pr + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRiskallp4() {

        $y = date("Y", time());
        $y_pr = $y - '4';

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
                WHERE YEAR(i.created_at)= '" . $y_pr . "' AND i.status = '1'
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

        return $this->render('riskallp4', [
                    'y' => $y_pr + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRiskallp5() {

        $y = date("Y", time());
        $y_pr = $y - '5';

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
                WHERE YEAR(i.created_at)= '" . $y_pr . "' AND i.status = '1'
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

        return $this->render('riskallp5', [
                    'y' => $y_pr + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /* รายรายงานอุบัติการณ์แยกตามหน่วยงวนที่เกี่ยวข้อง */

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

    public function actionTeamallp() {

        $y = date("Y", time());
        $y_p = $y - '1';

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
                WHERE YEAR(i.created_at)= '" . $y_p . "' AND i.status = '1'
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

        return $this->render('teamallp', [
                    'y' => $y_p + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeamallp2() {

        $y = date("Y", time());
        $y_p = $y - '2';

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
                WHERE YEAR(i.created_at)= '" . $y_p . "' AND i.status = '1'
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

        return $this->render('teamallp2', [
                    'y' => $y_p + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeamallp3() {

        $y = date("Y", time());
        $y_p = $y - '3';

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
                WHERE YEAR(i.created_at)= '" . $y_p . "' AND i.status = '1'
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

        return $this->render('teamallp3', [
                    'y' => $y_p + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeamallp4() {

        $y = date("Y", time());
        $y_p = $y - '4';

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
                WHERE YEAR(i.created_at)= '" . $y_p . "' AND i.status = '1'
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

        return $this->render('teamallp4', [
                    'y' => $y_p + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeamallp5() {

        $y = date("Y", time());
        $y_p = $y - '5';

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
                WHERE YEAR(i.created_at)= '" . $y_p . "' AND i.status = '1'
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

        return $this->render('teamallp5', [
                    'y' => $y_p + '543',
                    'graph' => $graph,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /* รายงานอุบัติการณ์ประเภทความเสี่ยงทั่วไป แยกตามระดับความรุนแรง */

    public function actionLvgreportall() {

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgreportall', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvgreportall2() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvg2 = $y - '1';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvg2 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgreportall2', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvg2 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvgreportall3() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvg3 = $y - '2';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvg3 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgreportall3', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvg3 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvgreportall4() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvg4 = $y - '3';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvg4 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgreportall4', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvg4 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvgreportall5() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvg5 = $y - '4';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvg5 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgreportall5', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvg5 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvgreportall6() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvg6 = $y - '5';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvg6 . "' AND i.status = '1' AND p.riskTypeID = '10'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvgreportall6', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvg6 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    /* รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกทั่วไป แยกตามระดับความรุนแรง */

    public function actionLvcreportall() {

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcreportall', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvcreportall2() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvc2 = $y - '1';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvc2 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcreportall2', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvc2 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvcreportall3() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvc3 = $y - '2';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvc3 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcreportall3', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvc3 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvcreportall4() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvc4 = $y - '3';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvc4 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcreportall4', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvc4 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvcreportall5() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvc5 = $y - '4';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvc5 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcreportall5', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvc5 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    public function actionLvcreportall6() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvc6 = $y - '5';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvc6 . "' AND i.status = '1' AND p.riskTypeID = '20'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvcreportall6', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvc6 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

    /* รายงานอุบัติการณ์ประเภทความเสี่ยงทางคลินิกเฉพาะโรค แยกตามระดับความรุนแรง */

    public function actionLvsreportall() {

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsreportall', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }
    public function actionLvsreportall2() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvs2 = $y - '1';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvs2 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsreportall2', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvs2 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }
    public function actionLvsreportall3() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvs3 = $y - '2';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvs3 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsreportall3', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvs3 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }
    public function actionLvsreportall4() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvs4 = $y - '3';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvs4 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsreportall4', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvs4 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }
    public function actionLvsreportall5() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvs5 = $y - '4';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvs5 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsreportall5', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvs5 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }
    public function actionLvsreportall6() {

        $d = date("d", time());
        $y = date("Y", time());
        $m = date("m", time());
        $y_lvs6 = $y - '5';

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
                WHERE MONTH(i.created_at)= '" . $m = '01' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql2 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '02' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql3 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '03' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data3,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql4 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '04' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data4 = Yii::$app->db->createCommand($sql4)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider4 = new ArrayDataProvider([
            'allModels' => $data4,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql5 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '05' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data5 = Yii::$app->db->createCommand($sql5)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider5 = new ArrayDataProvider([
            'allModels' => $data5,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql6 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '06' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data6 = Yii::$app->db->createCommand($sql6)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider6 = new ArrayDataProvider([
            'allModels' => $data6,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql7 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '07' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data7 = Yii::$app->db->createCommand($sql7)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider7 = new ArrayDataProvider([
            'allModels' => $data7,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql8 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '08' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data8 = Yii::$app->db->createCommand($sql8)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider8 = new ArrayDataProvider([
            'allModels' => $data8,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql9 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '09' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data9 = Yii::$app->db->createCommand($sql9)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider9 = new ArrayDataProvider([
            'allModels' => $data9,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql10 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '10' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data10 = Yii::$app->db->createCommand($sql10)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider10 = new ArrayDataProvider([
            'allModels' => $data10,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql11 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '11' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data11 = Yii::$app->db->createCommand($sql11)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider11 = new ArrayDataProvider([
            'allModels' => $data11,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);
        $sql12 = "SELECT 
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
                WHERE MONTH(i.created_at)= '" . $m = '12' . "' AND YEAR(i.created_at) = '" . $y_lvs6 . "' AND i.status = '1' AND p.riskTypeID = '30'
                GROUP BY rl.riskProID
                ";
        $data12 = Yii::$app->db->createCommand($sql12)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider12 = new ArrayDataProvider([
            'allModels' => $data12,
            'sort' => [
                'attributes' => ['riskProname', 'lv1', 'lv2', 'lv3', 'lv4', 'lv5', 'lv6', 'lv7', 'lv8', 'lv9']
            ]
        ]);

        return $this->render('lvsreportall6', [
                    'd' => $d,
                    'm' => $m,
                    'y' => $y_lvs6 + '543',
                    'dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2, 'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4, 'dataProvider5' => $dataProvider5, 'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7, 'dataProvider8' => $dataProvider8, 'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10, 'dataProvider11' => $dataProvider11, 'dataProvider12' => $dataProvider12,
        ]);
    }

}
