<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel \rabint\pm\models\search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grid-box message-index">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-info">
                <?= Html::beginForm(['bulk'], 'post'); ?>
                <div class="box-header">
                    <div class="box-tools pull-right float-right">
                        <div class="input-group input-group-sm" style="width: 350px;">
                            <span class="input-group-addon bg-gray"><?= \Yii::t('app', 'Bulk action'); ?></span>
                            <?= Html::dropDownList('action', '', ArrayHelper::getColumn(\rabint\pm\controllers\AdminController::bulkActions(), 'title'), ['class' => 'form-control', 'prompt' => '']); ?>
                            <div class="input-group-btn">
                                <?= Html::submitButton(\Yii::t('app', 'Do'), ['class' => 'btn btn-info']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">

                    <?=
                    GridView::widget([
                        'layout' => "<div class=\"pull-left float-left\">{summary}</div>\n{items}\n{pager}",
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\CheckboxColumn'],
                            [
                                'attribute' => 'id',
                                'filterOptions' => ['style' => 'max-width:100px;'],
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'user_id',
                                'value' => function ($model) {
                                    return $model->user->displayName;
                                }
                            ],
                            [
                                'attribute' => 'receiver_id',
                                'value' => function ($model) {
                                    return $model->receiver->displayName;
                                }
                            ],
                            'subject',
//                            'message:ntext',
                            [
                                'class' => \rabint\components\grid\JDateColumn::className(),
                                'attribute' => 'created_at',
                            ],
                            [
                                'class' => \rabint\components\grid\JDateColumn::className(),
                                'attribute' => 'updated_at',
                            ],
                            [
                                'class' => '\rabint\components\grid\EnumColumn',
                                'attribute' => 'read',
                                'enum' => ArrayHelper::getColumn(rabint\pm\models\Message::readStatuses(), 'title')
                            ],
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>

                </div>
                <?= Html::endForm(); ?> 
            </div>
        </div>
    </div>
</div>

