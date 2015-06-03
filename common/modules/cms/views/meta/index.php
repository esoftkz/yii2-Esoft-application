<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seo конфигурация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-seo-index">

    

	<p>
        <?
			if(Yii::$app->user->can('admin')){
				echo Html::a('Новое описание страницы', ['create'], ['class' => 'btn btn-success']);
			}
		?>
    </p>
	<?= $this->render('_search', ['model' => $searchModel, 'languages' => $languages]); ?>
	
    <?= GridView::widget([
		'summary' => 'Показано: {begin} - {end} из {totalCount}',	
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'page_id',
			array('label'=>'Название страницы','attribute'=>'page.name'),
            'meta_title:ntext',         
			'url_rewrite',	
			['class' => 'yii\grid\ActionColumn',
				'template'   => '{update}'
			],
        ],
    ]); ?>

</div>
