<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Staff extends Dbmodel{
    private $tbl_staff="staff";
    
    function auth_data($data){
		$result=array();
		$query="SELECT `staff_id`,`password`,`status` FROM `$this->tbl_staff` WHERE `email`=?";
		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->bind_param('s', $data);
		$stmt->execute();
		$stmt->bind_result($staff_id , $password, $status);
		while ($stmt->fetch()) {
       			$result['staff_id']=$staff_id;
       			$result['password']=$password;
                        $result['status']=$status;
			    }
		$stmt->close();
		return $result;
		}
                
                
     function db_insert($query){
	$this->mysqli->query($query);
    	echo $this->mysqli->error;
	$a=$this->mysqli->insert_id;
			// close connection 
	$this->mysqli->close();
	return $a;
		}
                
     
     function get_accesskey($email){
        $result=array();
		$query="SELECT `accesskey` FROM `$this->tbl_staff` WHERE `email`=?";
		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->bind_result($accesskey);
		while ($stmt->fetch()) {
       			$result['accesskey']=$accesskey;
       			    }
		$stmt->close();
                if(!empty($result['accesskey'])){
                    return $result['accesskey'];
                }
                
    }

    function change_accesskey($key,$email){
        
        $query="UPDATE $this->tbl_staff SET `accesskey` = ? WHERE `email`=?";
		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->bind_param('ss', $key,$email);
		$stmt->execute();
    }  
                
    
    
    
    function update_password($password,$email){
        $query="UPDATE $this->tbl_staff SET `password`=? WHERE `email`=?";
		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->bind_param('ss', $password,$email);
		$stmt->execute();
                echo $stmt->error;
		$stmt->close();
        
    }
    
    function update_account_data($email_new,$password_new,$email){
        $query="UPDATE $this->tbl_staff SET `email`=?,`password`=? WHERE `email`=?";
		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->bind_param('sss',$email_new,$password_new,$email);
		$stmt->execute();
                echo $stmt->error;
		$stmt->close();
        
    }
    
 
    function account_data($id){
        $result=array();
		$query="SELECT `email`,`password`,`status` FROM `$this->tbl_staff` WHERE `staff_id`=?";
		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->bind_param('i',$id);
		$stmt->execute();
		$stmt->bind_result($email , $password, $status);
		while ($stmt->fetch()) {
       			$result['email']=$email;
       			$result['password']=$password;
                        $result['status']=$status;
			    }
		$stmt->close();
		return $result;
    }


//end of class                
}