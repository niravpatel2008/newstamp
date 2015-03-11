<?php $this->load->view('profile/userProfileSidebar');?>
<aside class="profile-info col-lg-9">
	<div class="panel-body bio-graph-info" style="padding-top:0px;">
		<input type="hidden" id="hdnSearchUid" name="hdnSearchUid" value="<?=$this->front_session['id'];?>"/>
		<input type="hidden" id="hdnCurrPage" name="hdnCurrPage" value="1" />
		<input type="hidden" id="hdnRecLimit" name="hdnRecLimit" value="21" />
		<input type="hidden" id="hdnTotalRec" name="hdnTotalRec" value="" />
		<input type="hidden" id="pageFrom" name="pageFrom" value="userdashboard"/>
		<p style="text-align:right;width:100%;">
			<a class="btn btn-round btn-danger" id="btnAddUserStamp" href="<?=base_url()?>profile/addalbum"><i class="fa fa-plus"></i> Add Album</a>
		</p>
		<div id="mainAlbumContainer" class="row js-trick-container" style="position: relative; height: 771px;">
	</div>
</aside>