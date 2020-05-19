<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use \rabint\user\models\User;
use rabint\user\models\search\UserSearch as user;

/* @var $this yii\web\View */
/* @var $model \rabint\pm\models\Message */

$this->title = Yii::t('app', 'ارسال پیام');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'پیام خصوصی'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-box message-create">


    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">

        <?php

        if (Yii::$app->user->can('postPublishGroup')) {
            echo $form->field($model, 'receiver_name')
                    ->textInput(['maxlength' => true])
                    ->hint(\Yii::t('app', 'نام کاربری یا ایمیل کاربر دریافت کننده را بنویسید'));
        } else {
            $admins = User::searchFactory([],true)
                    ->role(User::ROLE_ADMINISTRATOR)
                    ->andwhere(['NOT in','id',[\rabint\helpers\user::id()]])
                    ->all();
            $admins = yii\helpers\ArrayHelper::map($admins, 'username', 'displayName');
            echo $form->field($model, 'receiver_name')
                    ->dropDownList($admins);
        }
        ?>

        <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
        <?php
        if (Yii::$app->user->can('postCommentPublish')) {
            echo $form->field($model, 'priority')->checkbox(['label' => \Yii::t('app', 'پیام برای کاربر ایمیل گردد.')]);
        }
        ?>

        <div class="center">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'ارسال') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
        </div>
    </div>

</div>


<?php ActiveForm::end(); ?>