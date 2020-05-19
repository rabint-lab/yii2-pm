<?php

use yii\helpers\Url;
use kartik\popover\PopoverX;
use yii\helpers\Html;
use kittools\webuipopover\WebUIPopover;

/* @var $items[] \rabint\pm\models\Message */
/* @var $this yii\web\View */
$notReadCount = 0;
//$this->beginBlock('pmMessagePopOver');
foreach ($items as $item) {
    $notReadCount += ($item->read == 0) ? 1 : 0;
}
?>
<?php
$icon = ($notReadCount == 0) ? 'fa-envelope-o' : 'fa-envelope';
$label = '<i class="fa ' . $icon . '"></i>
    <span class="unread-count" ';
$label .= ($notReadCount == 0) ? 'style="display:none"' : '';
$label .= '>' . \app\locality::faNumber($notReadCount) . '</span>';
?>

<?php
WebUIPopover::begin([
    'label' => $label,
    'tagName' => 'a',
    'tagOptions' => [
        'class' => 'login-link',
        'title' => \Yii::t('app', 'پیام ها'),
        'data-placement' => "auto",
//        'data-toggle' => "tooltip"
    ],
    'pluginOptions' => [
        'placement' => 'bottom-left',
        'animation' => 'pop', //fade
        'title' => \Yii::t('app', 'پیام های شما') . Html::a(\Yii::t('app', 'همه پیام ها') . ' <i class="fas fa-chevron-circle-left"></i>', ['/pm/default/index'], ['class' => 'popoverMoreLink', 'title' => \Yii::t('app', 'همه پیام ها')]),
//        'onShow' => 'function($element) {console.log($element);}',
        'direction' => \app\locality::langDir(),
        'container' => '.master-header',
//        'backdrop' => true,
        'width' => '300',
        'padding' => false,
    ],
]);
?>

<div class="pmMessagepopOverContent popoverContent">
    <?php
    if (empty($items)) {
        echo \Yii::t('app', 'تا کنون پیامی برای شما ارسال نشده است.');
    }
    foreach ($items as $item) {
        $notReadCount += ($item->read == 0) ? 1 : 0;
        ?>
        <div class="messageItem <?= ($item->read == 0) ? 'notRead' : ''; ?>">
            <span class="pmUserAvatar">
                <img src="<?php echo $item->user->userProfile->getAvatar(NULL, 'tiny') ?>" class = "user-image"/>
            </span>
            <div class="pmDetial">
                <a href="<?= Url::to(['/pm/default/view', 'id' => $item->id]); ?>" class="pmTitle">
                    <?= $item->subject; ?>
                </a>    
                <span class="pmTime">
                    <?= app\locality::jdate('j F Y H:i', $item->created_at); ?>
                </span>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
</div>

<?php WebUIPopover::end(); ?>
