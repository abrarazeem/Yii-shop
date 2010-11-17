<?php
$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->title,
);


$this->menu=array(
	array('label'=>'List Products', 'url'=>array('index'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'Create Products', 'url'=>array('create'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'Update Products', 'url'=>array('update', 'id'=>$model->id),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'Delete Products', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'Manage Products', 'url'=>array('admin'),'visible'=>!Yii::app()->user->isGuest),
        array('label'=>'Add Category','url'=>array('/category/create'),'visible'=>!Yii::app()->user->isGuest),
        array('label'=>'Add to Cart','url'=>array('/cart/add','id'=>$model->id)),
        array('label'=>'View Cart','url'=>array('/cart/index')),
);


?>

<h1>Product <?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
             array('name'=>'image',
                 'htmlOptions'=>array('width'=>200),
                    'value'=>CHtml::image('images/'.$model->image,$model->id,array('width'=>200,'height'=>200)),
                    'type'=>'raw',
                    
                    ),
		'title',
		'description',
		'price',
		array('name'=>'category_id',
                    'value'=>  CHtml::encode($model->category->title),
                    ),
	),
)); ?>
