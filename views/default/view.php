<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \rabint\pm\models\Message */

$this->title = \Yii::t('app', 'پیام من') . ': ' . $model->subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'پیام های من'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail_box message-view">
    <div class="row">
        <div class="main-content">
            <div class="post-content-box ">
                <div class="content-text">
                    <p class="class">
                        <?= $model->message; ?>
                    </p>
                </div>
                <div class="clearfix"></div>
                <div class="postViewDetail">
                    <span class="item_stats stats_date" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?= \Yii::t('app', 'تاریخ ارسال:'); ?><?= \app\locality::jdate('j F Y - H:i', $model->created_at); ?>"><i class="fas fa-calendar"></i><?= \app\locality::jdate('j F Y - H:i', $model->created_at); ?></span>
                    <?php if ($model->user_id == \rabint\helpers\user::id()) { ?>
                        <span class="item_stats stats_author" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?= \Yii::t('app', 'دریافت کننده:'); ?><?= $model->receiver->displayName; ?>"><i class="fas fa-user-o"></i><?= $model->receiver->displayName; ?></span>
                    <?php } else { ?>
                        <span class="item_stats stats_author" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?= \Yii::t('app', 'ارسال کننده:'); ?><?= $model->user->displayName; ?>"><i class="fas fa-user"></i><?= $model->user->displayName; ?></span>
                    <?php } ?>
                    <?= Html::a(\Yii::t('app', 'پاسخ دادن'), ['/pm/default/send', 'reply' => $model->id], ['class' => 'btn btn-warning btn-sm pull-left']); ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>