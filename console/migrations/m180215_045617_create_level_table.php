<?php

use yii\db\Migration;

/**
 * Handles the creation of table `level`.
 */
class m180215_045617_create_level_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('level', [
            'levelID' => $this->primaryKey(),
            'levelName' => $this->string(250),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('level');
    }
}
