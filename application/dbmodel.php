<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

	
	
class Dbmodel{
	
	public function __construct(){
            new Optimiser();
			 $this->mysqli = new mysqli(Config::$db_host,Config::$db_user,Config::$db_password,Config::$db_name);
			if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
			}
			}
	
	
	
	function db_query($query){
	$this->mysqli->query($query);
    	echo $this->mysqli->error;
	$a=$this->mysqli->insert_id;
	return $a;
		}
	
	//end of class
	}



