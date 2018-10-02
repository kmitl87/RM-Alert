<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `level`.
 */
class m180219_034206_drop_level_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('level');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('level', [
            'id' => $this->primaryKey(),
        ]);
    }
}
