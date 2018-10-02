<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Team`.
 */
class m180219_034116_drop_Team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Team');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Team', [
            'id' => $this->primaryKey(),
        ]);
    }
}
