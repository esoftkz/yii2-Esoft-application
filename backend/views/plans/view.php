<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Планирова #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Планировки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Планирова #'.$model->id];



?>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'id',
		'name',
	],
]) ?>
