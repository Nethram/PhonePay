<?php 


?>

<form method="POST">
	<div class="form-group">
		<label for="base_url">Stripe Public Key</label>
		<input type="text" class="form-control" name="pub_key" value="<?php if(!empty($pub_key)) echo $pub_key ?>" id="pub_key" required placeholder="Stripe Public Key">
		<p class="help-block">Get public key from Stripe</p>
	</div>
	
	<div class="form-group">
		<label for="db_host">Stripe Scret Key</label>
		<input type="text" class="form-control" name="sec_key" value="<?php if(!empty($sec_key)) echo $sec_key ?>" id="sec_key" required placeholder="Stripe Secret Key ">
		<p class="help-block">Get secret key from Stripe</p>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" class="form-control" name="step2"  id="step2" value="Next">
	</div>
</form>