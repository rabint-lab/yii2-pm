<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \rabint\pm\models\Message */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view-box message-view">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="action-box">
                        <h2 class="master-title">
                            <?= Html::encode($this->title) ?>
                            <?= Html::a(Yii::t('app', 'Create Message'), ['create'], ['class' => 'btn btn-success btn-xs btn-flat']) ?>
                            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs btn-flat']) ?>
                            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-xs btn-flat',
                            'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                            ],
                            ]) ?>
                        </h2>
                    </div>
                </div>
                <div class="box-body">

                    <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                                'id',
            'user_id',
            'receiver_id',
            'subject',
            'message:ntext',
            'created_at',
            'updated_at',
            'read',
                    ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
