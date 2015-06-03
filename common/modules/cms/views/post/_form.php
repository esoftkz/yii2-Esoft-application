<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use esoftkz\ckeditor\CKEditor;
?>

<div class="cms-posts-form">

    <?php $form = ActiveForm::begin([
		'options'=>['enctype'=>'multipart/form-data'],
		'enableClientValidation' => false	
	]);	?>	

		<?= $form->field($model, 'lang_id')->dropDownList($languages) ?>

		<?= $form->field($model, 'post_title')->textinput() ?>
		
		<?= $form->field($model, 'post_content')->widget(CKEditor::className(), [
			'options' => ['rows' => 6],
			'preset' => 'standart',
			'clientOptions' => [			
				'filebrowserUploadUrl' => Url::toRoute('/image/act/upload-file'),
				
			]
		])->label(false) ?>	 

		<?= $form->field($model, 'post_status')->dropDownList(['0' => 'Отключен', '1' => 'Активен']); ?>

		<?= $form->field($model, 'post_type')->textinput() ?>
		
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>
