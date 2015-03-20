<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Dbmodel{
    public $table='';
    public $columns='';
    public $values='';
    public $result='';
    public $referedby='';
    public $refervalue='';
    public $orderby='';
    public $orderval='';
    public $query='';

    public function __construct(){
            new Optimiser();
            $this->mysqli = new mysqli(Config::$db_host,Config::$db_user,Config::$db_password,Config::$db_name);
            if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
            }
	}
        
    //select from more than one table with direct query
    //set query,binding values and result array indices as columns
    function query_select($start='',$end=''){
        $query=$this->query;
        if($end){
            $this->query.="LIMIT  $start,$end";
        }
        $stmt=$this->mysqli->prepare($query);
        $error=$this->mysqli->error;
        if($error){
            return $error;
            exit();
        }
        if($this->values){
            $bind_tags='s';
        if(is_array($this->values)){
           $bind_tags='';
           foreach($this->values as $val){
               $bind_tags.="s";
                }
            }
        }
        $data=array();
        $params=array();
        $params[]=&$bind_tags;
        $n=0;
        foreach ($this->values as $val){
            $data[$n]=$val;
            $params[]=&$data[$n];
            $n++;
        }
        call_user_func_array(array($stmt,'bind_param'),$params);
        
	$stmt->execute();
        $data=array();
        $params=array();
        foreach ($this->columns as $val){
            $val=str_replace('.', '_', $val);
            $params[]=&$data[$val];
        }
        call_user_func_array(array($stmt,'bind_result'),$params);
        $result=array();
        while ($stmt->fetch()) {
           $result[]=json_encode($data);
            }
        $stmt->close();
        $this->result=$result;
    }


    //select till limit or select all without limit
    //set table,columns,values,
    function select_limit($start='',$end=''){
        $cols=  $this->columns;
        if(is_array($cols)){
           $cols= implode(',', $cols);
        }
        $query="SELECT $cols FROM $this->table";
        if(!empty($this->referedby)){
            $query.=" WHERE $this->referedby=$this->refervalue";
        }
        $query.=" ORDER BY $this->orderby $this->orderval";
        if($end){
            $query.="  LIMIT  $start,$end";
        }  
        $stmt=$this->mysqli->prepare($query);
        $error=$this->mysqli->error;
        $stmt->execute();
        $data=array();
        $params=array();
        foreach ($this->columns as $val){
            $params[]=&$data[$val];
        }
        call_user_func_array(array($stmt,'bind_result'),$params);
        $result=array();
        while ($stmt->fetch()) {
           $result[]=json_encode($data);
            }
        $stmt->close();
        $this->result=$result;
    }                    
                        
    //select single row referenced by a any one column   
    //set table,columns,referedby and refervalue
    function select(){
        $cols=  $this->columns;
        if(is_array($cols)){
           $cols= implode(',', $cols);
        }
        $query="SELECT $cols FROM $this->table WHERE $this->referedby=?"; 
        $stmt=$this->mysqli->prepare($query);
        $error=$this->mysqli->error;
        if($error){
            return $error;
            exit();
        }
        $stmt->bind_param('s',$this->refervalue);
        $stmt->execute();
        
        
        $data=array();
        $params=array();
        foreach ($this->columns as $val){
            $params[]=&$data[$val];
        }
        call_user_func_array(array($stmt,'bind_result'),$params);
        while ($stmt->fetch()) {
            $this->result=$data;
                }
        $stmt->close();
	
    }
        
    //insert in to specified table.
    //set table,columns,values
    function insert(){
        $cols=$this->columns;
        $tags='?';
        $bind_tags='s';
        if(is_array($cols)){
           $tags='';
           $bind_tags='';
           foreach($cols as $val){
               $tags.="?,";
               $bind_tags.="s";
           }
           $tags=rtrim($tags, ',');
           $cols= implode(',', $cols);
        }
        $query="INSERT INTO $this->table ($cols) VALUES ($tags)";
        $stmt=$this->mysqli->prepare($query);
	$data=array();
        $params=array();
        $params[]=&$bind_tags;
        $n=0;
        foreach ($this->values as $val){
            $data[$n]=$val;
            $params[]=&$data[$n];
            $n++;
        }
        call_user_func_array(array($stmt,'bind_param'),$params);
	$stmt->execute();
	echo $stmt->error;
        $this->result=$this->mysqli->insert_id;
        $stmt->close();
    }
    
    //update row 
    //set table,columns,values,referedby,refevalue
    function update(){
        $cols=  $this->columns;
        $bind_tags='s';
        if(is_array($cols)){
           $colref='';
           $bind_tags='s';
           foreach($cols as $val){
               $colref.=$val."=?,";
               $bind_tags.="s";
           }
           $colref=rtrim($colref, ',');
        }
        $query="UPDATE $this->table SET $colref WHERE $this->referedby=?";
        $stmt=$this->mysqli->prepare($query);
        $error=$this->mysqli->error;
        $data=array();
        $params=array();
        $params[]=&$bind_tags;
        $n=0;
        foreach ($this->values as $val){
            $data[$n]=$val;
            $params[]=&$data[$n];
            $n++;
        }
        $data[$n]=  $this->refervalue;
        $params[]=&$data[$n];
        call_user_func_array(array($stmt,'bind_param'),$params);
	 $stmt->execute();
        echo $stmt->error;
        $stmt->close();
    }
    
    //delete
    //set table,referedby refervalue
    function delete(){
        $query="DELETE FROM $this->table WHERE $this->referedby = ?";
        $stmt=$this->mysqli->prepare($query);
        $stmt->bind_param('s',$this->refervalue);
        $stmt->execute();
	echo $stmt->error;
        $stmt->close();
        
    }
    
    function db_query(){
         $stmt=$this->mysqli->prepare($this->query);
        if(!empty($this->values)){
            $bind_tags='s';
        if(is_array($this->values)){
            $bind_tags='';
            foreach($this->values as $val){
                $bind_tags.="s";
                 }
             }
            $data=array();
            $params=array();
            $params[]=&$bind_tags;
            $n=0;
            foreach ($this->values as $val){
                $data[$n]=$val;
                $params[]=&$data[$n];
                $n++;
            }
            call_user_func_array(array($stmt,'bind_param'),$params);
        }
        $stmt->execute();
	echo $stmt->error;
        $stmt->close();
        
    }
    
    function minimum(){
        $column=$this->columns[0];
        $sql="SELECT MIN($column) FROM $this->table";
        if(!empty($this->referedby)){
            $sql.=" WHERE $this->referedby=?";
        }
	$stmt=$this->mysqli->prepare($sql);
        if(!empty($this->referedby)){
            $stmt->bind_param('s',$this->refervalue); 
        }
	$stmt->execute();
        $stmt->bind_result($sum);
        while ($stmt->fetch()) {
                $sum=$sum;
                    }
        if($stmt->error){
            echo $stmt->error;
        }
        $stmt->close();
        $this->result=$sum;
    }
    
    function maximum(){
        $column=$this->columns[0];
        $sql="SELECT MAX($column) FROM $this->table";
        if(!empty($this->referedby)){
            $sql.=" WHERE $this->referedby=?";
        }
	$stmt=$this->mysqli->prepare($sql);
        if(!empty($this->referedby)){
            $stmt->bind_param('s',$this->refervalue); 
        }
	$stmt->execute();
        $stmt->bind_result($sum);
        while ($stmt->fetch()) {
                $sum=$sum;
                    }
        if($stmt->error){
            echo $stmt->error;
        }
        $stmt->close();
        $this->result=$sum;
    }
    
    function average(){
        $column=$this->columns[0];
        $sql="SELECT AVG($column) FROM $this->table";
        if(!empty($this->referedby)){
            $sql.=" WHERE $this->referedby=?";
        }
	$stmt=$this->mysqli->prepare($sql);
        if(!empty($this->referedby)){
            $stmt->bind_param('s',$this->refervalue); 
        }
	$stmt->execute();
        $stmt->bind_result($sum);
        while ($stmt->fetch()) {
                $sum=$sum;
                    }
        if($stmt->error){
            echo $stmt->error;
        }
        $stmt->close();
        $this->result=$sum;
    }
    
    function sum(){
        $column=$this->columns[0];
        $sql="SELECT SUM($column) FROM $this->table";
        if(!empty($this->referedby)){
            $sql.=" WHERE $this->referedby=?";
        }
        echo $sql;
	$stmt=$this->mysqli->prepare($sql);
        if(!empty($this->referedby)){
            $stmt->bind_param('s',$this->refervalue); 
        }
	$stmt->execute();
        $stmt->bind_result($sum);
        while ($stmt->fetch()) {
                $sum=$sum;
                    }
        if($stmt->error){
            echo $stmt->error;
        }
        $stmt->close();
        $this->result=$sum;
    }
    
    function count(){
        $column=$this->columns[0];
        $sql="SELECT COUNT($column) FROM $this->table";
        if(!empty($this->referedby)){
            $sql.=" WHERE $this->referedby=?";
        }
	$stmt=$this->mysqli->prepare($sql);
        if(!empty($this->referedby)){
            $stmt->bind_param('s',$this->refervalue); 
        }
	$stmt->execute();
        $stmt->bind_result($count);
        while ($stmt->fetch()) {
                $count=$count;
                    }
        if($stmt->error){
            echo $stmt->error;
        }
        $stmt->close();
        $this->result=$count;
    }
    





    //end of class
	}



