<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Risk_Type`.
 */
class m180215_042206_create_Risk_Type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Risk_Type', [
            'riskTypeID' => $this->primaryKey(),
            'riskTypeName' => $this->string(150),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Risk_Type');
    }
}
