<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\Person;


/**
 * This is the model class for table "incidentreport".
 *
 * @property string $irID เลขที่ใบ IR
 * @property string $riskDate วันที่เกิดเหตุ
 * @property string $riskTime เวลาที่เกิดเหตุ
 * @property string $location สถานที่พบเหตุ
 * @property int $sufID ประเภทผู้ประสบภัย
 * @property string $HN เลขที่ HN 
 * @property string $AN เลขที่ AN
 * @property string $staff ชื่อผู้รายงาน
 * @property string $position ตำแหน่ง
 * @property string $tel เบอร์โทร
 * @property string $issue สาเหตุหรือปัญหาที่เกิด
 * @property string $detail รายละเอียด
 * @property string $repairable การแก้ไขเบื้องต้น
 * @property string $result ผลลัพธ์การแก้ไข
 * @property int $infromID ผู้บังคับบัญชา
 * @property int $levelID ระดับความรุนแรง
 * @property string $recomment ข้อเสนอแนะ
 * @property int $created_by ผู้เขียนใบ IR
 * @property int $updated_by ผู้แก้ไขใบ IR
 * @property string $created_at วันที่เขียนใบ IR
 * @property string $updated_at วันที่แก้ไขใบ IR
 * @property string $status สถานะใบ IR
 *
 * @property Infrom $infrom
 * @property Level $level
 * @property Sufferer $suf
 * @property RiskList[] $riskLists
 * @property TeamList[] $teamLists
 */
class Incidentreport extends \yii\db\ActiveRecord
{
    public $items;
    public $teams;
    public $text; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'incidentreport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['irID', 'riskDate', 'riskTime', 'location', 'sufID', 'issue', 'detail', 'infromID', 'levelID'], 'required'],
            [['riskDate', 'riskTime', 'created_at', 'updated_at'], 'safe'],
            [['sufID', 'infromID', 'levelID', 'created_by', 'updated_by'], 'integer'],
            [['detail', 'repairable', 'result', 'recomment', 'status'], 'string'],
            [['irID', 'HN', 'AN', 'tel'], 'string', 'max' => 10],
            [['location'], 'string', 'max' => 250],
            [['staff', 'position', 'issue'], 'string', 'max' => 100],
            [['irID'], 'unique'],
            [['infromID'], 'exist', 'skipOnError' => true, 'targetClass' => Infrom::className(), 'targetAttribute' => ['infromID' => 'infromID']],
            [['levelID'], 'exist', 'skipOnError' => true, 'targetClass' => Level::className(), 'targetAttribute' => ['levelID' => 'levelID']],
            [['sufID'], 'exist', 'skipOnError' => true, 'targetClass' => Sufferer::className(), 'targetAttribute' => ['sufID' => 'sufID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'irID' => 'เลขที่ใบ',
            'riskDate' => 'วันที่เกิดเหตุ* ',
            'riskTime' => 'เวลาที่เกิดเหตุ* ',
            'location' => 'สถานที่พบเหตุ* ',
            'sufID' => 'ประเภทผู้ประสบภัย* ',
            'HN' => 'HN: ',
            'AN' => 'AN: ',
            'staff' => 'ชื่อผู้รายงาน ',
            'position' => 'ตำแหน่ง ',
            'tel' => 'เบอร์โทร ',
            'issue' => 'สาเหตุหรือปัญหาที่เกิด* ',
            'detail' => 'รายละเอียด* ',
            'repairable' => 'การแก้ไขเบื้องต้น ',
            'result' => 'ผลลัพธ์การแก้ไข ',
            'infromID' => 'การรายงานผู้บังคับบัญชา* ',
            'levelID' => 'ระดับ* ',
            'recomment' => 'ข้อเสนอแนะ ',
            'created_by' => 'เขียนโดย ',
            'updated_by' => 'แก้ไขโดย ',
            'created_at' => 'เขียนเมื่อ ',
            'updated_at' => 'แก้ไขเมื่อ ',
            'status' => 'สถานะ',
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                //'createdAtAttribute' => 'create_time',
                //'updatedAtAttribute' => 'update_time',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                //'createdByAttribute' => 'author_id',
                //'updatedByAttribute' => 'updater_id',
            ],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfrom()
    {
        return $this->hasOne(Infrom::className(), ['infromID' => 'infromID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['levelID' => 'levelID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuf()
    {
        return $this->hasOne(Sufferer::className(), ['sufID' => 'sufID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiskLists()
    {
        return $this->hasMany(RiskList::className(), ['irID' => 'irID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamLists()
    {
        return $this->hasMany(TeamList::className(), ['irID' => 'irID']);
    }
    
    public static function getStatus($status = null){
        
        $arr = array (
            '0' => 'รอพิจารณา',
            '1' => 'พิจารณาแล้ว',
        );
        if(!empty($status) && !empty($arr[$status])){
            return $arr[$status];
        }
        return $arr;
    }
    
     public function getUserCreated() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUserUpdated() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
