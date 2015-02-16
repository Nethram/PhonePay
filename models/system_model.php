<?php
class System_model extends Dbmodel{
    private $tbl_behavior='behavior';
    
    
    function update_behavior($type,$status,$amount){
        $query="UPDATE $this->tbl_behavior SET `type` = ?,`order_id`=?,`amount`=? ";
		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->bind_param('ssi', $type,$status,$amount);
		$stmt->execute();
    }

    function get_bahavior(){        $id=1;        $result=array();		$query="SELECT `type`,`order_id`,`amount` FROM `$this->tbl_behavior` LIMIT 1";		$stmt=$this->mysqli->prepare($query);
                $error=$this->mysqli->error;
                if($error){
                    return $error;
                    exit();
                }
		$stmt->execute();
		$stmt->bind_result($type,$order_id,$amount);
		while ($stmt->fetch()) {
       			$result['type']=$type;
                        $result['order_id']=$order_id;
                        $result['amount']=$amount;
       			    }
		$stmt->close();		return $result;
    }


    //end of class
  }
