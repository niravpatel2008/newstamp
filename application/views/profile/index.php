<!--<div style="width:800px; padding:15px; margin:0 auto;">
	<h3>Profile page</h3>
	<a href="<?=base_url()?>profile/edit">Edit</a>&nbsp;&nbsp;
	<a href="<?=base_url()?>profile/change_password">Change Password</a>
</div>
-->
<?php 
//pr($userinfo);
$info = get_object_vars($userinfo[0]);
if($info['u_birthdate'] != '' && $info['u_birthdate'] != '0000-00-00 00:00:00')
	$bDate = date('jS M,Y',strtotime($info['u_birthdate']));
else
	$bDate = '';
?>
<div class="row">
<?php $this->load->view('profile/userProfileSidebar');?>
	<aside class="profile-info col-lg-9">
		<section class="panel">
			<form>
				<textarea id="txtBioStatus" class="form-control input-lg p-text-area" rows="2" placeholder="Share Your Biography Here !!" style="color:#89817e;"></textarea>
			 </form>
			 <footer class="panel-footer clearfix">
				  <button class="btn btn-danger pull-right" id="btnPost">Post</button>
				 <!-- <ul class="nav nav-pills">
					  <li>
						  <a href="#"><i class="fa fa-map-marker"></i></a>
					  </li>
					  <li>
						  <a href="#"><i class="fa fa-camera"></i></a>
					  </li>
					  <li>
						  <a href="#"><i class=" fa fa-film"></i></a>
					  </li>
					  <li>
						  <a href="#"><i class="fa fa-microphone"></i></a>
					  </li>
				  </ul>-->
			  </footer>
		  </section>
		  <section class="panel">
			  <div class="bio-graph-heading" id="divBio">
				<?php
					if($info['u_bio'] == '')
						echo "Welcome !! Share Your Historical Stamps Collection here and Brings them to World ";
					else
						echo $info['u_bio'];
				?>
			  </div>
			  <div class="panel-body bio-graph-info">
				  <h1>Bio Graph</h1>
				  <div class="row">
					  <div class="bio-row">
						  <p><span>First Name </span>: <?=$info['u_fname'];?></p>
					  </div>
					  <div class="bio-row">
						  <p><span>Last Name </span>: <?=$info['u_lname'];?></p>
					  </div>
					  <div class="bio-row">
						  <p><span>Email </span>: <?=$info['u_email'];?></p>
					  </div>
					  <div class="bio-row">
						  <p><span>Phone </span>: <?=$info['u_phone'];?></p>
					  </div>
					  <div class="bio-row">
						  <p><span>Birthday</span>: <?=$bDate;?></p>
					  </div>
					  <div class="bio-row">
						  <p><span>Country </span>: <?=$info['u_country'];?></p>
					  </div>
					  <div class="bio-row">
						  <p><span>State </span>: <?=$info['u_state'];?></p>
					  </div>
					  <div class="bio-row">
						  <p><span>City </span>: <?=$info['u_city'];?></p>
					  </div>
				  </div>
			  </div>
		  </section>
		  <!--<section>
			  <div class="row">
				  <div class="col-lg-6">
					  <div class="panel">
						  <div class="panel-body">
							  <div class="bio-chart">
								  <div style="display:inline;width:100px;height:100px;"><canvas height="100px" width="100"></canvas><input data-bgcolor="#e8e8e8" data-fgcolor="#e06b7d" value="35" data-thickness=".2" data-displayprevious="true" data-height="100" data-width="100" class="knob" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px none; background: none repeat scroll 0% 0% transparent; font: bold 20px Arial; text-align: center; color: rgb(224, 107, 125); padding: 0px;"></div>
							  </div>
							  <div class="bio-desk">
								  <h4 class="red">Envato Website</h4>
								  <p>Started : 15 July</p>
								  <p>Deadline : 15 August</p>
							  </div>
						  </div>
					  </div>
				  </div>
				  <div class="col-lg-6">
					  <div class="panel">
						  <div class="panel-body">
							  <div class="bio-chart">
								  <div style="display:inline;width:100px;height:100px;"><canvas height="100px" width="100"></canvas><input data-bgcolor="#e8e8e8" data-fgcolor="#4CC5CD" value="63" data-thickness=".2" data-displayprevious="true" data-height="100" data-width="100" class="knob" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px none; background: none repeat scroll 0% 0% transparent; font: bold 20px Arial; text-align: center; color: rgb(76, 197, 205); padding: 0px;"></div>
							  </div>
							  <div class="bio-desk">
								  <h4 class="terques">ThemeForest CMS </h4>
								  <p>Started : 15 July</p>
								  <p>Deadline : 15 August</p>
							  </div>
						  </div>
					  </div>
				  </div>
				  <div class="col-lg-6">
					  <div class="panel">
						  <div class="panel-body">
							  <div class="bio-chart">
								  <div style="display:inline;width:100px;height:100px;"><canvas height="100px" width="100"></canvas><input data-bgcolor="#e8e8e8" data-fgcolor="#96be4b" value="75" data-thickness=".2" data-displayprevious="true" data-height="100" data-width="100" class="knob" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px none; background: none repeat scroll 0% 0% transparent; font: bold 20px Arial; text-align: center; color: rgb(150, 190, 75); padding: 0px;"></div>
							  </div>
							  <div class="bio-desk">
								  <h4 class="green">VectorLab Portfolio</h4>
								  <p>Started : 15 July</p>
								  <p>Deadline : 15 August</p>
							  </div>
						  </div>
					  </div>
				  </div>
				  <div class="col-lg-6">
					  <div class="panel">
						  <div class="panel-body">
							  <div class="bio-chart">
								  <div style="display:inline;width:100px;height:100px;"><canvas height="100px" width="100"></canvas><input data-bgcolor="#e8e8e8" data-fgcolor="#cba4db" value="50" data-thickness=".2" data-displayprevious="true" data-height="100" data-width="100" class="knob" style="width: 54px; height: 33px; position: absolute; vertical-align: middle; margin-top: 33px; margin-left: -77px; border: 0px none; background: none repeat scroll 0% 0% transparent; font: bold 20px Arial; text-align: center; color: rgb(203, 164, 219); padding: 0px;"></div>
							  </div>
							  <div class="bio-desk">
								  <h4 class="purple">Adobe Muse Template</h4>
								  <p>Started : 15 July</p>
								  <p>Deadline : 15 August</p>
							  </div>
						  </div>
					  </div>
				  </div>
			  </div>
		  </section>-->
	  </aside>
  </div>