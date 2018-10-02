<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property int $levelID ระดับความรุนแรง
 * @property string $levelName ระดับความรุนแรง
 * @property string $levelDet รายละเอียดระดับความรุนแรง
 *
 * @property Incidentreport[] $incidentreports
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['levelID'], 'required'],
            [['levelID'], 'integer'],
            [['levelName'], 'string', 'max' => 2],
            [['levelDet'], 'string', 'max' => 250],
            [['levelID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'levelID' => 'ระดับความรุนแรง',
            'levelName' => 'ระดับความรุนแรง',
            'levelDet' => 'รายละเอียดระดับความรุนแรง',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidentreports()
    {
        return $this->hasMany(Incidentreport::className(), ['levelID' => 'levelID']);
    }
}
