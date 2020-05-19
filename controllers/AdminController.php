<?php

namespace rabint\pm\controllers;

use Yii;
use rabint\pm\models\Message;
use rabint\pm\models\search\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Message model.
 */
class AdminController extends \app\controllers\AdminController {

    const BULK_ACTION_SETREAD = 'bulk-read';
    const BULK_ACTION_SETNOTREAD = 'bulk-notread';
    const BULK_ACTION_DELETE = 'bulk-delete';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $ret = parent::behaviors();
        return $ret + [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * list of bulk action as static
     * @return array
     */
    public static function bulkActions() {
        return [
            static::BULK_ACTION_SETREAD => ['title' => \Yii::t('app', 'خوانده شده')],
            static::BULK_ACTION_SETNOTREAD => ['title' => \Yii::t('app', 'خوانده نشده')],
            static::BULK_ACTION_DELETE => ['title' => \Yii::t('app', 'حذف')],
        ];
    }

    /**
     * bulk action
     * @return mixed
     */
    public function actionBulk() {
        $action = Yii::$app->request->post('action');
        if (!isset(static::bulkActions()[$action])) {
            Yii::$app->session->setFlash('warning', \Yii::t('app', 'Bulk action Not found!'));
            return $this->redirect(\app\uri::referrer());
        }
        $selection = (array) Yii::$app->request->post('selection');
        switch ($action) {
            case static::BULK_ACTION_SETREAD:
                if (Message::updateAll(['read' => Message::READ_STATUS_YES], ['id' => $selection])) {
                    Yii::$app->session->setFlash('success', \Yii::t('app', 'Bulk action was successful'));
                    return $this->redirect(\app\uri::referrer());
                }
                break;
            case static::BULK_ACTION_SETNOTREAD:
                if (Message::updateAll(['read' => Message::READ_STATUS_NO], ['id' => $selection])) {
                    Yii::$app->session->setFlash('success', \Yii::t('app', 'Bulk action was successful'));
                    return $this->redirect(\app\uri::referrer());
                }
                break;
            case static::BULK_ACTION_DELETE:
                if (Message::deleteAll(['id' => $selection])) {
                    Yii::$app->session->setFlash('success', \Yii::t('app', 'Bulk action was successful'));
                    return $this->redirect(\app\uri::referrer());
                }
        }

        Yii::$app->session->setFlash('danger', \Yii::t('app', 'عملیات ناموفق بود'));
        return $this->redirect(\app\uri::referrer());
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Message();
        $model->scenario = Message::SCENARIO_BULK_SEND;
        if ($model->load(Yii::$app->request->post())) {
            $resivers = $model->receiver_id;
            $sent = 0;
            foreach ($resivers as $resiver) {
                if ($model->user_id == $resiver) {
                    continue;
                }
                $newModel = new Message();
                $newModel->user_id = $model->user_id;
                $newModel->read = $model->read;
                $newModel->subject = $model->subject;
                $newModel->message = $model->message;
                $newModel->receiver_id = $resiver;

                if ($newModel->save()) {
                    $sent++;
                }
            }
            if ($sent) {
                Yii::$app->session->setFlash('success', \Yii::t('app', '{sentCount} message has been sent', ['sentCount' => $sent]));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', \Yii::t('app', 'پیامی ارسال نشد'));
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->read == Message::READ_STATUS_YES) {
            Yii::$app->session->setFlash('warning', \Yii::t('app', 'پیام های خوانده شده ، نمی توانند ویرایش گردند'));
            return $this->redirect(['index']);
        }
        $model->scenario = Message::SCENARIO_BULK_SEND;
        if ($model->load(Yii::$app->request->post())) {
            $resivers = $model->receiver_id;
            $sent = 0;
            foreach ($resivers as $resiver) {
                if ($model->user_id == $resiver) {
                    continue;
                }
                $newModel = new Message();
                $newModel->user_id = $model->user_id;
                $newModel->read = $model->read;
                $newModel->subject = $model->subject;
                $newModel->message = $model->message;
                $newModel->receiver_id = $resiver;

                if ($newModel->save()) {
                    $sent++;
                }
            }
            if ($sent) {
                $model->delete();
                Yii::$app->session->setFlash('success', \Yii::t('app', '{sentCount} message has been sent', ['sentCount' => $sent]));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', \Yii::t('app', 'پیامی ارسال نشد'));
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
