<?php

namespace common\modules\cms\controllers;

use Yii;
use yii\filters\AccessControl; 
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\modules\cms\models\CmsMeta;
use common\modules\cms\models\Page;
use common\modules\cms\models\search\CmsMeta_search;
use common\modules\cms\models\Language;

/**
 * MetaController implements the CRUD actions for CmsMeta model.
 */
class MetaController extends Controller
{
    public function behaviors()
    {
		 return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [                  
                    [
                        'actions' => ['index','delete','update'],
                        'allow' => true,
                        'roles' => ['admin','moder'],
                    ],	
					 [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['admin'],
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
     * Lists all CmsMeta models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		
	
		$searchModel = new CmsMeta_search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$languages=ArrayHelper::map(Language::find()->orderBy('default DESC')->all(),'id','name');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'languages' => $languages,
        ]);
	
	
        

      
    }

    

    /**
     * Creates a new CmsMeta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsMeta();
		$page = new Page();

        if ($model->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post())) {
			if($model->validate() && $page->validate()){
				if($page->save()){
					$model->page_id=$page->id;
					$model->save();
				}
				return $this->redirect(['index']);
			}     
        } 
		$languages = ArrayHelper::map(Language::find()->orderBy('default DESC')->all(),'id','name');
		$pages = ArrayHelper::map(Page::find()->all(),'id','name');
		return $this->render('create', [
			'model' => $model,
			'page' => $page,
			'languages' => $languages,
			'pages' => $pages,
		]);
        
    }

    /**
     * Updates an existing CmsMeta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $lang_id
     * @param integer $page_id
     * @return mixed
     */
    public function actionUpdate($lang_id, $page_id)
    {
        $model = $this->findModel($lang_id, $page_id);
		$lang_id=$model->lang_id;
		
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if($lang_id==$model->lang_id){
				$model->save();
			}else{
				$clone = new CmsMeta();
				$clone->attributes = $model->attributes;
				$clone->save();				
			}
							 
            return $this->redirect(['index']);
        }
		$languages=ArrayHelper::map(Language::find()->orderBy('default DESC')->all(),'id','name');
		return $this->render('update', [
			'model' => $model,			
			'languages' => $languages,
		]);
        
    }

    /**
     * Deletes an existing CmsMeta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $lang_id
     * @param integer $page_id
     * @return mixed
     */
    public function actionDelete($lang_id, $page_id)
    {
        $this->findModel($lang_id, $page_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsMeta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $lang_id
     * @param integer $page_id
     * @return CmsMeta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($lang_id, $page_id)
    {
        if (($model = CmsMeta::find()->joinWith('page')->where(['lang_id' => $lang_id, 'page_id' => $page_id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
