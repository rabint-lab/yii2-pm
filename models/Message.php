<?php

namespace  rabint\pm\models;

use Yii;
//use \rabint\user\models\User;
use rabint\user\models\User;

/**
 * This is the model class for table "user_message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $receiver_id
 * @property string $subject
 * @property string $message
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $read
 * @property integer $priority
 *
 * @property User $user
 * @property User $receiver
 */
class Message extends \yii\db\ActiveRecord /*\app\models\ActiveRecord*/ {

    const SCENARIO_READ = 'read';
    const SCENARIO_BULK_SEND = 'bulkSend';
    const SCENARIO_USER_SEND = 'userSend';
    /* read status */
    const READ_STATUS_NO = 0;
    const READ_STATUS_YES = 1;
    /* Preority */
    const PRIORITY_LOW = 1;
    const PRIORITY_NORMAL = 2;
    const PRIORITY_HIGH = 3;
    const PRIORITY_VERYHIGH = 4;

    public $receiver_name;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_message';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => FALSE,
                'value' => time(),
            ],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_READ] = ['read', 'updated_at'];
        $scenarios[self::SCENARIO_USER_SEND] = ['user_id', 'receiver_id', 'subject', 'message','priority', 'receiver_name'];
        return $scenarios;
    }

    /* ====================================================================== */

    public static function readStatuses() {
        return [
            static::READ_STATUS_NO => ['title' => \Yii::t('app', 'خوانده نشده')],
            static::READ_STATUS_YES => ['title' => \Yii::t('app', 'خوانده شده')],
        ];
    }

    public static function priorities() {
        return [
            static::PRIORITY_LOW => ['title' => \Yii::t('app', 'کم')],
            static::PRIORITY_NORMAL => ['title' => \Yii::t('app', 'متوسط')],
            static::PRIORITY_HIGH => ['title' => \Yii::t('app', 'زیاد')],
            static::PRIORITY_VERYHIGH => ['title' => \Yii::t('app', 'بسیار زیاد')],
        ];
    }

    /* ====================================================================== */

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'receiver_id', 'subject', 'message'], 'required'],
            [['user_id', 'receiver_id', 'created_at', 'updated_at', 'read', 'priority'], 'integer'],
            [['receiver_name'], 'required', 'on' => self::SCENARIO_USER_SEND],
            [['receiver_name'], 'string'],
            [['message'], 'string'],
            [['subject'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_id' => 'id']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_id' => 'id']],
            ['receiver_id', 'each', 'rule' => ['integer'], 'on' => self::SCENARIO_BULK_SEND],
//            ['receiver_id', 'each', 'rule' => [
//                    'exist', 'skipOnError' => true,
//                    'targetClass' => User::className(), 'targetAttribute' => ['receiver_id' => 'id']
//                ], 'on' => self::SCENARIO_BULK_SEND],
            [['receiver_name', 'message', 'subject'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'شناسه'),
            'user_id' => Yii::t('app', 'ارسال کننده'),
            'receiver_id' => Yii::t('app', 'دریافت کننده'),
            'receiver_name' => Yii::t('app', 'دریافت کننده'),
            'subject' => Yii::t('app', 'موضوع'),
            'message' => Yii::t('app', 'متن پیام'),
            'created_at' => Yii::t('app', 'تاریخ ارسال'),
            'updated_at' => Yii::t('app', 'تاریخ دریافت'),
            'read' => Yii::t('app', 'خوانده شده'),
            'priority' => Yii::t('app', 'اولویت'),
        ];
    }

    /**
     * @return \app\models\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \app\models\ActiveQuery
     */
    public function getReceiver() {
        return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    }

}
