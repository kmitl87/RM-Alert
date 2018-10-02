<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "infrom".
 *
 * @property int $infromID รหัสผู้บังคับบัญชา
 * @property string $infromName ชื่อผู้บังคับบัญชา
 *
 * @property Incidentreport[] $incidentreports
 */
class Infrom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'infrom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['infromID'], 'required'],
            [['infromID'], 'integer'],
            [['infromName'], 'string', 'max' => 250],
            [['infromID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'infromID' => 'รหัสผู้บังคับบัญชา',
            'infromName' => 'ชื่อผู้บังคับบัญชา',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidentreports()
    {
        return $this->hasMany(Incidentreport::className(), ['infromID' => 'infromID']);
    }
}
