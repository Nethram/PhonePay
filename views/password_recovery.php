<div style="width: 400px; margin-left: auto; margin-right: auto;"><h3><?php echo $data['message']; ?></h3>
<?php if($data['status']): ?>    
<!-- modal login  -->
            <form method="post" id="savepass" action="<?php echo Config::$base_url ?>/admin/savepasswd.php">
                <input type="hidden" name="email" value="<?php echo $data['email']; ?>"/>
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
                    <button id="edit_btn" type="submit" class="btn btn-warning btn-sm">Save</button>
            </form>
 

<?php else: ?>
<i class="fa fa-times-circle fa-2x" style="color: red; text-shadow: 0px 0px 1px #000;"></i> 
<p>You can request for new link.</p>
<?php endif; ?></div>