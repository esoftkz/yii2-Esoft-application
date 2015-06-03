<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\language\Language */

$this->title = 'Новый язык';
$this->params['breadcrumbs'][] = ['label' => 'Languages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-create">


    <?= $this->render('_form', [
        'model' => $model,		
    ]) ?>

</div>
