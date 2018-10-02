<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Risk_Profile`.
 */
class m180215_081726_create_Risk_Profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Risk_Profile', [
            'riskProID' => $this->primaryKey(),
            'riskProName' => $this->string(250),
            'riskTypeID' => $this->integer(2),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Risk_Profile');
    }
}
