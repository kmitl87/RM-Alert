<?php

namespace common\models;

use Yii;
use common\models\RiskProfile;

/**
 * This is the model class for table "risk_list".
 *
 * @property int $id
 * @property string $irID เลขที่ใบ IR
 * @property string $riskProID รหัสความเสี่ยง
 *
 * @property Incidentreport $ir
 * @property RiskProfile $riskPro
 */
class RiskList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'risk_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['irID', 'riskProID'], 'required'],
            [['irID'], 'string', 'max' => 10],
            [['riskProID'], 'string', 'max' => 4],
            [['irID'], 'exist', 'skipOnError' => true, 'targetClass' => Incidentreport::className(), 'targetAttribute' => ['irID' => 'irID']],
            [['riskProID'], 'exist', 'skipOnError' => true, 'targetClass' => RiskProfile::className(), 'targetAttribute' => ['riskProID' => 'riskProID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'irID' => 'เลขที่ใบ IR',
            'riskProID' => 'รหัสความเสี่ยง',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIr()
    {
        return $this->hasOne(Incidentreport::className(), ['irID' => 'irID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiskPro()
    {
        return $this->hasOne(RiskProfile::className(), ['riskProID' => 'riskProID']);
    }
}
