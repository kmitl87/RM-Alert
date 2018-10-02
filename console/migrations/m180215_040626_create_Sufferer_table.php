<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Sufferer`.
 */
class m180215_040626_create_Sufferer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Sufferer', [
            'sufID' => $this->primaryKey(),
            'sufname' => $this->string(30),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Sufferer');
    }
}
