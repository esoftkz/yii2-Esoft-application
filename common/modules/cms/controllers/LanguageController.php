<?php
namespace common\modules\cms\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl; 

use common\modules\cms\models\Language;

class LanguageController extends Controller
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
        ];
    }

    /**
     * Lists all Language models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Language::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

   

    /**
     * Creates a new Language model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Language();			
        if ($model->load(Yii::$app->request->post())) {		
			if($model->validate()){	
				if($model->default==1){
					$model->deleteDefaultValue();
					$model->status=1;
				}
				$model->save();
				$model->checkIssetDefault();		
				
				return $this->redirect(['index']);
			}
        } 
		return $this->render('create', [
			'model' => $model,			
		]);
    }

    /**
     * Updates an existing Language model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);	
         if ($model->load(Yii::$app->request->post())) {
			if($model->validate()){
				if($model->default==1){
					$model->deleteDefaultValue();
					$model->status=1;
				}					
				$model->save();
				$model->checkIssetDefault();							
				return $this->redirect(['index']);
			}
        } 
		
		return $this->render('update', [
			'model' => $model			
		]);
    }

    /**
     * Deletes an existing Language model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);		
		if($model->delete()){	
			$model->checkIssetDefault();	
		}	
        return $this->redirect(['index']);
    }

    /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Language the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Language::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
