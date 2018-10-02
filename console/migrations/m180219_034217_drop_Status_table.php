<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Status`.
 */
class m180219_034217_drop_Status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Status');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Status', [
            'id' => $this->primaryKey(),
        ]);
    }
}
