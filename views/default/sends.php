<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel \rabint\pm\models\search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'پیام های ارسالی');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'پیام های من'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list_box message-index">

    <h3><?= Html::encode($this->title) ?>
        <div class="toolbar pull-left float-left">
            <a href="<?= \yii\helpers\Url::to(['send']); ?>" class="btn btn-warning btn-xs">
                <i class="fas fa-paper-plane"></i>
                <?= \Yii::t('app', 'ارسال پیام'); ?>
            </a>
            <a href="<?= \yii\helpers\Url::to(['index']); ?>" class="btn btn-info btn-xs">
                <i class="fas fa-list"></i>
                <?= \Yii::t('app', 'پیام های دریافتی'); ?>
            </a>
        </div>
    </h3>
    <div class="row">
        <?=
        GridView::widget([
            'layout' => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
                    [
                    'attribute' => 'id',
                    'filterOptions' => ['style' => 'max-width:100px;'],
                    'format' => 'raw',
                ],
                    [
                    'attribute' => 'receiver_id',
                    'value' => function ($model) {
                        return $model->receiver->displayName;
                    }
                ],
                    [
                    'attribute' => 'subject',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->subject, ['view', 'id' => $model->id]);
                    }
                ],
//                            'message:ntext',
                [
                    'class' => \rabint\components\grid\JDateColumn::className(),
                    'attribute' => 'created_at',
                ],
                    [
                    'class' => '\rabint\components\grid\EnumColumn',
                    'attribute' => 'read',
                    'enum' => ArrayHelper::getColumn(rabint\pm\models\Message::readStatuses(), 'title')
                ],
            ],
        ]);
        ?>


    </div>
</div>
