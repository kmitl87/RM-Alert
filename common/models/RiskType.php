<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "risk_type".
 *
 * @property string $riskTypeID ประเภทความเสี่ยง
 * @property string $riskTypeName ประเภทความเสี่ยง
 *
 * @property RiskProfile[] $riskProfiles
 */
class RiskType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'risk_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['riskTypeID'], 'required'],
            [['riskTypeID'], 'string', 'max' => 2],
            [['riskTypeName'], 'string', 'max' => 250],
            [['riskTypeID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'riskTypeID' => 'ประเภทความเสี่ยง',
            'riskTypeName' => 'ประเภทความเสี่ยง',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiskProfiles()
    {
        return $this->hasMany(RiskProfile::className(), ['riskTypeID' => 'riskTypeID']);
    }
}
