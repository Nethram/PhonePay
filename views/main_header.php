<body><link href="<?php echo base_url; ?>/assets/css/simple-sidebar.css" rel="stylesheet">    <style>        #wrapper{            margin-top: 100px;        }        #hed_bar{            min-height: 100px;            background: #E2E2E2;            position: fixed;            z-index: 999999;            width: 100%;                   }                #top_btns{            float: right;        }        #mover{           // width: 100px;            //height: 50px;            //background: #66afe9;            position: absolute;            padding: 5px;            z-index: 999;        }    </style>    <div class="container-fluid" >        <div class="row">        <div class="col-lg-12" id="hed_bar">            <h1>Phone Pay</h1>            <div id="top_btns">                <button id="logout" class=" btn btn-default">Logout</button>                <div id="e_msg"></div>                </div>         </div>         </div>    </div> <script>    $(document).ready(function(){        //var base_url=$("#base_url").val();            $("#logout").click(function(submit_form){             //submit_form.preventDefault();             $.post( "<?php echo base_url; ?>/admin/logout.php",{logout:true}).done(function(realb){              $('#e_msg').html(realb);                });            })                                                        $("#menu-toggle").click(function(e) {        e.preventDefault();        $("#wrapper").toggleClass("toggled");        $("#ico_tog").toggleClass("fa-angle-double-right fa-angle-double-left");            });                                }); </script>                                           <div id="wrapper">        <div id="mover">           <a href="#menu-toggle" id="menu-toggle"><i id="ico_tog" class="fa fa-angle-double-left"></i></a>        </div>        <!-- Sidebar -->        <div id="sidebar-wrapper">            <ul class="sidebar-nav">                                <li>					<a href="index.php">					<i class="fa fa-tachometer"></i> Dashboard                    </a>                </li>                                <li>                    <a href="<?php echo base_url ?>/admin/orders.php">                    <i class="fa fa-file-text"></i> Log                    </a>                </li>                                <li>                    <a href="<?php echo base_url ?>/admin/settings.php">                    	<i class="fa fa-gear"></i> Settings                    </a>                </li>                <li>                    <a href="<?php echo base_url ?>/admin/help.php">                    	<i class="fa fa-life-bouy"></i> Help                    </a>                </li>                <li>                    <a href="<?php echo base_url ?>/admin/about.php">                    	<i class="fa fa-certificate"></i> About                    </a>                </li>                            </ul>        </div>        <!-- /#sidebar-wrapper -->        <!-- Page Content -->        <div id="page-content-wrapper">            <div class="container-fluid">                                