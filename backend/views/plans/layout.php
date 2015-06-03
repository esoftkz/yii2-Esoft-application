<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use esoftkz\adminlte\widgets\submenu\Submenu;

$model=$params['model'];
$items = [
	['label' => 'Информация', 'url' => '/plans/view', 'params' => ['id' => $model->id]],
	['label' => 'Изображения', 'url' => '/plans/images', 'params' => ['id' => $model->id]],
];

?>

<div class="col-sm-2  sidebar">
	<?= Submenu::widget(['items' => $items]) ?>
</div>
<div class="col-sm-10 cms_cont">				
	<?= $this->render($params['page'], $params) ?>	
</div>
<div style="clear:both"></div>
