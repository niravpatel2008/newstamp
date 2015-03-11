<div class='container'>
<div class='stripe-regular items-carousel-wrap row'>
<div class="box box-site-header">
	<div class="box-header">
		<center><h1 class='page-title'> Contact us </h1></center>
	</div>
</div>
<div id="flash_msg">
		<?php
			if (@$flash_msg['flash_type'] == "success") {
				echo $flash_msg['flash_msg'];
			}

			if (@$flash_msg['flash_type'] == "error") {
				echo $flash_msg['flash_msg'];
			}
		?>
</div>
<div class="box">
	<form action="#" method="post">
	<div class="box-body clearfix" style='margin-top:18px;'>
		<div class='col-sm-4'>
			<img src="<?=public_path()?>images/contactus.jpg" alt="Contact Us" title="Contact Us" style="height:271px;"/>
		</div>
		<div class='col-sm-8'>
			<div class="form-group <?=(@$error_msg['name'] != '')?'has-error':'' ?>">
				<?php
					if(@$error_msg['name'] != ''){
				?>
					<label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['name']?></label><br/>
				<?php
					}
				?>
				<input type="name" class="form-control" name="name" placeholder="Name:"/>
			</div>
			<div class="form-group <?=(@$error_msg['email'] != '')?'has-error':'' ?>">
				<?php
					if(@$error_msg['email'] != ''){
				?>
					<label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['email']?></label><br/>
				<?php
					}
				?>
				<input type="email" class="form-control" name="email" placeholder="Email:"/>
			</div>
			<div class="form-group">
				<input type="contact" class="form-control" name="contact" placeholder="Contact No:"/>
			</div>
			<div class="form-group <?=(@$error_msg['email'] != '')?'has-error':'' ?>">
				<?php
					if(@$error_msg['message'] != ''){
				?>
					<label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['message']?></label><br/>
				<?php
					}
				?>
				<textarea class="textarea form-control" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name='message' id='message'></textarea>
			</div>
		</div>
	</div>
	<div class="box-footer clearfix" style='border-top:none;'>
		<button type="submit" id="sendEmail" class="btn btn-primary pull-right">Send</button>
	</div>
	</form>
</div>
</div>
</div>