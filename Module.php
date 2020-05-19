<?php

# THIS FILE ISDISABLED 

//EXIT;
namespace rabint\pm;

/**
 * notify module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'rabint\pm\controllers';

    /**
     * @inheritdoc
     */
    public function init()    {
        parent::init();

        // custom initialization code goes here
    }


    public static function adminMenu()
    {
        return [
            [
                'label' => \Yii::t('rabint', 'اعلانات'),
                'options' => ['class' => 'nav-main-heading'],
                'visible' => \rabint\helpers\user::can('manager'),
            ],
            [
                'label' => \Yii::t('app', 'مدیریت اعلانات'),
                'visible' => \rabint\helpers\user::can('manager'),
                'icon' => '<i class="fas fa-chart-area"></i>',
                'url' => '#',
                'options' => ['class' => 'treeview'],
                'items' => [
                    ['label' => \Yii::t('app', 'لیست اعلانات'), 'url' => ['/notify/admin/index'], 'icon' => '<i class="fas fa-plus-circle"></i>'],
//                    ['label' => \Yii::t('app', 'مدیریت گزارش ها'), 'url' => ['/structurer/admin-report/index'], 'icon' => '<i class="fas fa-chart-bar"></i>'],
                    // ['label' => \Yii::t('app', 'درون ریزی'), 'url' => ['/structurer/admin-data/import'], 'icon' => '<i class="fas fa-file-import"></i>'],
                    // ['label' => \Yii::t('app', 'برون بری'), 'url' => ['/structurer/admin-data/export'], 'icon' => '<i class="fas fa-file-export"></i>'],
//                    ['label' => \Yii::t('app', 'دسته بندی گزارش ها'), 'url' => ['/structurer/admin-report-category/index'], 'icon' => '<i class="fas  fa-folder-open"></i>'],
//                    ['label' => \Yii::t('app', 'موجودیت ها و داده ها'), 'url' => ['/structurer/admin-structure/index'], 'icon' => '<i class="fas fa-server"></i>'],
                ],
            ],

        ];
    }
}
