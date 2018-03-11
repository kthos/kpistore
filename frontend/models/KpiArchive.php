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
            [['ref'], 'string', 'max' => 50],
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
    //...........
    const UPLOAD_FOLDER = 'kpiarchive';
    //...........
    public static function getUploadPath(){
         return Yii::getAlias('@webroot').'/'.self::UPLOAD_FOLDER.'/';
    }

    
    public static function getUploadUrl(){
        return Url::base(true).'/'.self::UPLOAD_FOLDER.'/';
    }
    
    
    public function initialPreview($data,$field,$type='file'){
        $initial = [];
        $files = Json::decode($data);
        if(is_array($files)){
             foreach ($files as $key => $value) {
                if($type=='file'){
                    $initial[] = "<div class='file-preview-other'><h2><i class='glyphicon glyphicon-file'></i></h2></div>";
                }elseif($type=='config'){
                    $initial[] = [
                        'caption'=> $value,
                        'width'  => '120px',
                        'url'    => Url::to(['/kpiarchive/deletefile','id'=>$this->id,'fileName'=>$key,'field'=>$field]),
                        'key'    => $key
                    ];
                }
                else{
                    $initial[] = Html::img(self::getUploadUrl().$this->ref.'/'.$value,['class'=>'file-preview-image', 'alt'=>$model->file_name, 'title'=>$model->file_name]);
                }
             }
        }
    return $initial;
    }
    
    
    public function listDownloadFiles($type){
        $docs_file = '';
         if(in_array($type, ['docs','covenant'])){
             $data = $type==='docs'?$this->docs:$this->covenant;
            $files = Json::decode($data);
            if(is_array($files)){
                $docs_file ='<ul>';
                foreach ($files as $key => $value) {
                    $docs_file .= '<li>'.Html::a($value,['/kpiarchive/download','id'=>$this->id,'file'=>$key,'file_name'=>$value]).'</li>';
                }
                $docs_file .='</ul>';
            }
        }
         return $docs_file;
    }

    
    public function actionDownload($id,$file,$file_name){
    $model = $this->findModel($id);
     if(!empty($model->ref) && !empty($model->covenant)){
            Yii::$app->response->sendFile($model->getUploadPath().'/'.$model->ref.'/'.$file,$file_name);
    }else{
        $this->redirect(['/kpi-archive/view','id'=>$id]);
    }
}
    

}
