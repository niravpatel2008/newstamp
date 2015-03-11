<?php $this->load->view('profile/userProfileSidebar');?>
<aside class="profile-info col-lg-9">
<div class="panel-body bio-graph-info" style="padding-top:0px;">
	<div class="content-box login-form">
		<h1 class="page-title">Change Password</h1>
		<div id="flash_msg">
		<?php
			if (@$flash_msg['flash_type'] == "success") {
			echo @$flash_msg['flash_msg'];
		}

			if (@$flash_msg['flash_type'] == "error") {
			echo @$flash_msg['flash_msg'];
		}
		?>
	</div>

	<form method="POST" name="frmChangePwd" id="frmChangePwd" accept-charset="UTF-8">
		<div class="form-group">
			<label for="username" class="control-label">New Password:</label>
			<input class="validate[required] form-control" type="password" name="password" id="change_password" value="">
		</div>
		<div class="form-group">
			<label for="password" class="control-label">Repeat Password:</label>
			<input class="validate[required,equals[change_password]] form-control" type="password" name="re_password" id="re_password" value="">
		</div>
			
		<div class="form-group">
			<button type="submit" name="pwd_submit" id="pwd_submit" class="btn btn-primary btn-block btn-login">Submit</button>
		</div>
	</form>
	</div>
</div>
</aside>