<style>
	.panel-heading a:after {
    font-family:'Glyphicons Halflings';
    content:"\e114";
    float: right;
    color: grey;
}
.panel-heading a.collapsed:after {
    content:"\e080";
}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Help</h2>
			</div>
			<div class="panel-body">
				<div class="panel-group" id="accordion">
				    
				     <div class="panel panel-default" id="panel2">
				        <div class="panel-heading">
				             <h4 class="panel-title">
				        <a data-toggle="collapse" data-target="#collapseOne" 
				           href="#collapseOne" class="collapsed">
				          How to set up Twilio number ?
				        </a>
				      </h4>
				
				        </div>
				        <div id="collapseOne" class="panel-collapse collapse">
				            <div class="panel-body">
					            <p>
					            	Go to your Twilio account and select number you wish to integrate with Phone Pay.
					            	Change Request URL for Voice calls to http://yourdomain.com/twiml.php. 
					            	Change yourdomain.com to base url of your phone pay installation.
					            </p>
				            </div>
				        </div>
				    </div>
				    
				    <div class="panel panel-default" id="panel2">
				        <div class="panel-heading">
				             <h4 class="panel-title">
				        <a data-toggle="collapse" data-target="#collapseTwo" 
				           href="#collapseTwo" class="collapsed">
				          How to change Stripe account details ?
				        </a>
				      </h4>
				
				        </div>
				        <div id="collapseTwo" class="panel-collapse collapse">
				            <div class="panel-body">
					            <p>
					            	Stripe account details can be changed in file application/config.php.
					            	Change $secret_key to your Stripe secret key and change $public_key to your Stripe public key.
					            </p>
				            </div>
				        </div>
				    </div>
				        <div class="panel panel-default" id="panel2">
				        <div class="panel-heading">
				             <h4 class="panel-title">
				        <a data-toggle="collapse" data-target="#collapseThree" 
				           href="#collapseThree" class="collapsed">
				          How to change database details ?
				        </a>
				      </h4>
				
				        </div>
				        <div id="collapseThree" class="panel-collapse collapse">
				            <div class="panel-body">
					            <p>
					            	Database details can be changed in file application/config.php
					            </p>
				            </div>
				        </div>
				    </div>
				    
				    <div class="panel panel-default" id="panel3">
				        <div class="panel-heading">
				             <h4 class="panel-title">
				        <a data-toggle="collapse" data-target="#collapseFour"
				           href="#collapseFour" class="collapsed">
				           How to change system behavior ?
				        </a>
				      </h4>
				
				        </div>
				        <div id="collapseFour" class="panel-collapse collapse">
				            <div class="panel-body">
				            	<p>
					            	Select Settings from left menu , go to System Behavior panel and select your
					            	preferred System Behavior. Dont forget to change Total Amount if you are choosing 
					            	fixed payment mode.
					            </p>
				            </div>
				        </div>
				    </div>
				    
				    <div class="panel panel-default" id="panel3">
				        <div class="panel-heading">
				             <h4 class="panel-title">
				        <a data-toggle="collapse" data-target="#collapseFive"
				           href="#collapseFive" class="collapsed">
				           How to change IVR messages ?
				        </a>
				      </h4>
				
				        </div>
				        <div id="collapseFive" class="panel-collapse collapse">
				            <div class="panel-body">
				            	<p>
					            	Phone Pay IVR messages are defined in file application/ivr_message.ini. 
					            	You can change any message by replacing existing text to your message.
					            </p>
				            </div>
				        </div>
				    </div>
				    
				    
				    
				</div>
			</div>
		</div>
	</div>
</div>