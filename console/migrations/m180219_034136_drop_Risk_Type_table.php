<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Risk_Type`.
 */
class m180219_034136_drop_Risk_Type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Risk_Type');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Risk_Type', [
            'id' => $this->primaryKey(),
        ]);
    }
}
