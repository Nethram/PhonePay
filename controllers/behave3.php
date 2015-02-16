<?php

class Behave3 extends Controller{
    private $ivr_message;
    
    function __construct() {
        $this->ivr_message=(object) parse_ini_file('application/ivr_message.ini');
    }
    
    function index(){

        $data['ivr_ask_orderid']=$this->ivr_message->ask_orderid;
		$data['redirect']=Config::$base_url."/behave3/get_orderid.php";
		$this->loadView('twiml_ask_orderid',$data);        

    }

    function get_orderid(){
		$orderid=$_REQUEST['Digits'];
		$data['confirm']=implode(' ',str_split($orderid));
		$data['ivr_say_orderid']=$this->ivr_message->say_orderid;
		$data['ivr_orderid_confirm']=$this->ivr_message->orderid_confirm;
		$data['redirect'] = Config::$base_url."/behave3/confirm_orderid/$orderid.php";
		$this->loadView('twiml_confirm_orderid',$data);
		
	}
	
	
	function confirm_orderid(){
		$confirm=$_REQUEST['Digits'];
		if($confirm==1){
			$params=$this->urlPara();
			$order_id=$params[0];
			
			$this->loadModel('orders_model');
			$orders_model=new Orders_model();
			$this->loadModel('system_model');
			$system_model=new System_model();
			$this->loadModel('transactions');
			$transactions=new Transactions();
			$order['phone']=  user_in_filter($_REQUEST['From']);
		
			if($id=$orders_model->order_id_exist($order_id)){
				$order_exi=$orders_model->get_order($id);
				if($stripeid=$transactions->transactions_completed($id)){
					$go=Config::$base_url."/twiml/pay_confirmation.php";
					header('location:'.$go);
				}else{
					$data['amount']=$order_exi['amount'];
					$orders_model->update_order_data($id,$order['phone'],$order_exi['amount'],'unpaid');
					$txnid=$transactions->initiate($id);
					$data['redirect']=  Config::$base_url."/twiml/confirm_payment/".$txnid.".php";
			        	$data['ivr_amount']=  $this->ivr_message->amount;
			        	$data['amount_confirmation']= $this->ivr_message->amount_confirmation;
			        	$this->loadView('twiml_amount_confirm',$data);
				}
			}else{
				$go=Config::$base_url."/behave3/ask_amount/$order_id.php";
				header('location:'.$go);
			
			}
		}else{
			$go=Config::$base_url."/behave3.php";
			header('location:'.$go);
		}
	}
	
	
	
	function ask_amount(){
		$params=$this->urlPara();
		$order_id=$params[0];
		$data['ivr_ask_amount']=$this->ivr_message->ask_amount;
		$data['redirect']=Config::$base_url."/behave3/get_amount/$order_id.php";
		$this->loadView('twiml_ask_amount',$data);	
	}
	
	
	function get_amount(){
		$params=$this->urlPara();
		$order_id=$params[0];
		$amount=$_REQUEST['Digits'];
		$data['confirm']=implode(' ',str_split($amount));
		$data['ivr_say_amount']=$this->ivr_message->say_amount;
		$data['ivr_amount_confirm']=$this->ivr_message->amount_confirm;
		$data['redirect'] = Config::$base_url."/behave3/confirm_amount/$order_id/$amount.php";
		$this->loadView('twiml_confirm_amount',$data);
	}
	
	function confirm_amount(){
		$params=$this->urlPara();
		$order_id=$params[0];
		$amount=$params[1];
		
		$order['phone']=  user_in_filter($_REQUEST['From']);
		$order['order_id']=$order_id;
		$order['amount']=$amount;
		$confirm=$_REQUEST['Digits'];
		if($confirm==1){
			$this->loadModel('orders_model');
			$orders_model=new Orders_model();
			$this->loadModel('transactions');
			$transactions=new Transactions();
			$ord_id=$orders_model->create_phone_order($order);
				$txnid=$transactions->initiate($ord_id);
				$data['redirect']=  Config::$base_url."/twiml/confirm_payment/".$txnid.".php";
				$data['amount']=$amount;
		        $data['ivr_amount']=  $this->ivr_message->amount;
		        $data['amount_confirmation']= $this->ivr_message->amount_confirmation;
		        $this->loadView('twiml_amount_confirm',$data);
			
		}else{
			$go=Config::$base_url."/behave3/ask_amount/$order_id.php";
			header('location:'.$go);
		}
	}

    

    

//end of class    

}

