<?php $this->load->view('profile/userProfileSidebar');?>
<aside class="profile-info col-lg-9">
	<div class="panel panel-body bio-graph-info" style="padding-top:0px;">
		<p style="margin:8px 0 0 0;text-align:right;width:100%;">
			<?php
			if($this->router->fetch_method() == 'edit'){
			echo '<a class="btn btn-round btn-danger" id="btnDeleteUserAlbum" href="javascript:void(0);"><i class="fa fa-trash-o"></i> Delete This Album</a>';
			}?>
			<a class="btn btn-round btn-danger" id="btnAddUserAlbum" href="<?=base_url()?>album/add/"><i class="fa fa-plus"></i> Add New Album</a>
		</p>
		<header class="panel-heading"><b><?=ucfirst($this->router->fetch_method());?> Album Here</b></header>
		<section class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<div class="box-body">
					<?php 
						if (@$flash_msg != "") {
					?>
						<div id="flash_msg"><?=$flash_msg?></div>
					<?php
						}
					?>
					<form id='album_form' name='album_form' role="form" action="" method="post" class="box-body">
						<input type='hidden' id='al_id' name='al_id' value='<?=(@$album[0]->al_id)?>'>
						<input type='hidden' id='t_dimension' name='t_dimension' value='<?=(@$ticket_collection)?>'>
						<input type='hidden' id='t_new_dimension' name='t_new_dimension' value=''>
						
						<div class="form-group <?=(@$error_msg['al_name'] != '')?'has-error':'' ?>">
							<?php
								if(@$error_msg['al_name'] != ''){
							?>
								<label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['al_name']?></label><br/>
							<?php
								}
							?>
							<label>Album Name:</label>
							<input type="text" placeholder="Enter ..." class="form-control validate[required]" name="al_name" id="al_name" value="<?=@$album[0]->al_name?>" title="Album Name">
						</div>
						<div class="form-group">
							<label>Country:</label>
							<input type="text" placeholder="Enter ..." class="form-control" name="al_country" id="al_country" value="<?=@$album[0]->al_country?>" title="Country">
						</div>
						<div class="form-group">
							<label>Price:</label>
							<input type="text" placeholder="Enter ..." class="form-control" name="al_price" id="al_price" value="<?=@$album[0]->al_price?>" title="Price" >
						</div>
						<div class="form-group">
							<label>Url:</label>
							<input type="text" placeholder="Enter ..." class="form-control validate[custom[url]" name="al_url" id="al_url" value="<?=@$album[0]->al_url?>" title="URL">
						</div>
						<div class="form-group clearfix dealuploaddiv" style="position:relative;"> <!-- Uploaded images will be shown here -->
							<input type='hidden' name='newimages' id='newimages'>
							<input type='hidden' name='sortOrder' id='sortOrder'>
							<input type='hidden' name='al_mainphoto' id='al_mainphoto' value='<?=(@$ticket_links[0]->link_url)?>'>
							<label for="">Select Album Image:</label>
							<?php if(count(@$ticket_links) == 0) {
								echo "<div class='form-group'>Please upload image for Album than you can select images for stamp.</div>";
							}?>
							
						</div>
					</form>
				 </div>
			</div>
			<?php if(count(@$ticket_links) == 0){?>
			<div class='col-md-6'>
				<div class='box box-info'>
					<div class="box-header">
						<h3 class="box-title">Upload Album Image</h3>
					</div>
					<div class="box-body">
						<form id="my-awesome-dropzone" action="<?=base_url()."album/fileupload"?>" class="dropzone">
							<input type='hidden' name='al_id' value='<?=(@$album[0]->al_id)?>'>
						</form>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
		<div class='row'>
			<div id='img-container' class='clearfix'>
				<?php if(@$ticket_links[0]->link_id != "") {?>
				<img id="albumImg" src='<?=(base_url()."uploads/stamp/".@$ticket_links[0]->link_url)?>' class='newimgFull' imgid = '<?=(@$ticket_links[0]->link_id)?>'>
				<br>
				<?php if(@$updateBtn) {?>
					<center>
						<a class="removeimage" link_id="<?=(@$ticket_links[0]->link_id)?>" href="#" title="Delete"><i class="fa fa-trash-o"></i></a>
						<button class="btn btn-primary btn-flat" style="margin-left:14px;" id="btn_createstamp">Update Stamp</button>
					</center>
				<?php }?>
				<?php } ?>
			</div>
		</div>
		<div class='row'>
				<div class="form-group" style="margin-left:17px;">
							<button class="btn btn-primary btn-flat" type="button" onclick="$('#album_form').submit();" id="submit">Submit</button>
				 </div>
		</div>  
		</section>
	</div>
</aside>
