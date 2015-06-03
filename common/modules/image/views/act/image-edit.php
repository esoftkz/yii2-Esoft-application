<?
use common\modules\image\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use yii\widgets\Pjax;

$this->title = 'Изменить медиафайл';

AppAsset::register($this);
?>

<?php Pjax::begin(['id' => 'images_panel']); ?>	
	
	
	
	<h3>Список доступных миниатюр изображения</h3>
		
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'summary' => 'Показано: {begin} - {end} из {totalCount}',
		'columns' => [	
			'idImageType.name',
			'idImageType.width',
			'idImageType.height',				
			array(
				'label' => 'Изображение',						
				'format' => 'html',
				'value' => function($data) use ($image){				
					$path = Yii::$app->homeUrl.'../../common/modules/image/uploads/'.$image->image_class.'/'.$image->id_owner.$data->idImageType->path.$image->name;
					return Html::img($path, ['class' => '', 'style' => 'width:100px; ']);							
				},
				'contentOptions' => ['style'=>'width: 100px;','class' => ''],					
			),
			array(
				'label' => 'Рамка',
				'attribute' => 'idImageType.main',				
				'format' => 'html',
				'value' => function($data) { 
					if($data->idImageType->relative!=1){							
						$image_path=Yii::getAlias('@web').'/css/images/icon_active.png';
						return Html::img($image_path, ['class' => '']);		
					}
					return '';
				},
				'contentOptions' => ['class' => 'status_icon'],						
			),			
			array( 
				'class' => 'yii\grid\ActionColumn',	
				'template' => '{edit}',
				'buttons'=>[
					'edit'=>function ($url, $model) use ($image) {
						$customurl= Url::toRoute(['/image/act/image-edit', 'id' => $image->id, 'image_type' => $model->idImageType->id ]);
						return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
												['title' => Yii::t('yii', 'Edit')]);
					}
				],

		   )	
		],
	]); ?>
	
	
	
	
	
	<?if($selected != 0){?>
		<div class="col-sm-12 cms_cont " style="float:none">
			<?= '<h2>'.$image_type->imageType->name.' ('.$image_type->imageType->width.'*'.$image_type->imageType->height.')'.'</h2>'?>
			
			<?php		
				if($image_type->imageType->relative!=1){
					
					$js =
					'
					$("document").ready(function(){	
						var xsize = '.$image_type->w.',
							ysize ='.$image_type->h.'; 
							
						$("#crop_target").Jcrop({     
						  aspectRatio: xsize / ysize,
						  setSelect: [ '.$image_type->x.', '.$image_type->y.', '.($image_type->w + $image_type->x).', '.($image_type->h + $image_type->y).' ],
						  onChange: showCoords,
						  boxWidth: $(".crop_image").width(), 
						});
					  });  
					';
					$this->registerJs($js, $this::POS_READY);			
					?>
					<div class="crop_image" >			
						<?php
						$path = Yii::$app->homeUrl.'../../common/modules/image/uploads/'.$image->image_class.'/'.$image->id_owner.'/'.$image->name;			
						?>	
						<?= Html::img($path, ['id'=>'crop_target']);?>			
					</div>
				
			<?}?>
			
			<?php $form = ActiveForm::begin([
				'action'=>Url::toRoute(['/image/act/image-edit', 'id' => $image->id, 'image_type' => $image_type->image_type_id])
			])?>		
				<?= $form->field($image, 'title')->textInput(['maxlength' => 255]); ?>
			
				<?if($image_type->imageType->relative!=1){?>
					<?= $form->field($image_type, 'x')->hiddenInput()->label(false)  ?>
					<?= $form->field($image_type, 'y')->hiddenInput()->label(false)  ?>
					<?= $form->field($image_type, 'w')->hiddenInput()->label(false) ?>
					<?= $form->field($image_type, 'h')->hiddenInput()->label(false)  ?>				
				<?}?>
			<div class="form-group">
				<?= Html::submitButton('Изменить миниатюру', ['class' => 'btn btn-primary']) ?>
			</div>
			
			<?php ActiveForm::end(); ?>	
		</div>
	<?}?>
<?php Pjax::end(); ?>