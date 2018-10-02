<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Infrom`.
 */
class m180219_034152_drop_Infrom_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Infrom');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Infrom', [
            'id' => $this->primaryKey(),
        ]);
    }
}
