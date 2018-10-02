<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "team_list".
 *
 * @property int $id
 * @property string $irID เลขที่ใบ IR
 * @property int $teamID ทีมหรือหน่วยงาน
 *
 * @property Incidentreport $ir
 * @property Team $team
 */
class TeamList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['irID', 'teamID'], 'required'],
            [['teamID'], 'integer'],
            [['irID'], 'string', 'max' => 10],
            [['irID'], 'exist', 'skipOnError' => true, 'targetClass' => Incidentreport::className(), 'targetAttribute' => ['irID' => 'irID']],
            [['teamID'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['teamID' => 'teamID']],
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
            'teamID' => 'ทีมหรือหน่วยงาน',
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
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['teamID' => 'teamID']);
    }
}
