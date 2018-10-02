<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Risk_List`.
 */
class m180219_034257_drop_Risk_List_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Risk_List');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Risk_List', [
            'id' => $this->primaryKey(),
        ]);
    }
}
