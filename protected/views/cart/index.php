<?php
$this->breadcrumbs=array(
	'Cart',
);


$this->menu=array(
    array('label'=>'Continue Shopping','url'=>array('/products/index')),
    array('label'=>'CheckOut','url'=>array('checkout')),
    array('label'=>'Update Cart','url'=>array('cart/update')),

);

print_r(Yii::app()->session['cart']);

?>
<?php echo CHtml::beginForm();?>
<table width="100%">
    <thead>
        <tr>
            <td><b>Name</b></td>
            <td><b>Price</b></td>
            <td><b>Quantity</b></td>
            <td><b>Sub-total</b></td>
        </tr>
    </thead>
<?php foreach (Yii::app()->session['cart'] as $id => $qty):
         $product = $this->findProduct($id);
        ?>
   
        <tr>
            <td><?php echo $product['title'];?></td>
            <td><?php echo $product['price'];?></td>
            <td><input type="text" value="<?php echo $qty;?>" maxlength="2" size="2" name="<?php echo $id;?>"/> </td>
            <td><?php echo $product['price'] *$qty;?></td>
        </tr>
<?php endforeach; ?>
</table>
<div class="row buttons">
   <?php echo CHtml::submitButton('Update cart'); ?>
</div>
<?php echo CHtml::endForm();?>
<hr>
<table width="100%">
    <tr>
        <td width="55%"><b>Total</b></td>
        <td width="20%"><?php echo $this->totalItems; ?></td>
        <td width="21%"><?php  echo $this->totalPrice; ?></td>
    </tr>
</table>