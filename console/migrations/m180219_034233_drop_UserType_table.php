<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `UserType`.
 */
class m180219_034233_drop_UserType_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('UserType');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('UserType', [
            'id' => $this->primaryKey(),
        ]);
    }
}
