<?php

namespace backend\controllers;

use Yii;
use common\models\Plans;
use common\modules\image\models\Image;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * PlansController implements the CRUD actions for Plans model.
 */
class PlansController extends Controller
{
	
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Plans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Plans::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Plans model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$params=array(
			'model' => $model,
			'page' => 'view',
			'title' => 'Планирова #'.$model->id,	
			
		);
        return $this->render('layout', [
            'params' => $params,			
        ]);
    }
	
	/**
     * Displays images.
     * @param integer $id
     * @return mixed
     */
    public function actionImages($id)
    {		
		$model=$this->findModel($id);
		$model->scenario = 'file_upload';
			
		if ($model->load(Yii::$app->request->post()) && $model->save()) {			
			Yii::$app->session->setFlash('success', 'Загрузка прошла успешно');
		}
		
		$dataProvider = new ActiveDataProvider([
            'query' => Image::find()->where('image_class="plans"')->andWhere('id_owner='.$model->id)->orderBy('position'),
        ]);	
		
		$params=array(
			'model' => $model,
			'page' => 'image',
			'image_class' => 'plans',
			'title' => 'Изображения',	
			'dataProvider' => $dataProvider,
		); 
        return $this->render('layout', [
            'params' => $params,			
        ]);
    }
	
	/**
     * Displays image edit panel.
     * @param integer $id
     * @return mixed
     */
    public function actionImageEdit($id)
    {
		
		$image = Image::find()
		->joinWith('cmsImageLangs')
		->joinWith(['cmsImageAccesses','cmsImageAccesses.idImageType'])
		->joinWith('cmsImageThumbnails')
		->where('id='.$id)
		->one();
		
		$model=$this->findModel($image->owner_id);
		
		
		
	
		
		$params=array(
			'model' => $model,
			'image' => $image,
			'page' => 'image-edit',			
			'title' => 'Редактирование',				
		); 
        return $this->render('layout', [
            'params' => $params,			
        ]);
    }

    /**
     * Creates a new Plans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Plans();
		$model->scenario = 'file_upload';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Plans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->scenario = 'file_upload';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Plans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Plans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plans::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
