<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \rabint\pm\models\Message */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Message',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="create-box message-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
