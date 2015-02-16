<?php
class Orders extends Controller{
    function index(){}
    
    function new_order(){
        $response['status']=FALSE;
        $order_id=  user_in_filter($_POST['order_id']);
        $amount=  user_in_filter($_POST['amount']);
        if($order_id && $amount){
            $this->loadModel('orders_model');
            $orders_model=new Orders_model();
            if($orders_model->order_id_exist($order_id)){
                 $response['message']='Duplicate Order ID';
            }  else {
                $orders_model->new_order($order_id, $amount);
                $response['status']=TRUE;
                $response['message']='Order created';
            }
        }  else {
            $response['message']='Fill all required fields';
        }
        echo json_encode($response);
    }
    
    
    
    function view_orders(){
        $this->loadModel('orders_model');		$this->loadModel('transactions');		$this->loadModel('system_model');		$system_model=new System_model();		$bahavoir=$system_model->get_bahavior();		$txns=new Transactions(); 
        $om=new Orders_model();
        $draw=user_in_filter($_REQUEST['draw']);
        $start=user_in_filter($_REQUEST['start']);
        $length=user_in_filter($_REQUEST['length']);
        $search=user_in_filter($_REQUEST['search']['value']);
        $orderby=  user_in_filter($_REQUEST['order'][0]['column']);
        $orderval=  user_in_filter($_REQUEST['order'][0]['dir']);
        $count=$om->total_orders();
        $contact_list=$om->list_orders($start,$length,$orderby,$orderval,$search);
        $data['draw']=$draw;
        $data['recordsTotal']=$count;
        $data['recordsFiltered']=$count;
        $n=0;
        if(!$contact_list){
            $data['sEcho']=0;
        }
        foreach ($contact_list as $value) {
            $phone="Nil";
            $order_id="Nil";
            if($value['phone']!=0){ $phone=$value['phone'];}
            if($value['order_id']){ $order_id=$value['order_id'];}			$refundbutton="";				if($stripeid=$txns->transactions_completed($value['id'])){					if(!$txns->transactions_refunded($value['id'])){						$refundbutton="<button  class='btn btn-warning' onclick='refund(\"".$stripeid."\")'>Refund</button>";						}				}						if($bahavoir['order_id']=='enabled'){								$data['data'][$n][0]=$n+1;				$data['data'][$n][1]=gmdate("Y-m-d H:i:s",$value['timestamp']);	            $data['data'][$n][2]=$order_id;		            $data['data'][$n][3]=$phone."<br><input class='hidden' type='text' id='phone_".$n."' value='".$value['phone']."'>";		            $data['data'][$n][4]=$value['amount']."<br><input class='hidden' type='text' id='amount_".$n."' value='".$value['amount']."'>";		            $data['data'][$n][5]=ucfirst($value['status'])."<br><select class='hidden' id='status_".$n."'><option value='unpaid'>Unpaid</option><option value='paid'>Paid</option><option value='cancelled'>Cancelled</option></select>";		            $data['data'][$n][6]="<button id='savebtn_".$n."' onclick=\"save_item(".$n.",".$value['id'].")\" class=\"btn btn-default hidden\"><i class=\"fa fa-save fa-fw\"></i>Save</button><div id='btn_".$n."' class=\"btn-group btn-group-sm\">"		                    . "<button onclick=\"update_item(".$n.")\" class=\"btn btn-default\"><i class=\"fa fa-edit fa-fw\"></i>Update</button>"						. "<button onclick=\"details_item(".$value['id'].")\" class=\"btn btn-default\"><i class=\"fa fa-align-justify fa-fw\"></i>Details</button>"	                    . "<button onclick=\"delete_item(".$value['id'].")\" class=\"btn btn-default\"><i class=\"fa fa-trash fa-fw \"></i>Delete</button>"		                    . $refundbutton."</div>";		            $n++;							}else{				$data['data'][$n][0]=$n+1;				$data['data'][$n][1]=gmdate("Y-m-d H:i:s",$value['timestamp']);				$data['data'][$n][2]=$phone."<br><input class='hidden' type='text' id='phone_".$n."' value='".$value['phone']."'>";		            $data['data'][$n][3]=$value['amount']."<br><input class='hidden' type='text' id='amount_".$n."' value='".$value['amount']."'>";		            $data['data'][$n][4]=ucfirst($value['status'])."<br><select class='hidden' id='status_".$n."'><option value='unpaid'>Unpaid</option><option value='paid'>Paid</option><option value='cancelled'>Cancelled</option></select>";		            $data['data'][$n][5]="<button id='savebtn_".$n."' onclick=\"save_item(".$n.",".$value['id'].")\" class=\"btn btn-default hidden\"><i class=\"fa fa-save fa-fw\"></i>Save</button><div id='btn_".$n."' class=\"btn-group btn-group-sm\">"		                    . "<button onclick=\"update_item(".$n.")\" class=\"btn btn-default\"><i class=\"fa fa-edit fa-fw\"></i>Update</button>"	                    . "<button onclick=\"details_item(".$value['id'].")\" class=\"btn btn-default\"><i class=\"fa fa-align-justify fa-fw\"></i>Details</button>"	                    . "<button onclick=\"delete_item(".$value['id'].")\" class=\"btn btn-default\"><i class=\"fa fa-trash fa-fw \"></i>Delete</button>"	                    .$refundbutton. "</div>";		            $n++;			}
            
        }
        echo json_encode($data);
    }
    
    
    function update_order(){
        $response['status']=FALSE;
        $id=  user_in_filter($_POST['id']);
        $amount=  user_in_filter($_POST['amount']);
        $phone=user_in_filter($_POST['phone']);
        $status=user_in_filter($_POST['status']);
        $this->loadModel('orders_model');		$this->loadModel('transactions');		$txns=new Transactions();
        $om=new Orders_model();
        $om->update_order_data($id, $phone, $amount, $status);		$notes='{"Manual":"Manually changed to '.$status.'"}';		$txns->manual_update('updated',$notes,$id);
        $response['status']=TRUE;
        $response['message']="Order Updated.";
        echo json_encode($response);
    }
    
    function delete_order(){
        $id=  user_in_filter($_POST['id']);
        $this->loadModel('orders_model');		$this->loadModel('transactions');
        $om=new Orders_model();		$txn=new Transactions();
        $om->delete_order($id);		$txn->delete_transactions($id);
        $response['status']=TRUE;
        $response['message']="Order Deleted.";
        echo json_encode($response);
    }					function orders_bydate(){		$from=strtotime($_POST['from_dt']);		$to=strtotime($_POST['to_dt']);		$orderid=FALSE;		if($_POST['orderid']=='enabled'){			$orderid=TRUE;		}		$this->loadModel('orders_model');		$om=new Orders_model();		$data=$om->orders_bydate($from,$to);		$csvtitles=array("Date time","Phone","Amount","Status");		if($orderid){ $csvtitles=array("Date time","Order ID","Phone","Amount","Status"); }		foreach($data as $value){			$csvline=gmdate("Y-m-d H:i:s",$value['timestamp']).",";			if($orderid){ $csvline.=$value['order_id'].","; }			$csvline.=$value['phone'].",".$value['amount'].",".$value['status'];			$csv[]=$csvline;		}		header('Content-Type: application/excel');		header('Content-Disposition: attachment; filename="sample.csv"');						$fp = fopen('php://output', 'w');		fputcsv($fp, $csvtitles);		foreach ( $csv as $line ) {		    $val = explode(",", $line);		    fputcsv($fp, $val);		}		fclose($fp);					}
//end of class    
}
