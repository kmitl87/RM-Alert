<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `RiskPreventive`.
 */
class m180219_034245_drop_RiskPreventive_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('RiskPreventive');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('RiskPreventive', [
            'id' => $this->primaryKey(),
        ]);
    }
}
