<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\language\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="language-form">

    <?php $form = ActiveForm::begin();
	?>	

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'local')->textInput(['maxlength' => 16]) ?>

	
    <?= $form->field($model, 'default')->checkbox(['value' => 1, 'label' => 'Основной язык']) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'status')->dropDownList(['0' => 'Отключен', '1' => 'Активен']); ?>
	


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
