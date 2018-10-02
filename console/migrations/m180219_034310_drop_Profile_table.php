<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `Profile`.
 */
class m180219_034310_drop_Profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('Profile');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('Profile', [
            'id' => $this->primaryKey(),
        ]);
    }
}
