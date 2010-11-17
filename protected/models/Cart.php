<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Cart extends CModel
{
    public $cart = array();
    public $qty;
    public  function init()
    {
        $session = new CHttpSession;
        $session->open();
         
         
    }
  


    


}


?>
