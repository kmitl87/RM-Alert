<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "risk_profile".
 *
 * @property string $riskProID รหัสความเสี่ยง
 * @property string $riskProName รหัสความเสี่ยง
 * @property string $riskTypeID
 *
 * @property RiskList[] $riskLists
 * @property RiskType $riskType
 */
class RiskProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'risk_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['riskProID', 'riskTypeID'], 'required'],
            [['riskProID'], 'string', 'max' => 4],
            [['riskProName'], 'string', 'max' => 250],
            [['riskTypeID'], 'string', 'max' => 2],
            [['riskProID', 'riskTypeID'], 'unique', 'targetAttribute' => ['riskProID', 'riskTypeID']],
            [['riskTypeID'], 'exist', 'skipOnError' => true, 'targetClass' => RiskType::className(), 'targetAttribute' => ['riskTypeID' => 'riskTypeID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'riskProID' => 'รหัสความเสี่ยง',
            'riskProName' => 'รหัสความเสี่ยง',
            'riskTypeID' => 'Risk Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiskLists()
    {
        return $this->hasMany(RiskList::className(), ['riskProID' => 'riskProID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiskType()
    {
        return $this->hasOne(RiskType::className(), ['riskTypeID' => 'riskTypeID']);
    }
}
