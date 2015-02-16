<?php 
//filter url parameters
function url_para_filter($parameter){
	$parameter=mysql_escape_string($parameter);
	return $parameter;
	}
//filter user input
function user_in_filter($parameter){
	mysql_escape_string(htmlspecialchars($parameter));
	return $parameter;
}

//check email format
function is_email($data){
	if(preg_match("/.*@.*..*/", $data)|| preg_match("/(<|>)/", $data)){
		return true;
		};
	}
//encryption technique
function encript($data){
	$data=md5($data);
	$data=md5($data);
	return $data;
	}//accesskeyfunction access_key(){    return encript(rand(100000, 999999));}
//check logged or not
function is_loged(){
if(isset($_SESSION['user_id'])&&isset($_SESSION['auth'])){
	return true;
	}}
 //check admin  or not
function is_staff(){
if(isset($_SESSION['staff_id'])&&isset($_SESSION['auth'])){
	return true;
	}}
//lgout function
function logout($url=''){
	session_unset();
	session_destroy();
if(isset($_SESSION['auth'])){
unset($_SESSION['auth']);
unset($_SESSION['user_id']);
}
if($url){
	header('location:'.$url);
	}
}

//set session for starting of any page
function set_session(){	session_start();
if(!isset($_SESSION['user_id'])&&!isset($_SESSION['auth'])){	session_destroy();		}	}
  //set session for starting of any page
function set_staff_session(){	session_start();	if(!isset($_SESSION['staff_id'])&&!isset($_SESSION['auth'])){		session_destroy();		}}function show404(){	include('errors/404.php');	}