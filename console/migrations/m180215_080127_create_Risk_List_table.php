<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Risk_List`.
 */
class m180215_080127_create_Risk_List_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Risk_List', [
            'irID' => $this->integer(6),
            'riskProID' => $this->integer(4),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Risk_List');
    }
}
