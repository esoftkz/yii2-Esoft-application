<?php

namespace common\modules\image\controllers;

use Yii;
use yii\base;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl; 
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


use common\modules\image\models\Image;
use common\modules\image\models\ImageAccess;
use common\modules\image\models\ImageThumbnails;
use common\modules\image\models\ImageType;
use common\modules\image\models\UploadFile;


class ActController extends Controller
{
	public function behaviors()
    {
		return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [                  
                    [
                        'actions' => ['delete','image-edit','upload-file','all-images'],
                        'allow' => true,
                        'roles' => ['admin','moder'],
                    ],					
                ],
            ], 
					
        ];
	}
	
    /**
     * Deletes an existing CmsPosts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $lang_id
     * @return mixed
     */
    public function actionDelete($id)
    {
				
		Image::deleteById($id);
		Yii::$app->session->setFlash('success', 'Изображение успешно удалено');	
		if (!Yii::$app->getRequest()->isAjax) {
			return $this->redirect(Url::previous());
		}else{
			return true;
		}
    }
	
	public function actionImageEdit($id , $image_type = '')
    {
	
		//Получение типа редактируемой миниатюры, иначе получаем первую, которая пожходит				
		$sql = ImageThumbnails::find()->joinWith('imageType')->where('image_id='.$id)->orderBy('relative');
		if(isset($image_type) && !empty($image_type)){
			$sql = $sql->andWhere('cms_image_type.id = '.$image_type);
			$selected = $image_type;
		}else{
			$selected = 0;
		}
		$image_type= $sql->one();
			
		//Получение изображения
		$image = Image::find()		
		->where('cms_image.id='.$id)
		->one();
		
		if (($image->load(Yii::$app->request->post()) && $image->save())) {
			if (isset($image_type) && $image_type->load(Yii::$app->request->post()))
				$image_type->save();
			return $this->redirect(Url::previous());
		}

		//Получение списка доступных миниатюр
		$ImageAccesses = ImageAccess::find()
		->joinWith('idImageType')
		->where('class_image="'.$image->image_class.'"');
		
		//Получение всех изображений
		$dataProvider = new ActiveDataProvider([
            'query' => $ImageAccesses,
        ]);		
	
		

		$params=array(			
			'image' => $image,		
			'image_type' => $image_type,
			'dataProvider' => $dataProvider,
			'selected' => $selected,
		); 
			
		if (!Yii::$app->getRequest()->isAjax) {
			//Если не ajax - то ничего
		}
		return $this->render('image-edit', $params);
    }

	/**
     * Загрузка файла на сервер
     *
     * @access public   
     */
	public function actionUploadFile()
    {
		$model = New UploadFile;
		$model->file = UploadedFile::getInstanceByName('file');		
		$model->width = (int)Yii::$app->request->post('maxWidth');
		$model->height =  (int)Yii::$app->request->post('maxHeight');		
		$model->relative = (int)Yii::$app->request->post('relative' , 1);
		
		
		if ($model->validate()) {
			$data = $model->uploadFile();
			echo json_encode($data);
		}
		
    }
	
	/**
     * Получение списка изображение json форматом (для POST)
     *
     * @access public   
     */	
	public function actionAllImages()
    {
		$array = array();
		$array[] = array( 
			"image" => "/image1_200x150.jpg",
			"thumb" => "/image1_thumb.jpg",
			"folder" => "Small"
		);
       
		echo json_encode($array);
		
		
    }
	
}
