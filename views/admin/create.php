<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \rabint\pm\models\Message */

$this->title = Yii::t('app', 'ایجاد پیام');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-box message-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
