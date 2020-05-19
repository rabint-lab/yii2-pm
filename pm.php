<?php

namespace rabint\pm;
//echo 123;exit;
/**
 * pm module definition class
 */
class pm extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'rabint\pm\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

    public static function adminMenu() {
        
        
        return [
            'label' => \Yii::t('app', 'پبام خصوصی'),
            'icon' => '<i class="fas fa-envelope"></i>',
            'url' => '#',
            'options' => ['class' => 'treeview'],
            'visible' =>\rabint\helpers\user::id()>0,
            'items' => [
                [
                    'label' => \Yii::t('app', 'مشاهده تمام پیام ها'),
                    'url' => ['/pm/admin'],
                    'icon' => '<i class="far fa-circle"></i>',
                    'visible' => \rabint\helpers\user::can('manager'),
                    ],
                [
                    'label' => \Yii::t('app', 'ارسال پیام'),
                    'url' => ['/pm/admin/create'],
                    'icon' => '<i class="far fa-circle"></i>',
                    'visible' => \rabint\helpers\user::can('manager'),
                    ],
                [
                    'label' => \Yii::t('app', 'مشاهده تمام پیام ها'),
                    'url' => ['/pm/default'],
                    'icon' => '<i class="far fa-circle"></i>',
                    'visible' => !\rabint\helpers\user::can('manager'),
                    ],
                [
                    'label' => \Yii::t('app', 'ارسال پیام'),
                    'url' => ['/pm/default/create'],
                    'icon' => '<i class="far fa-circle"></i>',
                    'visible' => !\rabint\helpers\user::can('manager'),
                    ],
            ]
        ];
    }

}
