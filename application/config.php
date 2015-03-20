<?php  
							 class Config{
							     //defualt controller,which loads first.
								 static $installed=false;
							     static $defualt_controller="admin";
							     //directories
							     static $dir_controllers="controllers";
							     static $dir_views="views";
							     static $dir_models="models";
							     static $dir_helper="helper";
								  	//base url eg: http://www.example.com
								     static $base_url="http://nethram.com/sandbox/phonepay";
								     static $url_tail=".php";
								  	 //database credentials
     								 static $db_host="localhost";
								     static $db_name="dbname";
								     static $db_user="dbuser";
								     static $db_password="1234";
							 //stripe keys
						     static $secret_key="";
						     static $public_key="";
							 }
							 ?>