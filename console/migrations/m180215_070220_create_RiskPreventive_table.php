<?php

use yii\db\Migration;

/**
 * Handles the creation of table `RiskPreventive`.
 */
class m180215_070220_create_RiskPreventive_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('RiskPreventive', [
            'riskPreID' => $this->primaryKey(),
            'cause' => $this->text(),
            'prevent' => $this->text(),
            'schedule' => $this->date(),
            'repeatDate' => $this->date(),
            'irID' => $this->integer(6),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('RiskPreventive');
    }
}
