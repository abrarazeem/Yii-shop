<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
echo "Here to test that yii App Index.php file create Session variables for whole app or not!<br>";
echo Yii::app()->session['total_items'];
        ?>
    </body>
</html>
