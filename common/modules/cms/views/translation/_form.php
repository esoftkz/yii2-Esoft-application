<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>



<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name'))  ?>
	
	<?= $form->field($model, 'code')->textInput(['maxlength' => 32]) ?>		
	<?
		foreach($languages as $language){			
			echo $form->field($model, 'translate['.$language->id.']')->textArea()->label($language->name);
		}
	?>
	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>
<?php ActiveForm::end(); ?>