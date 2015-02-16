<script>
	$(document).ready(function(){
		var base_url=document.URL;
		
		$("#base_url").val(base_url.substring(0, base_url.length - 9));
	});
	
</script>
<form method="POST">
	<div class="form-group">
		<label for="base_url">Base URL</label>
		<input type="url" class="form-control" name="base_url" value="<?php if(!empty($base_url)) echo $base_url ?>" id="base_url" required placeholder="Base URL">
		<p class="help-block">Example: http:myphonepay.com/phonepay or http:myphonepay.com</p>
	</div>
	
	<div class="form-group">
		<label for="db_host">Database Host</label>
		<input type="text" class="form-control" name="db_host" value="<?php if(!empty($db_host)) echo $db_host ?>" id="db_host" required placeholder="Database host">
		<p class="help-block">Example: localhost</p>
	</div>
	
	<div class="form-group">
		<label for="db_name">Database Name</label>
		<input type="text" class="form-control" name="db_name" value="<?php if(!empty($db_name)) echo $db_name ?>" id="db_name" required placeholder="Database">
	</div>
	<div class="form-group">
		<label for="db_user">Database User</label>
		<input type="text" class="form-control" name="db_user" value="<?php if(!empty($db_user)) echo $db_user ?>" id="db_user" required placeholder="Database user">
	</div>
	<div class="form-group">
		<label for="db_pass">Database Password</label>
		<input type="password" class="form-control" name="db_pass" value="<?php if(!empty($db_pass)) echo $db_pass ?>" id="db_pass" required placeholder="Database password">
	</div>
	
	<div class="form-group">
		<input type="submit" class="btn btn-primary" class="form-control" name="step1"  id="step1" value="Next">
	</div>
</form>