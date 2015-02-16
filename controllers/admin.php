<?php

class Admin extends Controller{
    
    function index(){
        
         $data="";
            $page="home";
            $params=$this->urlPara();
           
        if(!empty($params)){
            $page=$params[0];
        }
        set_staff_session();
        $this->loadModel('staff');
        $staff=new Staff();
        if(is_staff()){
           
        switch($page){        	case 'orders':				$this->loadModel('system_model');				$system_model=new System_model();				$bahavoir=$system_model->get_bahavior();				$data['orderid']=$bahavoir['order_id'];				break;        				case 'home':				$this->loadModel('orders_model');				$orders=new Orders_model();				$data['total']=$orders->total_orders();				$data['unpaid']=$orders->total_orders_status('unpaid');				$data['paid']=$orders->total_orders_status('paid');				$data['cancelled']=$orders->total_orders_status('cancelled');								$this->loadModel('transactions');				$txn=new Transactions();								$data['failed']=$txn->total_transactions_status('failed');				$data['completed']=$txn->total_transactions_status('completed');				$data['refunded']=$txn->total_transactions_status('refunded');				$data['initiated']=$txn->total_transactions_status('initiated');												break;
            case 'settings':
                $this->loadModel('system_model');
                $system_model=new System_model();
                $bahavoir=$system_model->get_bahavior();
                if($bahavoir['type']=='fixed' && $bahavoir['order_id']=='enabled'){
                    $data['behavior']='behave1';
                }
                if($bahavoir['type']=='fixed' && $bahavoir['order_id']=='disabled'){
                    $data['behavior']='behave2';
                }
                if($bahavoir['type']=='user_defined' && $bahavoir['order_id']=='enabled'){
                    $data['behavior']='behave3';
                }
                if($bahavoir['type']=='user_defined' && $bahavoir['order_id']=='disabled'){
                    $data['behavior']='behave4';
                }
                
                
                $data['account']=$staff->account_data($_SESSION['staff_id']);
                break;
            
            }
            
            
            
            $this->loadView('pre_header');
            $this->loadView('main_header');
            $this->loadView($page,$data);
            $this->loadView('footer');
            
        }elseif($page=='reset_password' || $page=='password_recovery'){
            $data='';
            if(!empty($params[1])&&!empty($params[2])){
                    $accesskey_url=$params[1];
                    $email=base64_decode($params[2]);
                    $data['email']=$email;
                    $accesskey=$staff->get_accesskey($email);
                    if($accesskey==$accesskey_url){					    $data['status']=TRUE;
                        $data['message']='Create new password.';
                    }  else {
                        $data['status']=FALSE;
                        $data['message']='This link is not valid.';
                    }
                    
                }
            
            $this->loadView('pre_header');
            $this->loadView($page,$data);
        }
        else {
            $this->loadView('pre_header');
            $this->loadView('login');   
        }
        
        
    }
    
    
    
    
    
    function auth(){
        if(isset($_POST['email'])){
            $respon['status']=FALSE;
            
                   $email=  user_in_filter($_POST['email']);
                   $passwd=user_in_filter($_POST['password']);
                   $passwd=  encript($passwd);
                    if ($email&&$passwd){
                        $this->loadModel('staff');
                        $staff=new Staff();
                        $data=$staff->auth_data($email);
                        if($data){
                            if($passwd==$data['password']){
                                session_start();
                                $_SESSION['staff_id']=$data['staff_id'];
                                $_SESSION['auth']=1;
                                $respon['status']=TRUE;
                                $respon['message']="Logged in.";
                                //$msg="<script>window.location.reload();</script>";
                            }  else {
                                $respon['message']= "Password or email incorrect.";
                            }
                        }  else {
                            $respon['message']= "No matching staff account.";
                        }
                    }else {
                      $respon['message']= "Email and password required.";  
                    } 
                    echo json_encode($respon);
                
        }
    }
    
    
    
    
 function logout(){
        set_staff_session();
        if(isset($_POST['logout'])){
            logout();
            echo "<script>window.location.reload();</script>";
        }
    }
    
 
 
private function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}


function password_request(){
    $data['status']=FALSE;
        if(isset($_POST['email']) && isset($_POST['captcha'])){
            $email=  user_in_filter($_POST['email']);
            $captcha=user_in_filter($_POST['captcha']);
            $this->loadModel('staff');
            $login_model=new Staff();
            $data_db=$login_model->auth_data($email);
            if($data_db){
                         session_start();
                         if($captcha==$_SESSION['security_code']){
                                
                                $accesskey=$login_model->get_accesskey($email);
                                
                                $verify_email_url=Config::$base_url.'/password_recovery/'.$accesskey.'/'.base64_encode($email).'.php';
                                
                                $body="<h3>Reset password</h3><p></p>";
                                $body.="<p>Visit<a href='".$verify_email_url."'> this page </a>to create new password for your account.</p>";
                                $body.="<p style='padding:10px; height:40px; background:#5D8F86; line-height:40px; '><a style='color:#ffffff;' href='".$verify_email_url."'> Reset Password </a></p>";
                                
                                $to = $email;

                                $subject = 'Admin password reset';

                                $headers = "From:support@nethram.com\r\n";
                                $headers .= "Reply-To:support@nethram.com\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                mail($to, $subject, $body, $headers);
                                $data['status']=TRUE;
                                $data['message']="Password recovery email has sent to your mail.";
                            }  else {
                                $data['message']= "Incorrect captcha data.";
                            }
                        }  else {
                            $data['message']= "No matching user account.";
                        }
        }  else {
            $data['message']="Enter email and captcha.";
        }
        echo json_encode($data);
}


function savepasswd(){
    $data['status']=FALSE;
    if(isset($_POST['password1']) && isset($_POST['password2'])){
            $password1=user_in_filter($_POST['password1']);
            $password2=user_in_filter($_POST['password2']);
            $email=user_in_filter($_POST['email']);
            if($password1==$password2){
                $password=encript($password1);
                $this->loadModel('staff');
                $user_model=new Staff();
                $user_model->update_password($password,$email);
                $user_model->change_accesskey(access_key(),$email);
                $data['status']=TRUE;
                $data['message']="Password changed.";
            }  else {
                $data['message']="Enter passwords.";
            }
            
        }  else {
            $data['message']="Enter passwords.";
        }
        echo json_encode($data);
}



function change_account_data(){
    $data['status']=FALSE;
    if(isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['password_old'])&& isset($_POST['email_new'])){
            $email_new=user_in_filter($_POST['email_new']);
            $password_old=user_in_filter($_POST['password_old']);
            $password1=user_in_filter($_POST['password1']);
            $password2=user_in_filter($_POST['password2']);
            $email=user_in_filter($_POST['email']);
            if($password1==$password2){
                $this->loadModel('staff');
                $staff=new Staff();
                $password=encript($password1);
                $password_old=encript($password_old);
                $info=$staff->auth_data($email);
                        if($info){
                            if($password_old==$info['password']){
                                $staff->update_account_data($email_new,$password,$email);
                                $data['status']=TRUE;
                                $data['message']="Changes Saved.";
                            }  else {
                                $data['message']= "Incorrect Old Password.";
                            }
                        }  else {
                            $data['message']= "No matching staff account.";
                        }
            }  else {
                $data['message']="Passwords does not match.";
            }
            
        }  else {
            $data['message']="Enter new email and passwords.";
        }
        echo json_encode($data);
}



//end of class    
}
