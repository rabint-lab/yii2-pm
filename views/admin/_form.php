<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \rabint\pm\models\Message */
/* @var $form yii\widgets\ActiveForm */
$userList = \yii\helpers\ArrayHelper::map(rabint\user\models\search\userSearch::searchFactory([],true)->all(), 'id', 'username');
//pr($userList,1);
?>

<?php $form = ActiveForm::begin(); ?>

<div class="clearfix"></div>
<div class="form-box message-form">
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                            <div class="box-tools pull-left float-left">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="box-body">

                            <?= \rabint\helpers\widget::select2Tag($form, $model, 'receiver_id', $userList, ['placeholder' => \Yii::t('app', 'کاربران دریافت کننده')]); ?>

                            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="row">
                <!-- =================================================================== -->
                <div class="col-sm-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= Yii::t('app', 'تنظیمات') ?></h3>
                            <div class="box-tools pull-left float-left">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php $model->user_id = empty($model->user_id) ? \rabint\helpers\user::id() : $model->user_id; ?>
                            <?= \rabint\helpers\widget::select2($form, $model, 'user_id', $userList, ['placeholder' => \Yii::t('app', 'کاربر ارسال کننده')]); ?>

                            <?php echo $form->field($model, 'read')->checkbox() ?>
                        </div>
                        <div class="card-footer block-content block-content-full bg-gray-light">
                            <div class="pull-left float-left">
                                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'ارسال') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
                            </div>
                        </div><!-- /.box-footer-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php ActiveForm::end(); ?>