<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $user_id รหัสผู้ใช้งาน
 * @property string $firtname ชิ่อ
 * @property string $lastname นามสกุล
 * @property string $photo รูปภาพ
 * @property int $Team_teamID รหัสทีมหรือหน่วยงาน
 *
 * @property Team $teamTeam
 * @property User $user
 */
class Person extends \yii\db\ActiveRecord
{
    public $person_img;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'firtname', 'Team_teamID'], 'required'],
            [['user_id', 'Team_teamID'], 'integer'],
            [['firtname', 'lastname', 'photo'], 'string', 'max' => 100],
            [['user_id'], 'unique'],
            [['Team_teamID'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['Team_teamID' => 'teamID']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['person_img'],'file','skipOnEmpty' => true, 'on' => 'update','extensions' =>'jpg,png,gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'รหัสผู้ใช้งาน ',
            'firtname' => 'ชิ่อ ',
            'lastname' => 'นามสกุล ',
            //'photo' => 'รูปภาพ ',
            'Team_teamID' => 'ทีมหรือหน่วยงาน ',
            'person_img' => 'รูปภาพ ',
            'user.role' => 'สิทธิการเช้าใช้งาน'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamTeam()
    {
        return $this->hasOne(Team::className(), ['teamID' => 'Team_teamID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
