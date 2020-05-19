<?php

namespace rabint\pm\controllers;

use Yii;
use rabint\pm\models\Message;
use rabint\pm\models\search\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Message model.
 */
class DefaultController extends \rabint\controllers\DefaultController /*\app\controllers\PanelController*/ {

    public $layout = '@theme/views/layouts/main';

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
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \rabint\pm\models\search\MessageSearch();
        $params = Yii::$app->request->queryParams;
        $params['MessageSearch']['receiver_id'] = \rabint\helpers\user::id();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = ['defaultOrder' => ['read' => SORT_ASC, 'created_at' => SORT_DESC]];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSends() {
        $searchModel = new MessageSearch();
        $params = Yii::$app->request->queryParams;
        $params['MessageSearch']['user_id'] = \rabint\helpers\user::id();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = ['defaultOrder' => ['read' => SORT_ASC, 'created_at' => SORT_DESC]];
        return $this->render('sends', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSend($reply = NULL) {
        $model = new Message();
        $model->scenario = Message::SCENARIO_USER_SEND;
        if ($model->load(Yii::$app->request->post())) {
            $receiverUser = \rabint\user\models\search\UserSearch::find()
                            ->select(['id'])
//                            ->where([
//                                'OR',
//                                    ['like', 'username', $model->receiver_name],
//                                    ['like', 'email', $model->receiver_name]
//                            ])
                    ->where(['=','username',$model->receiver_name])
                    ->scalar();
            if (!$receiverUser) {
                Yii::$app->session->setFlash('warning', \Yii::t('app', 'کاربری با این مشخصات پیدا نشد!'));
            } else {
                if (!Yii::$app->user->can('postCommentPublish')) {
//                    $role = Yii::$app->user->role($receiverUser);
//                    var_dump($role);
//                    die('--as-as--');
//                    if (\rabint\user\models\User::ROLE_ADMINISTRATOR !== $role) {
//                        Yii::$app->session->setFlash('warning', \Yii::t('app', 'کاربری با این مشخصات پیدا نشد!'));
//                        $model->receiver_id = NULL;
//                    }
                }
//                } else {
//                $model->read = Message::READ_STATUS_NO;
                    $model->user_id = \rabint\helpers\user::id();
                    $model->receiver_id = $receiverUser;
                    if ($model->priority) {
                        $model->priority = 2;
                    } else {
                        $model->priority = 1;
                    }
//                }
                if ($model->save()) {
                    if ($model->priority > 1) {
                        Yii::$app->commandBus->handle(new \common\commands\SendEmailCommand([
                            'subject' => $model->subject,
                            'view' => 'message',
                            'to' => $model->receiver->email,
                            'params' => [
                                'body' => $model->message,
                                'url' => \yii\helpers\Url::to(['/pm/default/view', 'id' => $model->id], true)
                            ]
                        ]));
                    }
                    Yii::$app->session->setFlash('success', \Yii::t('app', 'your message has been sent'));
                    return $this->redirect(['index']);
                } else {
                    $err = \rabint\helpers\str::modelErrToStr($model->errors);
                    Yii::$app->session->setFlash('danger', \Yii::t('app', 'پیامی ارسال نشد') . $err);
                }
            }
        }
        if ($reply !== NULL) {
            $replyModel = $this->findModel($reply);
            if ($replyModel != NULL) {
                if ($replyModel->user_id == \rabint\helpers\user::id()) {
                    $model->receiver_name = $replyModel->receiver->username;
                } else {
                    $model->receiver_name = $replyModel->user->username;
                }
                $model->subject = \Yii::t('app', 'پاسخ به: {subject}', ['subject' => $replyModel->subject]);
            }
        }

        return $this->render('send', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        if ($model->receiver_id != \rabint\helpers\user::id() AND $model->user_id != \rabint\helpers\user::id()) {
            throw new \yii\web\ForbiddenHttpException(\Yii::t('app', 'you dont have Access to this page!'));
        }
        if ($model->read == Message::READ_STATUS_NO AND $model->receiver_id == \rabint\helpers\user::id()) {
            $model->scenario = Message::SCENARIO_READ;
            $model->read = Message::READ_STATUS_YES;
            $model->updated_at = time();
            $model->save();
        }
        return $this->render('view', [
                    'model' => $model,
        ]);
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
