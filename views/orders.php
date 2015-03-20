<link href="<?php echo base_url; ?>/assets/css/jsDatePick_ltr.min.css" rel="stylesheet"><script src="<?php echo base_url; ?>/assets/js/jsDatePick.min.1.3.js"></script><script type="text/javascript">	window.onload = function(){		new JsDatePick({			useMode:2,			target:"from_dt",			dateFormat:"%d-%m-%Y"					});				new JsDatePick({			useMode:2,			target:"to_dt",			dateFormat:"%d-%m-%Y"					});	};</script><h2>Log</h2><style>	#details table tr{ border-bottom: solid thin #cccccc;}</style>

<script>
function create_new_order(){
    $("#new_order").modal({
        backdrop: 'static',
        keyboard: false
    })
}
function details_item(id){	$("#log_details").modal().on('hidden.bs.modal', function (e) {	$("#details").html("<img src='<?php echo Config::$base_url ?>/assets/images/loading.gif' />");});		$.post( "<?php echo Config::$base_url ?>/transaction/get_transaction.php",{id:id}).done(function(txns){		//data=jQuery.parseJSON(txns);		$("#details").html(txns);	});	}function process_overage(){	$("#overage_model").modal('hide');	var stripe_id=$("#overage_stripid").val();	var amount=$("#overage_amount").val();	$.post( "<?php echo Config::$base_url ?>/paynow/charge_overage.php",{stripe_id:stripe_id,amount:amount}).done(function(realb){	     data=jQuery.parseJSON(realb);	  if(data.status==true){		    $("#message").addClass("alert alert-success").removeClass("alert-danger");		    $("#message").html(data.message);		    $("#message").fadeTo(2000, 500).slideUp(500);		    table.ajax.reload();		}else{		    $("#message").addClass("alert alert-danger").removeClass("alert-success");		    $("#message").html("Error : "+data.message);		    }	    });		}function process_refund(){	$("#refund_model").modal('hide');	var stripe_id=$("#refund_stripid").val();	var amount=$("#refund_amount").val();	$.post( "<?php echo Config::$base_url ?>/paynow/refund.php",{stripe_id:stripe_id,amount:amount}).done(function(realb){	     data=jQuery.parseJSON(realb);	  if(data.status==true){		    $("#message").addClass("alert alert-success").removeClass("alert-danger");		    $("#message").html(data.message);		    $("#message").fadeTo(2000, 500).slideUp(500);		    table.ajax.reload();		}else{		    $("#message").addClass("alert alert-danger").removeClass("alert-success");		    $("#message").html("Error : "+data.message);		    }	    });}function refund(stripe_id){		$("#refund_stripid").val(stripe_id);		$("#log_details").modal('hide');		$("#refund_model").modal('show');		}
function charge_overage(stripe_id){	$("#overage_stripid").val(stripe_id);	$("#log_details").modal('hide');	$("#overage_model").modal('show');}

$(document).ready(function() { 
    
    $("#cancel_new").click(function(){
         $("#new_order").modal('hide');
    });
    
    var options={ 
       // target:'#message',   // target element(s) to be updated with server response 
        beforeSubmit:  validate,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
                }; 
    $('#create_new_order').ajaxForm(options); 
    
    function validate(formData, jqForm, options) { 
      if(!formData[0].value || !formData[1].value)  {
        $("#message_edit").addClass("alert alert-danger");
        $("#message_edit").html("Please fill required fields");
      return false;
        }else{
            return true;
        }
        
    }      
    function showResponse(responseText, statusText, xhr, $form)  { 
            var data=jQuery.parseJSON(responseText);
            if(data.status==true){
                $("#message").addClass("alert alert-success").removeClass("alert-danger");
                $("#message").html(data.message);
                $("#new_order").modal('hide');
                table.ajax.reload();
                $("#form_message").fadeTo(2000, 500).slideUp(500);
            }else{
                $("#message_edit").addClass("alert alert-danger").removeClass("alert-success");
                $("#message_edit").html(data.message);
            }
        }        
            
    }); 

function update_item(n){
    $("#amount_"+n).removeClass('hidden');
    $("#status_"+n).removeClass('hidden');
    $("#phone_"+n).removeClass('hidden');
    $("#savebtn_"+n).removeClass('hidden');
    $("#btn_"+n).addClass('hidden');
    
    
}

function save_item(n,id){
    var amount=$("#amount_"+n).val();
    var status=$("#status_"+n).val();
    var phone=$("#phone_"+n).val();
     $.post( "<?php echo Config::$base_url ?>/orders/update_order.php",{id:id,phone:phone,amount:amount,status:status}).done(function(realb){
                 data=jQuery.parseJSON(realb);
              
              if(data.status==true){
                $("#message").addClass("alert alert-success").removeClass("alert-danger");
                $("#message").html(data.message);
                $("#message").fadeTo(2000, 500).slideUp(500);
                table.ajax.reload();
            }else{
                $("#message").addClass("alert alert-danger").removeClass("alert-success");
                $("#message").html("Error : "+data.message);
                }
              
                });
}

function delete_item(id){
    $.post( "<?php echo Config::$base_url ?>/orders/delete_order.php",{id:id}).done(function(realb){
                 data=jQuery.parseJSON(realb);
              
              if(data.status==true){
                $("#message").addClass("alert alert-success").removeClass("alert-danger");
                $("#message").html(data.message);
                $("#message").fadeTo(2000, 500).slideUp(500);
                table.ajax.reload();
            }else{
                $("#message").addClass("alert alert-danger").removeClass("alert-success");
                $("#message").html("Error : "+data.message);
                }
              
                });
}


</script><!-- refund model  --><div style="margin-top: 150px;" id="refund_model" class="modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-hidden="true">  <div class="modal-dialog modal-med">   <div id="loading" class="modal-content" style="text-align: center;">          <div class="modal-header">              <h3 class="modal-title primary">Refund</h3>          </div>        <div class="modal-body">        	<div class="form-group">				 <input id="refund_stripid" type="hidden" >                 <label>Amount to be refunded.<span class="required">*</span></label>                <input class="form-control" id="refund_amount" placeholder="Amount"  required>                            </div>            <div class="form-group">				<button class="btn btn-danger" onclick="process_refund()">Confirm</button>               				<p class="help-block">This action cannot be reversed !</p>            </div>        			</div>    </div>  </div></div><!-- overage model  --><div style="margin-top: 150px;" id="overage_model" class="modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-hidden="true">  <div class="modal-dialog modal-med">   <div id="loading" class="modal-content" style="text-align: center;">          <div class="modal-header">              <h3 class="modal-title primary">Charge Overage</h3>          </div>        <div class="modal-body">        	<div class="form-group">				 <input id="overage_stripid" type="hidden" >                 <label>Amount to be charged.<span class="required">*</span></label>                <input class="form-control" id="overage_amount" placeholder="Amount"  required>                            </div>            <div class="form-group">				<button class="btn btn-danger" onclick="process_overage()">Confirm</button>               				<p class="help-block">This action cannot be reversed !</p>            </div>        			</div>    </div>  </div></div>
<!-- view log details  --><div style="margin-top: 150px;" id="log_details" class="modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-hidden="true">  <div class="modal-dialog modal-med">   <div id="loading" class="modal-content" style="text-align: center;">          <div class="modal-header">              <h3 class="modal-title primary">Details</h3>          </div>        <div class="modal-body edit_form">			<div id="details">				<img src="<?php echo Config::$base_url ?>/assets/images/loading.gif"/>			</div>		</div>    </div>  </div></div>
<!-- new order -->
<div style="margin-top: 150px;" id="new_order" class="modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-med">
   <div id="loading" class="modal-content" style="text-align: center;">
          <div class="modal-header">
              <h3 class="modal-title primary">New Order</h3>
          </div>
        <div class="modal-body edit_form">
            <form method="post" id="create_new_order" action="<?php echo base_url; ?>/orders/new_order.php">
                    <div class="form-group">
                        <label>Order ID<span class="required">*</span></label>
                        <input id="f_name" class="form-control" name="order_id" placeholder="Order ID"  required>                
                        <p class="help-block">Unique Order ID</p>
                    </div>
                    <div class="form-group">
                        <label>Amount<span class="required">*</span></label>
                        <input id="f_name" class="form-control" name="amount" placeholder="Amount"  required>                
                        <p class="help-block">Amount to charged.</p>
                    </div>
                    
                    <div id="loading"></div>
                    <div id="message_edit"></div>
                    <button id="order_btn" type="submit" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-fw"></i>Submit</button>
                    <button id="cancel_new" type="button" class="btn btn-primary btn-sm"><i class="fa fa-close fa-fw"></i>Cancel</button>
                </form>
        </div>
        
       
    </div>
  </div>
</div>
<!--end new order model -->








<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"></div>	<div style=" float: right; margin: 10px;">  	<form action="<?php echo Config::$base_url ?>/orders/orders_bydate.php" method="post">  		<input type="text" id="from_dt" name="from_dt"  required="required"/>  		<input type="text" id="to_dt" name="to_dt" required="required" />  		<input  type="hidden" name="orderid" value="<?php echo $data['orderid']; ?>" />  		<input type="submit" class="btn btn-primary" value="Download CSV" />  	</form>  </div>	
  <div class="panel-body">	  <?php if($data['orderid']=='enabled'): ?>
      <i class="fa fa-plus-square fa-3x" style="color: green; cursor: pointer;" onclick="create_new_order()"></i>	  <?php endif ?>	
      <div id="message"></div>
  </div>	
  
  <!-- Table -->
  <table class="table" id="orders_table">
      <thead>
      <tr><th>Sl</th><th width="160">Date Time</th><?php if($data['orderid']=='enabled'): ?><th width="100">Order ID</th><?php endif ?><th>Phone</th><th>Amount</th><th width="100">Overage</th><th width="100">Refunded</th><th width="100">Status</th><th width="200">Action</th></tr>
      </thead>
      
      <tfoot>
      <tr><th>Sl</th><th>Date Time</th><?php if($data['orderid']=='enabled'): ?><th>Order ID</th><?php endif ?><th>Phone</th><th>Amount</th><th>Overage</th><th>Refunded</th><th>Status</th><th>Action</th></tr>
      </tfoot>
  </table>
</div>

<script>
                    var table=$('#orders_table').DataTable( {						
                        serverSide: true,
                        ajax: {
                            url: '<?php echo Config::$base_url ?>/orders/view_orders.php',
                            type: 'POST'
                        },
                        strings: {
                            "loadingMessage": "Loadding",
                            "emptyMessage":"no data"                           						}
                    } );
</script>