<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Team_List`.
 */
class m180219_034322_drop_Team_List_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Team_List');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Team_List', [
            'id' => $this->primaryKey(),
        ]);
    }
}
