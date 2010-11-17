<?php
$this->breadcrumbs = array(
    'Products',
);

$this->menu = array(
    array('label' => 'Create Products', 'url' => array('create'), 'visible' => !Yii::app()->user->isGuest),
    array('label' => 'Manage Products', 'url' => array('admin'), 'visible' => !Yii::app()->user->isGuest),
    array('label' => 'Products Categories', 'url' => array('/category/index')),
    array('label' => 'view Cart', 'url' => array('/cart/index')),
);
?>
<div>
    <h3>Cart</h3>
    <p>
        <?php
        if (Yii::app()->session['total_items']==0) {
            echo 'Your cart is Empty';
        } else {
            echo "<b>Total Items  " . Yii::app()->session['total_items'] . "</b>  &nbsp &nbsp &nbsp";
            echo "<b>Total Price  " . Yii::app()->session['total_price'] . "</b> &nbsp &nbsp &nbsp";
        }
        ?>
    </p>

</div>
<h1>Products</h1>

<?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
        )); ?>
