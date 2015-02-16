<h2>Settings</h2>



<div class="panel panel-default" id="acc_set">
  <div class="panel-heading">
    <h3 class="panel-title">Account Settings</h3>
  </div>
  <div class="panel-body">
      <form method="post" id="change_account" action="<?php echo Config::$base_url ?>/admin/change_account_data.php">
                    <input type="hidden" name="email" value="<?php echo $data['account']['email']; ?>"/>
                    <div class="form-group">
                        <label for="email_new">Email</label>
                        <input id="passswd" class="form-control" type="test" name="email_new" value="<?php echo $data['account']['email']; ?>" required>                
                    </div>
                    <div class="form-group">
                        <label for="passwd">Old Password</label>
                        <input id="passswd" class="form-control" type="password" name="password_old" placeholder="Old Passsword" required>                
                    </div>
                    <div class="form-group">
                        <label for="passwd">New Password</label>
                        <input id="passswd" class="form-control" type="password" name="password1" placeholder="Passsword" required>                
                    </div>
                    <div class="form-group">
                        <label for="passwd">Confirm Password</label>
                        <input id="passswd" class="form-control" type="password" name="password2" placeholder="Confirm Passsword" required>                
                    </div>
                    <div class="loading hidden"><img src="<?php echo Config::$base_url; ?>/assets/images/loading.gif"/></div>
                    <div class="message"></div>
                    <button id="edit_btn" type="submit" class="btn btn-warning btn-sm">Save Changes</button>
            </form>
  </div>
</div>




<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">System Behavior</h3>
  </div>
    <div class="panel-body">
        <div id="message"></div>
        <script>
        $(document).ready(function(){
            $("#behave1").click(function(){
            $("#behave1").addClass('selected_tab');
            $("#behave2").removeClass('selected_tab');
            $("#behave3").removeClass('selected_tab');
            $("#behave4").removeClass('selected_tab');
            var amount=$("#behave1_amt").val();
            set_bahavior('fixed','enabled',amount);
            })
            
            $("#behave2").click(function(){
            $("#behave2").addClass('selected_tab');
            $("#behave1").removeClass('selected_tab');
            $("#behave3").removeClass('selected_tab');
            $("#behave4").removeClass('selected_tab');
            var amount=$("#behave2_amt").val();
            set_bahavior('fixed','disabled',amount);
            })
            
            $("#behave3").click(function(){
            $("#behave3").addClass('selected_tab');
            $("#behave1").removeClass('selected_tab');
            $("#behave2").removeClass('selected_tab');
            $("#behave4").removeClass('selected_tab');
            set_bahavior('user_defined','enabled',0);
            })
            
            $("#behave4").click(function(){
            $("#behave4").addClass('selected_tab');
            $("#behave1").removeClass('selected_tab');
            $("#behave2").removeClass('selected_tab');
            $("#behave3").removeClass('selected_tab');
            set_bahavior('user_defined','disabled',0);
            })
            
        
        $("#<?php echo $data['behavior']; ?>").addClass('selected_tab');
        
        })
        
        
        function set_bahavior(type,status,amount){
            $.post( "<?php echo Config::$base_url ?>/system/system_bahavoir.php",{type:type,status:status,amount:amount}).done(function(realb){
                 data=jQuery.parseJSON(realb);
              
              if(data.status==true){
                $("#message").addClass('alert alert-success');
                $("#message").html(data.message);
                
            }else{
                $("#message").addClass('alert alert-danger');
                $("#message").html("Error : "+data.message);
                }
              
                });
        }
        
        
        
        </script>
        
        
      <div class="behave"  id="behave1">
         
          <h4>Fixed Payment with Order ID</h4>
              
             <p>User will be directed to enter Order ID and then to pay the amount set here. </p>
             <label>Total Amount: </label>
             <input type="text" id="behave1_amt" value="100">
      </div>
        
      <div class="behave"  id="behave2">
         
            <h4>Fixed Payment without Order ID</h4>
              
             <p>User will be directed to pay the amount set here directly.</p>
             <label>Total Amount: </label>
             <input type="text" id="behave2_amt" value="100">
      </div>
        
        
     <div class="behave"  id="behave3">
         
            <h4>User defined Payment with Order ID</h4>
              
             <p>User will be prompted to enter desired amount and Order ID then will be directed to pay. </p>
      </div>
        
        
      <div class="behave"  id="behave4">
         
            <h4>User defined Payment without Order ID</h4>
              
             <p>User will be prompted to enter desired amount then will be directed to pay.</p>
      </div>
        
        
        
        
        
  </div>
</div>
