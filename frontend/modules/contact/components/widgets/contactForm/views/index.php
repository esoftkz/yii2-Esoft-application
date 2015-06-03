<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Url;

?>
<div class="contact_form_cont">
	<? if(Yii::$app->session->hasFlash('contactFormSubmitted')){
		Alert::begin([
			'options' => [
				'class' => 'alert-success',
			],
		]);
		echo Yii::$app->session->getFlash('contactFormSubmitted');
		Alert::end();	
	}?>

	<?php $form = ActiveForm::begin(
	[
		'id' => 'top_contact-form'.$i, 
		'options' => ['class' => 'contact_from'],
		'action' => Url::toRoute(['/main/contact/index'])
	]); ?>
		
		<?= $form->field($model, '['.$i.']name')->textInput(['placeholder' => 'Введите имя'])->label(false) ?>
		<?= $form->field($model, '['.$i.']phone')->textInput(['placeholder' => 'Введите телефон'])->label(false) ?>
		<div class="form-group">
			<?= Html::submitButton('Оставить заявку', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
		</div>
		
	<?php ActiveForm::end(); ?>
</div>
