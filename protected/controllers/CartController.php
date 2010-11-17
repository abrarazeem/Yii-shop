<?php

class CartController extends Controller
{
       public $pid = null;
       public $totalItems = 0;
       public $totalPrice = 0.00;
       private $paypal_email = "abrars_1287054873_biz@yahoo.com";
       private $paypal_currency = 'USD';
       private $shipping = 10;
      //local variables for paypal post data
    private $item_name;
    private $item_number;
    private $payment_status;
    private $payment_amount;
    private $payment_currency;
    private $txn_id;
    private $receiver_email;
    private $payer_email;
       

       public $layout='//layouts/column2';
    public function actionAdd()
	{
                     if(isset ($_GET['id']))
                    {
                        $id = $_GET['id'];

                    }

                   
                    if(!isset(Yii::app()->session['cart']))
                    {
                    Yii::app()->session['cart'] = array();
                    Yii::app()->session['total_items']=0;
                    Yii::app()->session['total_price']=0.00;
                    }
              $additem = $this->addtocart($id);
              Yii::app()->session['total_items']=$this->totalItems(Yii::app()->session['cart']);
              Yii::app()->session['total_price']=$this->totalPrice(Yii::app()->session['cart']);
              $this->totalItems = $this->totalItems(Yii::app()->session['cart']);
              $this->totalPrice = $this->totalPrice(Yii::app()->session['cart']);
        $this->render('add');


        }

        public function addtocart($id)
        {
            
            if(isset(Yii::app()->session['cart'][$id]))
            {
                $session = Yii::app()->session['cart'];
                $session[$id] = $session[$id]+=1;
                Yii::app()->session['cart']=$session;
                //Yii::app()->session['cart'][$id]++;
            }
            else
            {
                 $session = Yii::app()->session['cart'];
                 $session[$id] = 1;
                 Yii::app()->session['cart']=$session;
//                Yii::app()->session['cart'][$id]= 1;
            }
        }
        //count rhe total number of items in CART
        public function totalItems($cart)
        {
            $totalItems = 0;
         if(is_array($cart))
          {
            foreach ($cart as $id=>$qty)
            {
               $totalItems +=$qty;
            }
            return $totalItems;
          }
        }
        public function totalPrice($cart)
        {
            $netPrice = 0.00;
            if(is_array($cart))
            {
                foreach ($cart as $id=>$qty)
                {
                $sql = "Select price from products where id=:Id";
                $comand = Yii::app()->db->createCommand($sql);
                $comand->bindValue(":Id",$id,  PDO::PARAM_INT);
//                $datareader = $comand->query();
                $itemPrice = $comand->queryRow();
                 $netPrice +=  $itemPrice['price'] * $qty;
                 //$netPrice +=  $itemPrice * $qty;
      
                }
                return $netPrice;
            }

        }

