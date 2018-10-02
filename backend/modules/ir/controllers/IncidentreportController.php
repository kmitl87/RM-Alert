<?php

namespace backend\modules\ir\controllers;

use Yii;
use common\models\Incidentreport;
use backend\modules\ir\models\IncidentreportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use kartik\mpdf\Pdf;
use common\models\RiskList;
use common\models\RiskProfile;
use common\models\Team;
use common\models\TeamList;
use common\models\User;
use yii\data\ActiveDataProvider;

/**
 * IncidentreportController implements the CRUD actions for Incidentreport model.
 */
class IncidentreportController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $userrule = [];
        if (Yii::$app->user->identity->role == '2') {
            $userrule = [
                [
                    'actions' => ['error'],
                    'allow' => true,
                    'roles' => ['?']
                ],
                [
                    'actions' => ['userindex', 'userview', 'create', 'update', 'delete'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ];
        } else {
            $userrule = [
                [
                    'actions' => ['login', 'error'],
                    'allow' => true,
                    'roles' => ['?']
                ],
                [
                    'actions' => ['index', 'userindex', 'view', 'userview', 'create', 'update', 'print', 'accept', 'delete'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['index', 'view', 'update', 'delete', 'accept'],
                    'allow' => false,
                    'roles' => ['?']
                ],
            ];
        }
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $userrule,
                ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex() {
        $searchModel = new IncidentreportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         /* เรียงข้อมูลรออนุมัติขึ้นก่อน */
        $dataProvider->setSort([
            'defaultOrder' => [ 'status' => SORT_ASC],
        ]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserindex()
    {
        $searchModel = new IncidentreportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['created_by' => Yii::$app->user->identity->id]); //เอาเฉพาะของตัวเอง

        return $this->render('userindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        $sql = "SELECT p.riskProname
            
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE i.irID = '" . $id . "'
                GROUP BY rl.id
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname','teamName']
            ]
        ]);
        
        $sql2 = "SELECT t.teamName
            
                FROM incidentreport i
                LEFT JOIN team_list tl ON tl.irID = i.irID
                LEFT JOIN team t ON t.teamID = tl.teamID
                WHERE i.irID = '" . $id . "'
                GROUP BY tl.id
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['teamName']
            ]
        ]);
        
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'dataProvider' => $dataProvider,'dataProvider2'=>$dataProvider2 
        ]);
    }

    public function actionUserview($id)
    {
        $sql = "SELECT p.riskProname
            
                FROM incidentreport i
                LEFT JOIN risk_list rl ON rl.irID = i.irID
                LEFT JOIN risk_profile p ON p.riskProID = rl.riskProID
                WHERE i.irID = '" . $id . "'
                GROUP BY rl.id
                ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['riskProname','teamName']
            ]
        ]);
        
        $sql2 = "SELECT t.teamName
            
                FROM incidentreport i
                LEFT JOIN team_list tl ON tl.irID = i.irID
                LEFT JOIN team t ON t.teamID = tl.teamID
                WHERE i.irID = '" . $id . "'
                GROUP BY tl.id
                ";
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $data2,
            'sort' => [
                'attributes' => ['teamName']
            ]
        ]);
        return $this->render('userview', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,'dataProvider2'=>$dataProvider2
        ]);

    }
    
    public function getIncidentreportID() {

        $order = Incidentreport::find()->select('irID')->orderBy('irID DESC')->one();
        $currentYear = substr(date('Y') + 543, 2, 2);
        $currentID = '00001';

        if (!empty($order)) {

            $lastYear = substr($order->irID, 3, 2);
            $lastID = substr($order->irID, 5, 5);

            if ($currentYear == $lastYear) {

                $newID = $lastID + 1;
                $currentID = str_pad($newID, 5, '0', STR_PAD_LEFT);
            }
        }

        return 'IR-' . $currentYear . $currentID;
    }

    public function actionRiskProfileDetail($id = null) {
        $risk_profile = RiskProfile::findOne($id);
        echo $risk_profile->riskProName;
    }
    
    public function actionCreate() {
        $model = new Incidentreport();
        $model->irID = $this->getIncidentreportID();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->save(); //บันทึกใบ IR

                $items = Yii::$app->request->post();

                foreach ($items['Incidentreport']['items'] as $key1 => $val1) { //นำรายการความเสี่ยงที่เลือกมา loop บันทึก
                    if (empty($val1['id'])) {
                        $risk_list = new \common\models\RiskList();
                    } else {
                        $risk_list = RiskList::findOne($val1['id']);
                    }
                    $risk_list->irID = $model->irID;
                    $risk_profile = RiskProfile::findOne($val1['riskProID']);

                    $risk_list->riskProID = $risk_profile->riskProID;
                    $risk_list->save();
                }

                foreach ($items['Incidentreport']['teams'] as $key2 => $val2) { //นำรายการทีมหรือหน่วยงานที่เลือกมา loop บันทึก
                    if (empty($val2['id'])) {
                        $team_list = new \common\models\TeamList();
                    } else {
                        $team_list = TeamList::findOne($val2['id']);
                    }
                    $team_list->irID = $model->irID;
                    $team = Team::findOne($val2['teamID']);

                    $team_list->teamID = $team->teamID;
                    $team_list->save();
                }

                $transaction->commit();
                $this->sendLine($model);
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                if(Yii::$app->user->identity->role != '2'){
                    return $this->redirect(['view', 'id' => $model->irID]); //ไปยังหน้าวิวadmin
                }
                else {
                    return $this->redirect(['incidentreport/userview','id' => $model->irID]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'มีข้อผิดพลาดในการบันทึก');
                return $this->redirect(['create']);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Incidentreport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = Incidentreport::findOne($id); //เลือกใบ IR
        $model->items = RiskList::find()->where(['irID' => $model->irID])->all();
        $model->teams = TeamList::find()->where(['irID' => $model->irID])->all();
        
        $status = $model->status;
        if($status != '1'){
            if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->save(); //บันทึกใบ IR

                $items = Yii::$app->request->post();

                foreach ($items['Incidentreport']['items'] as $key1 => $val1) { //นำรายการความเสี่ยงที่เลือกมา loop บันทึก
                    if (empty($val1['id'])) {
                        $risk_list = new \common\models\RiskList();
                    } else {
                        $risk_list = RiskList::findOne($val1['id']);
                    }
                    $risk_list->irID = $model->irID;
                    $risk_profile = RiskProfile::findOne($val1['riskProID']);

                    $risk_list->riskProID = $risk_profile->riskProID;
                    $risk_list->save();
                }
                foreach ($items['Incidentreport']['teams'] as $key2 => $val2) { //นำรายการทีมหรือหน่วยงานที่เลือกมา loop บันทึก
                    if (empty($val2['id'])) {
                        $team_list = new \common\models\TeamList();
                    } else {
                        $team_list = TeamList::findOne($val2['id']);
                    }
                    $team_list->irID = $model->irID;
                    $team = Team::findOne($val2['teamID']);

                    $team_list->teamID = $team->teamID;
                    $team_list->save();
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                if(Yii::$app->user->identity->role != '2'){
                    return $this->redirect(['view', 'id' => $model->irID]); //ไปยังหน้าวิวadmin
                }
                else {
                    return $this->redirect(['incidentreport/userview','id' => $model->irID]);
                }
                
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'มีข้อผิดพลาดในการบันทึก');
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
        }
    else {
           Yii::$app->getSession()->setFlash('danger', 'รายงานอุบัติการณ์นี้ถูกพิจารณาแล้ว..ไม่สามารถแก้ไขข้อมูลได้');
           if(Yii::$app->user->identity->role != '2'){
                    return $this->redirect(['index', 'id' => $model->irID]); //ไปยังหน้าวิวadmin
                }
                else {
                    return $this->redirect(['incidentreport/userindex','id' => $model->irID]);
                }
       }           
    }

    /**
     * Deletes an existing Incidentreport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete() {
        
        if(array_key_exists("risklist_id",$_GET)){
            $rl_id = $_GET['risklist_id'];

            $model = RiskList::findOne($rl_id);
            $model->delete();
        }else if(array_key_exists("teamlist_id",$_GET)){
            $t_id = $_GET['teamlist_id'];
            
            $model = TeamList::findOne($t_id);
            $model->delete();
        }
    }
    
    
    public function sendLine($model) {
        $level = $model->level;
        $line_token = 'IYAC0jUH0rTdOwnG1Kv4HDO8La9Jh0znxcAlwYC7JYj';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://notify-api.line.me/api/notify");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "message=".$model->irID."\r\n"."ระดับความรุนแรง: ".$level->levelName."\r\n"."ปัญหา:".$model->issue."\r\n"."สถานที่:".$model->location);
        // follow redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$line_token,
        ]);
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);
        //var_dump($server_output);
        //echo Yii::getAlias('@webroot').'/images/programmerthailand_social.jpg';
    }

    public function actionAccept($id)
    {
        $model = Incidentreport::findOne($id);
        $status = $model->status;
       if($status != '1'){
           $model = $this->findModel($id);
            $model->status = '1';
            $model->save();
            Yii::$app->getSession()->setFlash('success', 'พิจารณาใบรายงานอุบัติการณ์นี้แล้ว');

        return $this->redirect(['index']);
       } 
        else {
           Yii::$app->getSession()->setFlash('danger', 'ใบรายงานนี้เคยถูกพิจารณาแล้ว');
           return $this->redirect(['index']);
       } 
    }
    
    public function actionPrint($id)
    {
        $model = Incidentreport::findOne($id);       
        $status = $model->status;
        if($status == '1'){

        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('printview', ['model' => $this->findModel($id),]);
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.css', 
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                //'SetHeader' => ['แบบขออนุมัติใช้รถส่วนกลาง'],
                //'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
        }
        else {
           Yii::$app->getSession()->setFlash('danger', 'ใบรายงานนี้ยังไม่ถูกพิจารณา !!');
           return $this->redirect(['view', 'id' => $model->irID]);
       } 
    }

    /**
     * Finds the Incidentreport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Incidentreport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Incidentreport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('ไม่พบผลลัพธ์.');
    }

}
