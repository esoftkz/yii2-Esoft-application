<?php
$this->title = 'Создание нового перевода';
?>


<div class="cont">
	<?= $this->render('_form', [
        'model' => $model,
		'languages'=>$languages,
		'categories'=>$categories
    ]) ?>
</div>