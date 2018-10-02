<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Status`.
 */
class m180215_045939_create_Status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Status', [
            'statusID' => $this->primaryKey(),
            'statusName' => $this->string(100),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Status');
    }
}
