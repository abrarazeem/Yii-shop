<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'Update Category', 'url'=>array('update', 'id'=>$model->id),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'Manage Category', 'url'=>array('admin'),'visible'=>!Yii::app()->user->isGuest),
);
?>

<h1>View Category <?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
	),
)); ?>

<h2>Products</h2>
<?php
$this->widget('zii.widgets.CListView',array(
    'dataProvider'=>$productDataProvider,
    'itemView'=>'/products/_view',

));


?>
