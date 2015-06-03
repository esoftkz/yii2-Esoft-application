<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>

<?php	

$js =
   '$("document").ready(function(){ 
		$("body").on("click", ".delete_image", function(e) {
			e.preventDefault();
			if(confirm("Удалить изображение?")){
				var url = $(this).attr("href");
				$.ajax({
					url: url,
					data: "ajax=1",
					success: function(data) {					
						$.pjax.reload({container:"#images_grid"});  //Reload GridView
					}
				});
			}
		});	
		$("body").on("click", ".edit_image", function(e) {			
			$.pjax.click(e, {container: "#images_panel"});				
		});		
		
		$("body").on("click", ".crop_image", function(e) {	
			e.preventDefault();
			var url = $(this).attr("href");							
		});
		
		
	});
	';
$this->registerJs($js, $this::POS_READY);
?>


<?php Pjax::begin(['id' => 'images_panel']); ?>
	
	
	   
	
	<?php $form = ActiveForm::begin([
			'options'=>['enctype'=>'multipart/form-data'] // important
		]);
	?>		
		
	<?= $form->field($model, 'image[]')->widget(FileInput::classname(), [
			'options'=>[
				'accept'=>'image/*', 			 
				'data-show-upload'=>"false",
				'multiple' => true				
			],
			'pluginOptions'=>[
				'allowedFileExtensions'=>['jpg','png'],					
			]
		])->label('Добавить новые изображения');
	?>

	<div class="form-group">
		<?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
	</div>
	<?php ActiveForm::end(); ?>
	
	<? Url::remember();?>
	
	<?php Pjax::begin(['id' => 'images_grid']); ?>
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'summary' => 'Показано: {begin} - {end} из {totalCount}',
			'columns' => [	
				array(
					'label' => 'Изображение',						
					'format' => 'html',
					'value' => function($data) use ($model, $paper){				
						$path = Yii::$app->homeUrl.'../../common/modules/image/uploads/'.$data->image_class.'/'.$model->id.$paper.$data->name;
						$return=Html::img($path, ['class' => '', 'style' => 'width:100px; ']);
						return $return;	
					},
					'contentOptions' => ['style'=>'width: 100px;','class' => ''],					
				),
				'title',
				'position',		
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{edit_image}{delete_image}',						
					'buttons'=>[
						'delete_image'=>function ($url) {
							return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
								'title' => Yii::t('app', 'Удалить'),											
								'class' => 'delete_image',
								'data-pjax' => 0,
							]);
						},
						'edit_image'=>function ($url) {
							return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
								'title' => Yii::t('app', 'Редактировать'),											
								'class' => 'edit_image',
								'data-pjax' => 1,
							]);
						}
					],	
					'urlCreator' => function ($action, $data) {
						if ($action === 'delete_image') {
							$url =Url::toRoute(['/image/act/delete', 'id' => $data->id]); 
							return $url;
						}
						if ($action === 'edit_image') {					
							$url =Url::toRoute(['/image/act/image-edit', 'id' => $data->id]); 
							return $url;
						}
					}
				],
				
			],
		]); ?>
	<?php Pjax::end(); ?>
<?php Pjax::end(); ?>