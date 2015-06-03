<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		
		
		
		
		
		//Rbac в модуле user
		'authManager' => [
            'class' => 'common\modules\cms\components\rbac\DbManager_ext',			
        ],
		'user' => [	
			'class' => 'yii\web\User',
            'identityClass' => 'common\modules\cms\models\User',
            'enableAutoLogin' => true,
			'loginUrl' => ['cms/user/login'],		
        ],
		'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,			
            'showScriptName' => false,
            'rules' => [	
				//common
                '' => 'main/default/index',							             				
                '<_a:error>' => 'main/default/<_a>',
                '<_a:(login|logout)>' => 'cms/user/<_a>',
			
				//frontend
				'contact' => 'main/contact/index',		
					
				//Common - url для модулей	
				'<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>' => '<_m>/default/index',				
            ],
        ],
		'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
		
		
    ],
];
