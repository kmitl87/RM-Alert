<?php

use yii\db\Migration;

/**
 * Handles the creation of table `UserType`.
 */
class m180215_064349_create_UserType_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('UserType', [
            'userTypeID' => $this->primaryKey(),
            'userTypeName' => $this->string(150),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('UserType');
    }
}
