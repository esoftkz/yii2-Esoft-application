<?php
namespace common\modules\cms\controllers;

use Yii;
use yii\filters\AccessControl; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;


use common\modules\cms\models\Language;
use common\modules\cms\models\Message;
use common\modules\cms\models\Dictionary;
use common\modules\cms\models\search\Message_search;



use common\modules\cms\models\Page;


class TranslationController extends Controller
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

    
    public function actionIndex()
    {
			
        $searchModel = new Message_search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$columns=array();
		$columns[]=array(
			'label'=>'Страница',
			'attribute'=>'category.name',
			'value'=>function($data,$key){			
				$value=$data->category->name." (".$data->category_id.")";				
				return $value;
			});			
		if(Yii::$app->user->can('admin'))		
			$columns[]=array('attribute'=>'code');		
		
		$languages=Language::findAllActive();
		foreach($languages as $language){				
			$columns[]=array(
			'label'=>$language->name,
			'attribute'=>'message'.$language->id,
			'value'=>function($data,$key) use ($language){			
				$value=Message::Message($data->id,$language->id);				
				return $value;
			});	
		}
		$columns[]=array('class' => 'yii\grid\ActionColumn','template'   => '{update}{delete}');
		
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'columns'=> $columns,
        ]);
		
    }


    public function actionCreate()
    {
        $model = new Message();
        if ($model->load(Yii::$app->request->post()) ) {			
			if($model->save()){	
				foreach($model->translate as $key=>$str){
					$tranlate=new Dictionary;
					$tranlate->language_id=$key;
					$tranlate->message_id=$model->id;
					$tranlate->message=$str;
					$tranlate->save();			
				}				
				return $this->redirect(['index']);
			}
        } else {
			$languages=Language::findAllActive();	
			$categories=Page::find()->all();	
            return $this->render('create', [
                'model' => $model,
				'languages'=>$languages,
				'categories'=>$categories
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post())){
			if($model->save()) {
				foreach($model->translate as $key=>$str){
					$tranlate=Dictionary::findModel($id,$key);
					$tranlate->language_id=$key;
					$tranlate->message_id=$model->id;
					$tranlate->message=$str;
					$tranlate->save();			
				}					
				return $this->redirect(['index']);
			}
        } 
		$languages=Language::findAllActive();
		foreach($languages as $lang){
			$translate=Dictionary::findModel($id,$lang->id);
			if(isset($translate))
				$model->translate[$lang->id]=$translate->message;		
		}	
		$categories=Page::find()->all();		
		return $this->render('update', [
			'model' => $model,
			'languages'=>$languages,
			'categories'=>$categories
		]);
        
    }

     public function actionDelete($id)
    {
        $model=$this->findModel($id);
		$languages=Language::findAllActive();
		foreach($languages as $lang){
			$translate=Dictionary::findModel($id,$lang->id);
			if(isset($translate))
				$translate->delete();
		}	
		$model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the MessageRel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessageRel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}