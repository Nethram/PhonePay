<?php

class System extends Controller{
    function index(){
        
    }
    
    function system_bahavoir(){
        if(isset($_POST['type'])){
            $type=  user_in_filter($_POST['type']);
            $status=  user_in_filter($_POST['status']);
            $amount=  user_in_filter($_POST['amount']);
            $this->loadModel('system_model');
            $system_model=new System_model();
            $system_model->update_behavior($type,$status,$amount);
            $data['status']=true;
            $data['message']="System bahavior changed.";
        }  else {
            $data['status']=false;
            $data['message']="Unable to change system bahavior.";
        }
        echo json_encode($data);
        
    }
    
    
    
}