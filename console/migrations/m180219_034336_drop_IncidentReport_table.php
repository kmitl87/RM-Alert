<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `IncidentReport`.
 */
class m180219_034336_drop_IncidentReport_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('IncidentReport');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('IncidentReport', [
            'id' => $this->primaryKey(),
        ]);
    }
}
