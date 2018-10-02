<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Team_List`.
 */
class m180215_082203_create_Team_List_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Team_List', [
            'irID' => $this->primaryKey(),
            'teamID' => $this->integer(5),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Team_List');
    }
}
