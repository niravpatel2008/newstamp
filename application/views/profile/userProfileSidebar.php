<aside class="profile-nav col-lg-3">
  <section class="panel">
	  <div class="user-heading round">
		<?php
			if(isset($this->front_session['u_photo']) && $this->front_session['u_photo'] != '')
				$uphoto = $this->front_session['u_photo'];
			else
				$uphoto = 'nophoto.jpg';
			$mywebsite = $this->front_session['u_url'];
		?>
		  <a href="#">
			<img id="imgUserPhoto" alt="Profile Pic" imgname="<?=$uphoto?>" src="<?=base_url().UPLOADPATH.$uphoto;?>">
		</a>
		
		 <span id="changePic"><a href="#" data-target="#dlgProfilePic" data-toggle="modal" style="color:#fff;">Change Picture</a></span>
		  <h1><?= ucwords($this->front_session['u_fname'].' '.$this->front_session['u_lname']);?></h1>
		  <p><?=$this->front_session['u_email'];?></p>
		  <?php
			if($mywebsite != '')
				echo '<p><a href="'.$mywebsite.'" style="" id="myurlLink" target="_blank">View My Website</a></p>';
				?>
	  </div>

	  <ul class="nav nav-pills nav-stacked" id="mainCont">
		  <li class="active"><a href="<?=base_url()?>profile"> <i class="fa fa-user"></i> Profile View</a></li>
		  <li><a href="<?=base_url()?>profile/edit"> <i class="fa fa-edit"></i>Edit Profile</a></li>
		  <li><a href="<?=base_url()?>profile/change_password"> <i class="fa fa-edit"></i>Change Password</a></li>
		  <li style="" id="accordion1">
			<a href="#childAlbum" data-toggle="collapse"  data-parent="#accordion1">
				<i class="fa fa-calendar"></i>Album
			</a>
			<?php
				if(!empty($this->session_album))
				{
					echo '<ul class="collapse" id="childAlbum" style="padding-left: 50px;">';
					foreach($this->session_album as $k => $v)
					{
						echo "<li><a href=".base_url()."album/edit/".$v->al_id."><i class='fa fa-book'></i> ".$v->al_name." </a></li>"; 
					 }
					echo "</ul>";
				}else
				{
					echo '<ul class="collapse" id="childAlbum" style="padding-left: 50px;">';
					echo "<li><a href=".base_url()."album/add/><i class='fa fa-plus'></i> Add Album </a></li>"; 
					echo "</ul>";
				}
			?>
		</li>
		  <li><a href="<?=base_url()?>profile/mystamp"> <i class="fa fa-picture-o"></i> Stamps</a></li>
	  </ul>

  </section>
</aside>


<div id="dlgProfilePic" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#ff766c;">		
				<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
				<h3 class="modal-title"><i class="fa fa-shopping-cart"></i> Upload Photo :</h3>
			</div>
			<div class="modal-body">
				<div>
				<form id="frmAddPhoto" method="post" enctype="multipart/form-data" action="<?=base_url()?>profile/fileupload">
						<input type="hidden" id="hdnOldPhoto" name="hdnOldPhoto" value="" />
						<input type="file" id="profile_photo" name="profile_photo" style="" />
						<button type="submit" class="btn btn-primary btn-login" style="margin-top:10px !important;" id="btnPhotoSubmit">Add</button>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>