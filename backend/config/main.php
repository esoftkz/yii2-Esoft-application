<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
	'name'=>'ESoft Cms',
	'defaultRoute' => 'main/default/index',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [             
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
		'view' => [
			 'theme' => [
				 'pathMap' => [
					'@app/views' => '@vendor/esoftkz/yii2-adminlte-asset/views/yii2-app'
				 ],
			 ],
		],
		
		
		
    ],
    'params' => $params,
];
