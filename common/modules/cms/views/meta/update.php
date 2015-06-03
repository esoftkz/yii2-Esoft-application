<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CmsSeo */

$this->title = 'Редактирование Seo данных';
$this->params['breadcrumbs'][] = ['label' => 'Cms Seos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-seo-update">

  

    <div class="cms-seo-form">

		<?php $form = ActiveForm::begin(); ?>
		
		<?= $form->field($model, 'lang_id')->dropDownList($languages) ?>				

		<?= $form->field($model, 'meta_title')->textinput() ?>

		<?= $form->field($model, 'meta_keywords')->textinput() ?>

		<?= $form->field($model, 'meta_description')->textarea(['rows' => 3]) ?>
		
		<?= $form->field($model, 'url_rewrite')->textinput(['disabled' => $model->page->configurable]) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>
