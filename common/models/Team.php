<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $teamID ทีมหรือหน่วยงาน
 * @property string $teamName ทีมหรือหน่วยงาน
 *
 * @property Person $person
 * @property TeamList[] $teamLists
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teamID'], 'required'],
            [['teamID'], 'integer'],
            [['teamName'], 'string', 'max' => 150],
            [['teamID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'teamID' => 'ทีมหรือหน่วยงาน',
            'teamName' => 'ทีมหรือหน่วยงาน',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['Team_teamID' => 'teamID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamLists()
    {
        return $this->hasMany(TeamList::className(), ['teamID' => 'teamID']);
    }
}
