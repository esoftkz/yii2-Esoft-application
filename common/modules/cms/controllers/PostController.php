<?php

namespace common\modules\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl; 
use yii\helpers\ArrayHelper;

use common\modules\cms\models\CmsPosts;
use common\modules\cms\models\search\CmsPosts_search;
use common\modules\cms\models\Language;

class PostController extends Controller
{
	public function behaviors()
    {
		return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [                  
                    [
                        'actions' => ['index','delete','create','update'],
                        'allow' => true,
                        'roles' => ['admin','moder'],
                    ],					
                ],
            ], 
			'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],			
        ];
	}
	
    /**
     * Lists all CmsPosts models.
     * @return mixed
     */
    public function actionIndex()
    {
		
        $searchModel = new CmsPosts_search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/**
     * Creates a new CmsPosts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsPosts();
		

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {		
			$model->save();
			
			
			
            return $this->redirect(['index']);
        }
		
		
		$languages=ArrayHelper::map(Language::find()->orderBy('default DESC')->all(),'id','name');
		return $this->render('create', [
			'model' => $model,
			'languages' => $languages,
		]);
        
    }

    /**
     * Updates an existing CmsPosts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $lang_id
     * @return mixed
     */
    public function actionUpdate($id, $lang_id)
    {
        $model = $this->findModel($id, $lang_id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {		
			$model->save();
            return $this->redirect(['index']);
        }
		
		$languages=ArrayHelper::map(Language::find()->orderBy('default DESC')->all(),'id','name');
		return $this->render('create', [
			'model' => $model,
			'languages' => $languages,
		]);
    }

    /**
     * Deletes an existing CmsPosts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $lang_id
     * @return mixed
     */
    public function actionDelete($id, $lang_id)
    {
        $this->findModel($id, $lang_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsPosts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $lang_id
     * @return CmsPosts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $lang_id)
    {
        if (($model = CmsPosts::findOne(['id' => $id, 'lang_id' => $lang_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
