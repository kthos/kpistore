<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kpi_archive".
 *
 * @property int $id
 * @property string $ref หลายเลข referent สำหรับอัพโหลดไฟล์ ajax
 * @property string $title ชื่องาน
 * @property string $description รายละเอียด
 * @property string $covenant หนังสือสัญญา
 * @property string $docs เอกสารประกอบ
 * @property string $start_date วันที่เริ่มสัญญา
 * @property string $end_date วันที่สิ้นสุดสัญญา
 * @property string $success_date งานเสร็จวันที่
 * @property string $create_date สร้างวันที่
 */
class KpiArchive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kpi_archive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /*return [
            [['description', 'docs'], 'string'],
            [['start_date', 'end_date', 'success_date', 'create_date'], 'safe'],
            [['ref'], 'string', 'max' => 50],
            [['title', 'covenant'], 'string', 'max' => 255],
        ];*/
        
        return [
            [['title'],'required'],
            [['description'], 'string'],
            [['start_date', 'end_date', 'succes_date', 'create_date'], 'safe'],
            [['ref'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255],
            [['covenant'],'file','maxFiles'=>1], //<---
            [['docs'],'file','maxFiles'=>10] //<---
        ];
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref' => 'หลายเลข referent สำหรับอัพโหลดไฟล์ ajax',
            'title' => 'ชื่อตัวชี้วัด',
            'description' => 'รายละเอียด',
            'covenant' => 'template ตัวชี้วัด',
            'docs' => 'เอกสารผลงานตัวชี้วัด',
            'start_date' => 'วันที่เริ่มตัวชี้วัด',
            'end_date' => 'วันที่สิ้นสุดตัวชี้วัด',
            'success_date' => 'ตัวชี้วัดเสร็จวันที่',
            'create_date' => 'สร้างวันที่',
        ];
    }

    /**
     * @inheritdoc
     * @return KpiArchiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KpiArchiveQuery(get_called_class());
    }
}
