<?php $this->load->view('profile/userProfileSidebar'); ?>
<aside class="profile-info col-lg-9">
<div class="panel-body bio-graph-info" style="padding-top:0px;">
		<div class="content-box register-form">
			<h1 class="page-title">Edit Profile</h1>
			<div id="flash_msg">
			<?php
				if (@$flash_msg['flash_type'] == "success") {
					echo $flash_msg['flash_msg'];
				}

				if (@$flash_msg['flash_type'] == "error") {
					echo $flash_msg['flash_msg'];
				}
				//echo '<pre>';print_r($userinfo);die;
				$check = $userinfo[0]->u_gender;
				if($check == '')
					$check = 'm';
			?>
		</div>

		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="username" class="control-label">First Name: </label> 
				<input class='form-control' type="text" name="fname" id="fname" value="<?=$this->front_session['u_fname']?>">
			</div>
			<div class="form-group">
				<label for="username" class="control-label">Last Name: </label> 
				<input class='form-control' type="text" name="lname" id="lname" value="<?=$this->front_session['u_lname']?>">
			</div>
			<div class='form-group'>
				<label for="email" class="control-label" title="Email Can't be Edit">Email: </label> 
				<input class='form-control' type="text" name="email" id="email" value="<?=$userinfo[0]->u_email;?>" readonly title="Email Can't be Edit">
			</div>
			<div class='form-group'>
				<label for="contact" class="control-label">Contact: </label> 
				<input class='form-control' type="text" name="contact" id="contact" value="<?=$userinfo[0]->u_phone;?>">
			</div>
			<div class='form-group'>
				<label for="gender" class="control-label" style="width:100%">Gender </label> 
				<input class='' type="radio" name="gender" id="gender_m" value="m" <?php if($check == 'm') echo 'checked';?>> Male
				<input class='' type="radio" name="gender" id="gender_f" value="f" <?php if($check == 'f') echo 'checked'?>> Female
			</div>
			<div class='form-group'>
				<label for="email" class="control-label" title="Enter Your Website URL">Your Website </label> 
				<input class='form-control' type="text" name="website" id="website" value="<?=$userinfo[0]->u_url;?>"  title="Enter Your Website URL">
			</div>
			<div class='form-group'>
				<label for="city" class="control-label">About Me (Biography) </label> 
				<textarea class="form-control" id="bio" name="bio" title="Say something about you" rows="6"><?=@$userinfo[0]->u_bio?></textarea>
			</div>
			<div class='form-group'>
				<label for="country" class="control-label">Country: </label> 
				<input class='form-control' type="text" name="country" id="country" value="<?=$userinfo[0]->u_country;?>">
			</div>
			<div class='form-group'>
				<label for="state" class="control-label">State: </label> 
				<input class='form-control' type="text" name="state" id="state" value="<?=$userinfo[0]->u_state;?>">
			</div>
			<div class='form-group'>
				<label for="city" class="control-label">City: </label> 
				<input class='form-control' type="text" name="city" id="city" value="<?=$userinfo[0]->u_city;?>">
			</div>
			<div class='form-group'>
				<label for="country" class="control-label">Birthdate: </label> 
				<input class='form-control' type="text"  name="birthdate" id="birthdate" value="<?=$userinfo[0]->u_birthdate;?>" readonly>
			</div>
			<!--<div class='form-group'>
				<label for="country" class="control-label">Change Your Photo </label>
				<input type="file" id="profile_photo" name="profile_photo" style="padding:5px 5px 5px 0;"/>
			</div>-->
			<div class="form-group">
				<button type="submit" name="submit" id="submit"  class="btn btn-primary btn-block btn-login">Submit</button>
			</div>
			<div class="clearboth" style="height:10px"></div>
		</form>
	</div>
</div>

<!--<div class="row panel-body">
  <div class="col-lg-12">
	  <div class="panel">
		  <div class="panel-body">
			  <span style="text-align:center;font-size:16px;"><a href="javascript:void(0);" id="btnDeleteAcc" title="Delete Account" >Delete My Account</a></span>
		  </div>
	  </div>
  </div>
</div>-->

</aside>
