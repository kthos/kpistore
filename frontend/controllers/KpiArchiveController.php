<?php

namespace frontend\controllers;

use Yii;
use frontend\models\KpiArchive;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//.....
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

use yii\filters\AccessControl;

/**
 * KpiArchiveController implements the CRUD actions for KpiArchive model.
 */
class KpiArchiveController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
    //----------กำหนดหารเข้าถึง--------//        
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update', 'delete','deletefile','download'],//action ทั้งหมดที่มี
                'rules' => [
                    [
                        'actions' => ['index','view','download','signup'],
                        'allow' => true,
                        'roles' => ['?'],//ยังไม่ log in ใช้งาน Action index,view,download,signup 
                    ],
                    [
                        'actions' => ['index','view','create','update', 'delete','deletefile','download','logout'],
                        'allow' => true,
                        'roles' => ['@'],//log in แล้ว ใช้งานActionทั้งหมดที่มี
                    ],
                ],
            ],
    //------------------------------//
        ];
    }

    /**
     * Lists all KpiArchive models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => KpiArchive::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KpiArchive model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new KpiArchive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KpiArchive();

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/
        //.............
        if ($model->load(Yii::$app->request->post()) ) {

            $this->CreateDir($model->ref);

            $model->covenant = $this->uploadSingleFile($model);
            $model->docs = $this->uploadMultipleFile($model);

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            $model->ref = substr(Yii::$app->getSecurity()->generateRandomString(),10);
        }
        //.............
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KpiArchive model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/
        //.............
        $tempCovenant = $model->covenant;
        $tempDocs     = $model->docs;
        if ($model->load(Yii::$app->request->post())) {
            $model->covenant = $this->uploadSingleFile($model,$tempCovenant);
            $model->docs = $this->uploadMultipleFile($model,$tempDocs);
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        //.............
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing KpiArchive model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        /*$model = $this->findModel($id);
        //remove upload file & data
        $this->removeUploadDir($model->ref);
        Uploads::deleteAll(['ref'=>$model->ref]);

        $model->delete();*/


        return $this->redirect(['index']);
    }

    /**
     * Finds the KpiArchive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KpiArchive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KpiArchive::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    
public function actionDeletefile($id,$field,$fileName){
        $status = ['success'=>false];
        if(in_array($field, ['docs','covenant'])){
            $model = $this->findModel($id);
            $files =  Json::decode($model->{$field});
            if(array_key_exists($fileName, $files)){
                if($this->deleteFile('file',$model->ref,$fileName)){
                    $status = ['success'=>true];
                    unset($files[$fileName]);
                    $model->{$field} = Json::encode($files);
                    $model->save();
                }
            }
        }
        echo json_encode($status);
}

private function deleteFile($type='file',$ref,$fileName){
        if(in_array($type, ['file','thumbnail'])){
            if($type==='file'){
               $filePath = KpiArchive::getUploadPath().$ref.'/'.$fileName;
            } else {
               $filePath = KpiArchive::getUploadPath().$ref.'/thumbnail/'.$fileName;
            }
            @unlink($filePath);
            return true;
        }
        else{
            return false;
        }
}    
    
    
private function uploadSingleFile($model,$tempFile=null){
        $file = [];
        $json = '';
        try {
             $UploadedFile = UploadedFile::getInstance($model,'covenant');
             if($UploadedFile !== null){
                 $oldFileName = $UploadedFile->basename.'.'.$UploadedFile->extension;
                 $newFileName = md5($UploadedFile->basename.time()).'.'.$UploadedFile->extension;
                 $UploadedFile->saveAs(KpiArchive::UPLOAD_FOLDER.'/'.$model->ref.'/'.$newFileName);
                 $file[$newFileName] = $oldFileName;
                 $json = Json::encode($file);
             }else{
                $json=$tempFile;
             }
        } catch (Exception $e) {
            $json=$tempFile;
        }
        return $json ;
}
    
private function uploadMultipleFile($model,$tempFile=null){
            $files = [];
            $json = '';
            $tempFile = Json::decode($tempFile);
            $UploadedFiles = UploadedFile::getInstances($model,'docs');
            if($UploadedFiles!==null){
               foreach ($UploadedFiles as $file) {
                   try {   $oldFileName = $file->basename.'.'.$file->extension;
                           $newFileName = md5($file->basename.time()).'.'.$file->extension;
                           $file->saveAs(KpiArchive::UPLOAD_FOLDER.'/'.$model->ref.'/'.$newFileName);
                           $files[$newFileName] = $oldFileName ;
                   } catch (Exception $e) {

                   }
               }
               $json = json::encode(ArrayHelper::merge($tempFile,$files));
            }else{
               $json = $tempFile;
            }
           return $json;
}
   
private function CreateDir($folderName){
    if($folderName != NULL){
        $basePath = KpiArchive::getUploadPath();
        if(BaseFileHelper::createDirectory($basePath.$folderName,0777)){
            BaseFileHelper::createDirectory($basePath.$folderName.'/thumbnail',0777);
        }
    }
    return;
}



private function removeUploadDir($dir){
        BaseFileHelper::removeDirectory(KpiArchive::getUploadPath().$dir);
}

//original code by dixonsatit     
public function actionDownload($id,$file,$file_name){
    $model = $this->findModel($id);
     if(!empty($model->ref) && !empty($model->covenant)){
            Yii::$app->response->sendFile($model->getUploadPath().'/'.$model->ref.'/'.$file,$file_name);
    }else{
        $this->redirect(['/kpi-archive/view','id'=>$id]);
    }
}


/****************************************************************/
//Edit by nont
public function actionPdfview($id,$file,$file_name){
    $model = $this->findModel($id);
     if(!empty($model->ref) && !empty($model->covenant)){
            //Yii::$app->response->sendFile($model->getUploadPath().'/'.$model->ref.'/'.$file);
            Yii::$app->response->redirect($model->getUploadUrl().$model->ref.'/'.$file);
    }else{
        $this->redirect(['/kpi-archive/view','id'=>$id]);
    }
}

/*public function actionPdfviewfile($id,$file,$file_name){
    $model = $this->findModel($id);
    $pdf = '';
     if(!empty($model->ref) && !empty($model->covenant)){
            //Yii::$app->response->sendFile($model->getUploadPath().'/'.$model->ref.'/'.$file);
         $pdf = $model->getUploadUrl().$model->ref.'/'.$file;  
         Yii::$app->response->redirect($pdf);
    }else{
        $this->redirect(['/kpi-archive/view','id'=>$id]);
    }
}*/

/****************************************************************/

}
