<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sufferer".
 *
 * @property int $sufID ประเภทผู้ประสบภัย
 * @property string $sufName ประเภทผู้ประสบภัย
 *
 * @property Incidentreport[] $incidentreports
 */
class Sufferer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sufferer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sufID'], 'required'],
            [['sufID'], 'integer'],
            [['sufName'], 'string', 'max' => 45],
            [['sufID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sufID' => 'ประเภทผู้ประสบภัย',
            'sufName' => 'ประเภทผู้ประสบภัย',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidentreports()
    {
        return $this->hasMany(Incidentreport::className(), ['sufID' => 'sufID']);
    }
}
