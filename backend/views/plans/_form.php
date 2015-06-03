<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Plans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plans-form">

     <?php $form = ActiveForm::begin([
			'options'=>['enctype'=>'multipart/form-data'] // important
		]);
	?>		

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
	
	<?= $form->field($model, 'image[]')->widget(FileInput::classname(), [
			'options'=>[
				'accept'=>'image/*', 			 
				'data-show-upload'=>"false",
				'multiple' => true				
			],
			'pluginOptions'=>[
				'allowedFileExtensions'=>['jpg','png'],					
			]
		]);
	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
