<?php
$this->breadcrumbs=array(
	'Categories',
);
if(!Yii::app()->user->isGuest)
{
$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
}
?>

<h1>Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
