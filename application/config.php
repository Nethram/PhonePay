<?php  
							 class Config{
							     //defualt controller,which loads first.
								 static $installed=FALSE;
							     static $defualt_controller="admin";
							     //directories
							     static $dir_controllers="controllers";
							     static $dir_views="views";
							     static $dir_models="models";
							     static $dir_helper="helper";
								  	//base url eg: http://www.example.com
								     static $base_url="";
								     static $url_tail=".php";
								  	 //database credentials
     								 static $db_host="";
								     static $db_name="";
								     static $db_user="";
								     static $db_password="";
							 //stripe keys
						     static $secret_key="";
						     static $public_key="";
							 }
							 ?>