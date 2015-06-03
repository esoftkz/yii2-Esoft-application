<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Переводы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cont">
	</br>
	
	<p>
        <?
			if(Yii::$app->user->can('admin')){
				echo Html::a('Новый перевод', ['create'], ['class' => 'btn btn-success']);
			}
		?>
    </p>

    <?= GridView::widget([	
		'summary' => 'Показано: {begin} - {end} из {totalCount}',	
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
		]);
	?>
    
    

    

</div>
