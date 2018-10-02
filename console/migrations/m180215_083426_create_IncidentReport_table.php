<?php

use yii\db\Migration;

/**
 * Handles the creation of table `IncidentReport`.
 */
class m180215_083426_create_IncidentReport_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('IncidentReport', [
            'irID' => $this->primaryKey(),
            'riskDate' => $this->date(),
            'riskTime' => $this->time(),
            'userID' => $this->integer(5),
            'irDate' => $this->date(),
            'location' => $this->string(250),
            'sufID' => $this->integer(2),
            'HN' => $this->string(10),
            'AN' => $this->string(10),
            'staff' => $this->string(100),
            'position' => $this->string(100),
            'tel' => $this->string(10),
            'issue' => $this->text(),
            'repairable' => $this->text(),
            'infromID' => $this->integer(5),
            'infrom_remark' => $this->string(250),
            'levelID' => $this->integer(2),
            'recomment' => $this->text(),
            'user_update' => $this->integer(5),
            'ir_update' => $this->date(),
            'statusID' => $this->integer(2),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('IncidentReport');
    }
}
