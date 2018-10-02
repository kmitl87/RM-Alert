<?php

namespace backend\modules\personal\controllers;

use Yii;
use common\models\Person;
use backend\modules\personal\models\PersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use yii\web\UploadedFile;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $userrule = [];
        if (Yii::$app->user->identity->role == '0') {
            $userrule = [
                [
                    'actions' => ['login', 'error'],
                    'allow' => true,
                    'roles' => ['?']
                ],
                [
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Person();
        $user = new User();

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($user->password_hash);
            $user->auth_key = Yii::$app->security->generateRandomString();

            if ($user->save()) {
                /* $file = UploadedFile::getInstance($model, 'person_img');
                  if ($file->size!=0){
                  $model->photo = $user->id.'.'.$file->extension;
                  $file->saveAs('uploads/person/'.$user->id.'.'.$file->extension);
                  } */
                $model->user_id = $user->id;
                $model->save();
                Yii::$app->getSession()->setFlash('success', 'ทำการเพิ่มผู้ใช้งานในระบบแล้ว');
            }
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'user' => $user,
            ]);
        }
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $user = $model->user;
        $oldPass = $user->password_hash;
        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {

            if ($oldPass != $user->password_hash) { //กรณีเปลี่ยนรหัสผ่านใหม่
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->password_hash);
            }
            if ($user->save()) {
                /* $file = UploadedFile::getInstance($model, 'person_img');
                  if (isset($file->size) && $file->size!==0){//เปลี่ยนรูปภาพใหม่
                  $file->saveAs('uploads/person/'.$user->id.'.'.$file->extension);
                  } */
                $model->save();
                Yii::$app->getSession()->setFlash('success', 'ทำการแก้ไขข้อมูลผู้ใช้งานในระบบแล้ว');
            }

            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'user' => $user,
            ]);
        }
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $user = User::findOne($id);
        $this->findModel($id);
        $select = Person::find()
                ->select('user_id')
                ->where(['user_id' => $id])
                ->all();

        Person::find()->where(['user_id' => $id])->one()->delete();

        User::find()->where(['id' => $id])->one()->delete();
        Yii::$app->getSession()->setFlash('success', 'ทำการลบผู้ใช้งานจากระบบแล้ว !');

        return $this->redirect(['index', 'select' => $select]);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('ไม่พบข้อมูล.');
    }

}
