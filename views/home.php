<div class="panel panel-default" id="acc_set">
  <div class="panel-heading">
    <h3 class="panel-title">Log</h3>
  </div>
  <div class="panel-body">
	 
	 <div class="col-lg-3 col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-phone fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['unpaid'] ?></div>
                        <div>Un paid</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-phone fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['paid'] ?></div>
                        <div>Paid</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-phone fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['cancelled'] ?></div>
                        <div>Cancelled</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-phone fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['total'] ?></div>
                        <div>Total</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


<span style="float: right"><a href="<?php echo Config::$base_url ?>/admin/orders.php">Manage log >></a></span>
  </div>
</div>
