<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\page\models\search\CmsPosts_search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cms Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-posts-index">

   

    <p>
        <?= Html::a('Create Cms Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'lang_id',
            'post_author',
          
            'post_title:ntext',
            // 'post_status',
            // 'date_created',
            // 'date_updated',
            // 'post_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
