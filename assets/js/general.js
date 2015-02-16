$(document).ready(function(){
   
   
var options={ 
        beforeSubmit: showLoading,
        success:       showResponse  // post-submit callback 
                }; 

$("#savepass").ajaxForm(options);
$("#change_account").ajaxForm(options);
   
});
   


function showLoading(){
    $(".loading").removeClass('hidden');
}



function showResponseLogin(responseText, statusText, xhr, $form)  { 
            var data=jQuery.parseJSON(responseText);
            if(data.status==true){
                $(".message").addClass("alert alert-success").removeClass("alert-danger");
                $(".message").html(data.message);
                location.reload();
            }else{
                $(".message").addClass("alert alert-danger").removeClass("alert-success");
                $(".message").html(data.message);
            }
            $(".loading").addClass('hidden');
            
        }   



function showResponse(responseText, statusText, xhr, $form)  { 
            var data=jQuery.parseJSON(responseText);
            if(data.status==true){
                $(".message").addClass("alert alert-success").removeClass("alert-danger");
                $(".message").html(data.message);
            }else{
                $(".message").addClass("alert alert-danger").removeClass("alert-success");
                $(".message").html(data.message);
            }
            $(".loading").addClass('hidden');
            
        }   
        
        
function newCaptcha(){
    var timestamp = Number(new Date());
        $("#captcha").html();
        $("#captcha").html("<img src='"+$("#base_url").val()+"/captcha/"+timestamp+".php'/><span id='captcha_raload' onclick='newCaptcha()'><img  src='"+$("#base_url").val()+"/assets/images/reload.png' /></span>");   
  }
  
  
  
  