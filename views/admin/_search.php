<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \rabint\pm\models\search\MessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search_box message-search">

    <div class="row">
        <?php $form = ActiveForm::begin([
            //'action' => ['index'],
            'method' => 'get',
        ]); ?>
        
        <div class="col-sm-4"><?= $form->field($model, 'id') ?></div>

        <div class="col-sm-4"><?= $form->field($model, 'user_id') ?></div>

        <div class="col-sm-4"><?= $form->field($model, 'receiver_id') ?></div>

        <div class="col-sm-4"><?= $form->field($model, 'subject') ?></div>

        <div class="col-sm-4"><?= $form->field($model, 'message') ?></div>

        <!--<div class="col-sm-4"><?php // echo $form->field($model, 'created_at') ?></div>-->

        <!--<div class="col-sm-4"><?php // echo $form->field($model, 'updated_at') ?></div>-->

        <!--<div class="col-sm-4"><?php // echo $form->field($model, 'read') ?></div>-->

        <div class="form-group  center center-block">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?php // echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
            <?= Html::a(Yii::t('app', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    
</div>
