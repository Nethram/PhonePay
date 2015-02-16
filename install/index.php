<?php //require_once '../application/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Phone Pay application from Nethram">
    <meta name="author" content="Nethram">
    <title>Phone Pay :: Install</title>
    <link href="../assets/css/main_style.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../assets/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
   <!-- Custom CSS -->
    <link href="../assets/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../assets/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- jQuery Version 1.11.0 -->
    <script src="../assets/js/jquery-1.11.0.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../assets/js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../assets/js/sb-admin-2.js"></script>
    <script src="../assets/js/admin.js"></script>
    <script src="../assets/js/general.js"></script>
    <script src="../assets/js/plugins/jq_form.js"></script>
    <script src="../assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<style>
.grey{ 
	width:1000px;
	margin-left:auto;
	margin-right:auto;
	}
#form_block{
	width:500px;
	margin-left:auto;
	margin-right:auto;
	background:green;
	}

</style>
<body>
	<div class="container grey">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1>Phone Pay Installation</h1>
					</div>
					<div class="panel-body">
						<div id="form_block">
						<div class="col-lg-12" >
						<?php 
						$db_form=false;
						$stripe_form=FALSE;
						$acoount_form=FALSE;
						$conf_file='../application/config.php';
						
						if(isset($_POST['step1'])){
							$base_url=$_POST['base_url'];
							$db_host=$_POST['db_host'];
							$db_name=$_POST['db_name'];
							$db_user=$_POST['db_user'];
							$db_pass=$_POST['db_pass'];
							$db_structure=file_get_contents('db_structure.sql');
							
							set_error_handler(function() { /* ignore errors */ });
							dns_get_record();
							
							$con=mysqli_connect($db_host,$db_user,$db_pass,$db_name);
							
							// Check connection
							if (mysqli_connect_errno())
							  {
							  echo "<div class='alert alert-danger'>Failed to connect to MySQL: " . mysqli_connect_error()."</div>";
							  }else{
							  	
								  $quereis=explode('[query]',$db_structure);
								  foreach ($quereis as $query) {
								  	if(!empty($query))	
									mysqli_query($con,$query);  
								  }
								  mysqli_close($con);
								  restore_error_handler();
								  $db_form=TRUE;
								  $config_db='
								  	//base url eg: http://www.example.com
								     static $base_url="'.$base_url.'";
								     static $url_tail=".php";
								  	 //database credentials
     								 static $db_host="'.$db_host.'";
								     static $db_name="'.$db_name.'";
								     static $db_user="'.$db_user.'";
								     static $db_password="'.$db_pass.'";';
									 
									 $_SESSION['db_host']=$db_host;
									 $_SESSION['db_name']=$db_name;
									 $_SESSION['db_user']=$db_user;
									 $_SESSION['db_pass']=$db_pass;
									 file_put_contents($conf_file, $config_db);
							  }
							
						}
						
						if(isset($_POST['step2'])){
							$db_form=TRUE;
							$pub_key=$_POST['pub_key'];
							$sec_key=$_POST['sec_key'];
							require_once '../lib/Stripe.php';
							$stripe=FALSE;
							Stripe::setApiKey($sec_key);
							try{
								Stripe_Balance::retrieve();	
								$stripe=true;
							}
							catch(Exception $e) {
								  echo '<div class="alert alert-danger">Message: ' .$e->getMessage().'</div>';
								}
							if($stripe){
							$config_db=file_get_contents($conf_file);
							file_put_contents($conf_file,'');
							$config_stripe='
							 //stripe keys
						     static $secret_key="'.$sec_key.'";
						     static $public_key="'.$pub_key.'";';
							$config='<?php  
							 class Config{
							     //defualt controller,which loads first.
								 static $installed=true;
							     static $defualt_controller="admin";
							     //directories
							     static $dir_controllers="controllers";
							     static $dir_views="views";
							     static $dir_models="models";
							     static $dir_helper="helper";';
							$config.=$config_db;
							$config.=$config_stripe;
							$config.='
							 }
							 ?>';
							file_put_contents($conf_file, $config);
							
							$stripe_form=TRUE;
							}
						}
						
						if(isset($_POST['step3'])){
							$db_form=TRUE;
							$stripe_form=TRUE;
							$email=$_POST['email'];
							$pass1=$_POST['password1'];
							$pass2=$_POST['password2'];
							if($pass1=$pass2){
								require_once $conf_file;
								$con=mysqli_connect(Config::$db_host,Config::$db_user,Config::$db_password,Config::$db_name);
								$pass1=md5($pass1);
								$pass1=md5($pass1);
								$acc_key=md5($email);
								$query="INSERT INTO `staff`(`email`,`password`,`accesskey`) VALUES ('$email','$pass1','$acc_key')";
								mysqli_query($con, $query);
								$acoount_form=TRUE;
								echo "<div class='alert alert-success'>Phone pay success fully installed.</div>";
								?>
								<p>
									You have installed Phone Pay and configured Stripe account. To start using phone pay you 
									need to intergate your Twilio number with Phone Pay. Go to your Twilio account and set
									Request URL of your number to <b><?php echo Config::$base_url ?>/twiml.php</b> as shown image.
									
								</p>
								
								
								<?php
							}else{
								 echo "<div class='alert alert-danger'>Passwords does not match.</div>";
							}
							
						}
						
						
						
						
						
						
						if(!$db_form){
							require_once 'db_form.php';
						}
						
						if($db_form && !$stripe_form){
							require_once 'stripe_form.php';
						}
						
						if($db_form && $stripe_form && !$acoount_form){
							require_once 'account_form.php';
						}
						?>
						</div>
					</div>
					<?php 
					if($db_form && $stripe_form && $acoount_form){
					echo '<img src="twilio.png" style="border:thick solid #ccc; border-radius:10px; margin-left:80px;">';
					echo '<p style="text-align:center"><a href="'.Config::$base_url.'">Click here to login to admin pane.</a></p>';
					}
					?>
					
					
					
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

