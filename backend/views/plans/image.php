<?php
use common\modules\image\widgets\imagepanel\Imagepanel;

?>


<?= Imagepanel::widget([
	'model' => $model,
	'dataProvider' => $dataProvider,
	'image_class' => $image_class,
	'title' => $title,
]) ?>
