<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\modules\user\models\User;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
   
    
    <p>
        <?= Html::a('Новый пользователь', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
	
    <?= GridView::widget([
		'summary' => 'Показано: {begin} - {end} из {totalCount}',	
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email', 
			array(
				'label' => 'Тип пользователя',
				'attribute' => 'authassignment.itemName.description',
				'filter' => $roles
			),
			array(
				'label' => 'Статус',
				'attribute' => 'status',				
				'format' => 'html',
				'value' => function($data) { 
					if($data->status==1){
						$uploadPath=Yii::getAlias('@web');
						$image_path=$uploadPath.'/css/images/icon_active.png';					
						return '<img src="'.$image_path.'"/>';	
					}
					return '';
				},
				'contentOptions' => ['class' => 'status_icon'],	
				'filter' => array(1=>'Активно', 0=>'Не активно')
			),	                           
            ['class' => 'yii\grid\ActionColumn',
				'template'   => '{update}{delete}'
			],
        ],
    ]); ?>

</div>
