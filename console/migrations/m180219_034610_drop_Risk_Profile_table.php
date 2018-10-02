<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Risk_Profile`.
 */
class m180219_034610_drop_Risk_Profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Risk_Profile');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Risk_Profile', [
            'id' => $this->primaryKey(),
        ]);
    }
}
