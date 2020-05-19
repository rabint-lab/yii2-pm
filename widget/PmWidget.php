<?php

/**
 * pm widget
 * @author Mojtaba Akbarzadeh <ingenious@chmail.com>
 * @copyright (c) sahifedp, sahife data producers
 */

namespace \rabint\pm\widget;

use \rabint\pm\models\Message;

/**
 * Class login
 */
class PmWidget extends \yii\bootstrap\Widget {

    var $style = 'default';
    var $menuClass = 'userPm';
    var $timeLimit = FALSE;
    var $count = 10;

    public function run() {
        $items = Message::find()
                ->andWhere([
            'receiver_id' => \app\user::id(),
//            'read' => Message::READ_STATUS_NO,
        ]);
        if ($this->timeLimit) {
            $items->andWhere(['>=', 'created_at', time() - $this->timeLimit]);
        }
        $items->limit($this->count);
        $items->orderBy(['read' => SORT_ASC, 'created_at' => SORT_DESC]);
        $items = $items->all();
        return $this->render('PmWidget/' . $this->style, [
                    'menuClass' => $this->menuClass,
                    'items' => $items,
        ]);
    }

}
