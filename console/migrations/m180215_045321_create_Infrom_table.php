<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Infrom`.
 */
class m180215_045321_create_Infrom_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Infrom', [
            'infromID' => $this->primaryKey(),
            'infromName' => $this->string(150),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Infrom');
    }
}
