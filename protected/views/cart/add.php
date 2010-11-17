<?php
$this->breadcrumbs=array(
	'Cart'=>array('/cart'),
	'Add',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	<?php


        print_r( Yii::app()->session['cart']);
        echo "<br/><b>". $this->totalItems."</b>";
        echo "<br/><b>".$this->totalPrice."</b>";

        ?>
</p>
