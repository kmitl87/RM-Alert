<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Sufferer`.
 */
class m180219_033333_drop_Sufferer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Sufferer');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Sufferer', [
            'id' => $this->primaryKey(),
        ]);
    }
}
