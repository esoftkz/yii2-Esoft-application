<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\page\models\CmsPosts */

$this->title = 'Create Cms Posts';
$this->params['breadcrumbs'][] = ['label' => 'Cms Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-posts-create">

   

    <?= $this->render('_form', [
        'model' => $model,
		'languages' => $languages,
    ]) ?>

</div>
