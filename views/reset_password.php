<body>
    


<!-- Interactive Login - START -->
<div class="container">
    <div class="row">
        <div id="contentdiv" class="contcustom">
            
            <div style="color: red;" id="message"></div>
            <div><form id="login_form" method="post" action="<?php echo base_url; ?>/admin/password_request.php">
                    <input type="email" id="email" placeholder="Email" required>
                   
                    <div id="captcha">
                            <?php
                            echo "<img src='".Config::$base_url."/captcha/".time().".php'/>";
                            ?>
                    </div>
                    <input id="captchaval"  type="text" name="captcha" placeholder="Text in above image." required>
                    <input type="submit" value="Reset Password">
                </form>
            </div>
            <a href="index.php">Login</a>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#login_form").submit(function(submit_form){
        submit_form.preventDefault();
        
             var email=$("#email").val();
             var captcha=$("#captchaval").val();
             $.post( "<?php echo Config::$base_url ?>/admin/password_request.php",{email:email,captcha:captcha}).done(function(realb){
                 data=jQuery.parseJSON(realb);
              
              if(data.status==true){
                $("#message").html(data.message);
                
                $("#message").html(data.message);
            }else{
                $("#message").html("Error : "+data.message);
                }
              
                });
    })
    
    
    
    
    
    
    
    
    var options={
        //target:'#message',
       //beforeSubmit:  validate,  // pre-submit callback 
        success:       showResponse ,  // post-submit callback 
    }

     //   $('#login_form').ajaxForm();
    
   
    function showResponse(responseText, statusText, xhr, $form)  { 
        
            var data=jQuery.parseJSON(responseText);
             
            
           
        }  
        
});

    
</script>

<style>
.redborder {
    border:2px solid #f96145;
    border-radius:2px;
}

.hidden {
    display: none;
}

.visible {
    display: normal;
}

.colored {
    background-color: #F0EEEE;
}

.row {
    padding: 20px 0px;
}

.bigicon {
    font-size: 97px;
    color: #E2E2E2;
}

.contcustom {
    text-align: center;
    width: 300px;
    border-radius: 0.5rem;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: 10px auto;
    background-color: #ffffff;
    border: solid thin #ABABAB;
    
    padding: 20px;
}

input {
    width: 100%;
    margin-bottom: 17px;
    padding: 15px;
    background-color: #ECF4F4;
    border-radius: 2px;
    border: thin solid #ABABAB;
}

h2 {
    margin-bottom: 20px;
    font-weight: bold;
    color: #ABABAB;
}

.btn {
    border-radius: 2px;
    padding: 10px;
}

.med {
    font-size: 27px;
    color: white;
}

.medhidden {
    font-size: 27px;
    color: #f96145;
    padding: 10px;
    width:100%;
}

.wide {
    background-color: #8EB7E4;
    width: 100%;
    -webkit-border-top-right-radius: 0;
    -webkit-border-bottom-right-radius: 0;
    -moz-border-radius-topright: 0;
    -moz-border-radius-bottomright: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
</style>

<!-- Interactive Login - END -->

    
</body>
</html>