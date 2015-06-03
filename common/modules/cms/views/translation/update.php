<?php
$this->title = 'Редактировать переводы';
?>


<div class="cont">
	<?= $this->render('_form', [
        'model' => $model,
		'languages'=>$languages,
		'categories'=>$categories
    ]) ?>
</div>