<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
	'defaultRoute' => 'main/default/index',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [            
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],	
		'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@frontend/modules/main/mail',		
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',				
				'host' => 'smtp.yandex.ru',
				'username' => 'info@bukharzhyrau.kz',
				'password' => '2481496mm',
				'port' => '25',
				'encryption' => 'tls',
			],
        ],		
    ],
    'params' => $params,
];
