<?php

use yii\db\Migration;

class m200515_110726_create_table_user_message extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_message}}', [
            'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY')->comment('شناسه'),
            'user_id' => $this->integer()->comment('ارسال کننده'),
            'receiver_id' => $this->integer()->comment('دریافت کننده'),
            'subject' => $this->string(190)->notNull()->comment('موضوع'),
            'message' => $this->text()->notNull()->comment('متن پیام'),
            'created_at' => $this->integer()->comment('تاریخ ارسال'),
            'updated_at' => $this->integer()->comment('تاریخ دریافت'),
            'read' => $this->integer()->defaultValue('0')->comment('خوانده شده'),
            'priority' => $this->integer()->notNull()->defaultValue('0')->comment('اولویت'),
            'receiver_name' => $this->string(190)->comment('نام دریافت کننده'),
        ], $tableOptions);

        $this->addForeignKey('fk_user_msg_fk', '{{%user_message}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_reciver_msg_fk', '{{%user_message}}', 'receiver_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_message}}');
    }
}
