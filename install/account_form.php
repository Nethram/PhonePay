
<form method="POST">
	<div class="form-group">
		<label for="base_url">Admin Email</label>
		<input type="email" class="form-control" name="email" value="<?php if(!empty($email)) echo $email ?>" id="email" required placeholder="Admin Email">
	</div>
	
	<div class="form-group">
		<label for="db_host">Create Password</label>
		<input type="password" class="form-control" name="password1" id="password1" required placeholder="Admin Password">
	</div>
	<div class="form-group">
		<label for="db_host">Confirm Password</label>
		<input type="password" class="form-control" name="password2" id="password2" required placeholder="Confirm Password">
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" class="form-control" name="step3"  id="step3" value="Finish">
	</div>
</form>