        public function findProduct($id)
        {
            $sql = "select * from products WHERE id=:Id";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":Id",$id,  PDO::PARAM_INT);
            $row =  $command->queryRow();
            return $row;
        }

        public function actionIndex()
	{
            $this->updateCart();
            
               Yii::app()->session['total_items']=$this->totalItems(Yii::app()->session['cart']);
              Yii::app()->session['total_price']=$this->totalPrice(Yii::app()->session['cart']);
            $this->totalItems = $this->totalItems(Yii::app()->session['cart']);
            $this->totalPrice = $this->totalPrice(Yii::app()->session['cart']);
		$this->render('index');
	}

        public function actionCheckout()
        {
                 Yii::app()->session['total_items']=$this->totalItems(Yii::app()->session['cart']);
              Yii::app()->session['total_price']=$this->totalPrice(Yii::app()->session['cart']);
            $this->totalItems = $this->totalItems(Yii::app()->session['cart']);
            $this->totalPrice = $this->totalPrice(Yii::app()->session['cart']);
            $this->render("checkout");

        }


        public function updateCart()
       {
           foreach (Yii::app()->session['cart'] as $id => $qty)
          {
               if(isset($_POST[$id]))
               {
               if($_POST[$id]=='0')
               {
               $session = Yii::app()->session['cart'];
               unset ( $session[$id]) ;
               Yii::app()->session['cart'] =$session;
               }
               else
               {
                   $cart = Yii::app()->session['cart'];
                   $cart[$id]=$_POST[$id];
                   Yii::app()->session['cart']=$cart;
               }
               }
           }


       }
	public function actionUpdate()
	{
            $this->updateCart();
            $this->totalItems = $this->totalItems(Yii::app()->session['cart']);
            $this->totalPrice = $this->totalPrice(Yii::app()->session['cart']);
                 Yii::app()->session['total_items']=$this->totalItems(Yii::app()->session['cart']);
              Yii::app()->session['total_price']=$this->totalPrice(Yii::app()->session['cart']);
            $this->render('update');
	}
        
        public function actionPaypal()
        {

            $req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

// post back to PayPal system to validate
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
        $item_name = $_POST['item_name_'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];

        if (!$fp) {
// HTTP ERROR
        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                if (strcmp($res, "VERIFIED") == 0) {
                       // check the payment_status is Completed
                       if ($_POST['payment_status'] == 'Completed'
                               && $this->no_paypal_trans_id($_POST['txn_id'])
                               && $this->paypal_email==$_POST['receiver_email']
                               && $this->paypal_currency==$_POST['mc_currency']
                               && $this->payment_amount_correct($shipping, $_POST))
                      {
                           $this->createOrders($_POST);

                              
                           
                       }
                      
                    
                    // check that payment_amount/payment_currency are correct
                    // process payment
                } else if (strcmp($res, "INVALID") == 0) {
                // log for manual investigation
                }
            }
            fclose($fp);
        }

        $this->render("paypal");
        }

        public function no_paypal_trans_id($trans_id) {
                $sql = "SELECT id from products WHERE paypal_trans_id=:transId";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue("trans_Id",$trans_id,  PDO::PARAM_INT);
                $command->execute()==0? TRUE:FALSE;

        }
        public function payment_amount_correct($shipping,$params)
        {
            $amount = 0.00;
            for ($i = 1; $i<=$params['num_cart_items']; $i++) {
                $sql = "SELECT price from products where id=:ID ";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue("ID",$params["item_number{$i}"]);
                       $row =  $command->queryRow();
                       if ($row) {
                           $item_price = $row;
                           $amount = $item_price * $params["quantity{$i}"];
                       }
            }
            if (($amount + $shipping) == $params['mc_gross']) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function createOrders($params)
    {
        $sql = "INSERT into orders(firstname,lastname,email,country,address,city,zip_code,state,status,amount,paypal_trans_id,created_at)
            VALUES(:firstname,:lastname,:email,:country,:address,:city,:zip,:state,:status,:amount,:paypal_trans_id,:created_at)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":firstname",$params['first_name'],  PDO::PARAM_STR);
        $command->bindValue(":lastname",$params['last_name'],  PDO::PARAM_STR);
        $command->bindValue(":email",$params['payer_email'],  PDO::PARAM_STR);
        $command->bindValue(":country",$params['address_country'],  PDO::PARAM_STR);
        $command->bindValue(":address",$params['address_street'],  PDO::PARAM_STR);
        $command->bindValue(":city",$params['address_city'],  PDO::PARAM_STR);
        $command->bindValue(":zip",$params['addess_zip'],  PDO::PARAM_STR);
        $command->bindValue(":state",$params['address_state'],  PDO::PARAM_STR);
        $command->bindValue(":status",$params['payment_status'],  PDO::PARAM_STR);
        $command->bindValue(":amount",$params['mc_gross'],  PDO::PARAM_INT);
        $command->bindValue(":paypal_trans_id",$params['txn_id'],  PDO::PARAM_STR);
        $command->bindValue(":created_at",now(),  PDO::PARAM_STR);
        return $command->execute()== 1? TRUE:FALSE;

        $order_id = mysql_insert_id();

        for ($i = 1; $i <=$params['num_cart_items']; $i++)
        {
                $product = $this->findProduct($params["item_number{$i}"]);
                $sql2 = "INSERT into items (product_id,order_id,title,price,qty) VALUES(:productID,:orderID,:title,:price,:qty)";
                $command2 = Yii::app()->db->createCommand($sql2);
                $command2->bindValue(":productID",$product['id'],  PDO::PARAM_INT);
                $command2->bindValue(":orderID",$order_id,  PDO::PARAM_INT);
                $command2->bindValue(":title",$product['price'],  PDO::PARAM_STR);
                $command2->bindValue(":price",$params["quantity{$i}"],  PDO::PARAM_INT);
                return $command2->execute()==1? TRUE:FALSE;
        }


        return TRUE;

    }
    function actionThanks()
    {
        $this->render("thanks");

    }

    // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}