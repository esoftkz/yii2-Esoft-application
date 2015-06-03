<?php

namespace common\modules\cms\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

use common\modules\cms\models\LoginForm;
use common\modules\cms\models\User;
use common\modules\cms\models\search\User_search as UserSearch;
use common\modules\cms\models\AuthItem;

class UserController extends Controller
{

	
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
                        'actions' => ['index','create','update','delete'],
                        'allow' => true,  
						'roles' => ['admin', 'moder']
                    ],
                ],
				
            ],	
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
 
	
	 public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	
	
    
	public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	
	public function actionIndex()
    {
		$searchModel = new UserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$roles=AuthItem::find()->where('type=1')->asArray()->all();
		$roles=ArrayHelper::map($roles,'name','description');



		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'roles' => $roles,		
		]);
    }
	
	
	/**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
		if ($model->load(Yii::$app->request->post())) {			
            if ($model->signup()) {
                Yii::$app->getSession()->setFlash('success', 'Подтвердите ваш электронный адрес.');
                return $this->redirect(['user/index']);
            }
        }	
		$roles=AuthItem::find()->where('type=1')->all(); //список ролей
		$roles=ArrayHelper::map($roles,'name','description');	
		if(!Yii::$app->user->can('admin'))
			unset($roles['admin']);
		
        return $this->render('create', [
			'model' => $model,
			'roles' => $roles,
		]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		
        $model = $this->findModel($id);
		if(Yii::$app->user->can('admin') || User::getRoleById($id)!='admin')
			if ($model->load(Yii::$app->request->post())) {			
				if ($model->signup()) {					
					return $this->redirect(['user/index']);
				}
			}
			
		$model->roles=$model->authassignment->item_name;	//для отображения занчения roles в форме
		
        $roles=AuthItem::find()->where('type=1')->asArray()->all(); //список ролей
		$roles=ArrayHelper::map($roles,'name','description');
		if(!Yii::$app->user->can('admin'))
			unset($roles['admin']);
		
		
		
        return $this->render('create', [
			'model' => $model,
			'roles' => $roles,
		]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		
		if(Yii::$app->user->identity->id!=$id){
			if(Yii::$app->user->can('admin') || User::getRoleById($id)!='admin'){
				$model=$this->findModel($id);
				$model->authassignment->delete();
				$model->delete();
			}
		}
        return $this->redirect(['user/index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$model=User::find()->joinWith('authassignment')->where('id='.$id)->one();
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
	
	
	
	
	
}
