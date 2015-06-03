<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\page\models\CmsPosts */

$this->title = 'Update Cms Posts: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cms Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'lang_id' => $model->lang_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-posts-update">

  

    <?= $this->render('_form', [
        'model' => $model,
		'languages' => $languages,
    ]) ?>

</div>
