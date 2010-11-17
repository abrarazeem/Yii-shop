<?php
$this->breadcrumbs = array(
    'Cart',
);


$this->menu = array(
    array('label' => 'Continue Shopping', 'url' => array('/products/index')),
    // array('label'=>'Pay','url'=>array('checkout')),
    array('label' => 'Update Cart', 'url' => array('cart/update')),
);

print_r(Yii::app()->session['cart']);
?>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value ="1">
<input type="hidden" name="business" value="abrars_1289160148_biz@yahoo.com">
<table width="100%">
    <thead>
        <tr>
            <td><b>Name</b></td>
            <td><b>Price</b></td>
            <td><b>Quantity</b></td>
            <td><b>Sub-total</b></td>
        </tr>
    </thead>
    <?php
    foreach (Yii::app()->session['cart'] as $id => $qty):
        $product = $this->findProduct($id);
    ?>

        <tr>
            <td><?php echo $product['title']; ?></td>
            <td><?php echo $product['price']; ?></td>
            <td><?php echo $qty; ?></td>
            <td><?php echo $product['price'] * $qty; ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php
$i=1;
foreach (Yii::app()->session['cart'] as $id => $qty):
    $product = $this->findProduct($id);

?>

<input type="hidden" name="item_name_<?php echo $i;?>" value="<?php echo $product['title'];?>">
<input type="hidden" name="item_number_<?php echo $i;?>" value="<?php echo $product['id'];?>">
<input type="hidden" name="amount_<?php echo $i;?>" value="<?php echo $product['price'];?>">
<input type="hidden" name="quantity_<?php echo $i;?>" value="<?php echo $qty;?>">


<?php
$i++;
endforeach;

?>



    

        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="rm" value="2">
        <input type="hidden" name="shipping_1" value="10">
        <input type="hidden" name="return" value="http://myapp.com/myshop/?r=cart/thanks">
        <input type="hidden" name="cancel_return" value="http://myapp.com/myshop/">
        <input type="hidden" name="notify_url" value="http://myapp.com/myshop/?r=cart/paypal">
        <input type="submit" name="PayPal" value="PayPal">
</form>
        <hr>
        <table width="100%">
            <tr>
                <td width="55%"><b>Total</b></td>
                <td width="20%"><?php echo $this->totalItems; ?></td>
                <td width="21%"><?php echo $this->totalPrice; ?></td>
    </tr>
</table>