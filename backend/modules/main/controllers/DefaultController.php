<?php

namespace app\modules\main\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
					[
                        'allow' => true,
                        'actions'=>['error'],                      
                    ],
                    [
						'actions'=>['index'],
                        'allow' => true,                      
                        'roles' => ['admin','moder'],
                    ],                   
                ],
            ],
		];
	}
	
	public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
	
    public function actionIndex()
    {
        return $this->render('index');
    }
}
