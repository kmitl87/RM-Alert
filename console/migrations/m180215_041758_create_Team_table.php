<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Team`.
 */
class m180215_041758_create_Team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Team', [
            'teamID' => $this->primaryKey(),
            'teamName' => $this->string(150),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Team');
    }
}
