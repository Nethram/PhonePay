<?php  
header('Access-Control-Allow-Origin: *');  
							 class Config{
							     //defualt controller,which loads first.
								 static $installed=true;
							     static $defualt_controller="admin";
							     //directories
							     static $dir_controllers="controllers";
							     static $dir_views="views";
							     static $dir_models="models";
							     static $dir_helper="helper";
								  	//base url eg: http://www.example.com
								     static $base_url="https://502df438.ngrok.io/PhonePay";
								     static $url_tail=".php";
								  	 //database credentials
     								 static $db_host="localhost";
								     static $db_name="phone_pay";
								     static $db_user="root";
								     static $db_password="passw0rd";
							 //stripe keys
						     static $secret_key="sk_test_fDRbOjWsIw0zsGIufuGq4fNy";
						     static $public_key="pk_test_oMAkdXHBAKVcSAg0gStz2MRd";
							 }
							 ?>