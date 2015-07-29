<div class="gap"></div>
  <div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="text-center">
				<h1>Explore Stamps here..</h1>
				<p class="text-bigger">Augue feugiat vulputate quam at dignissim aliquam vestibulum elit convallis iaculis dictumst dui taciti himenaeos taciti arcu non sollicitudin viverra id blandit cursus ac et mauris curabitur tortor feugiat nulla</p>
			</div>
		</div>
	</div>
	<div class="gap"></div>
</div>		
<form class="search-area form-group"  id="frmSearchStamp">
	<div class="container">
		<div class="row">
			<div class="col-md-11 clearfix">
				<label><i class="fa fa-search"></i></label>
				<div class="search-area-division search-area-division-input">
					<input id="txtSearchStamp" class="form-control" type="text" placeholder="Search stamp" />
				</div>
			</div>
			<div class="col-md-1">
				<input type="hidden" id="hdnCurrPage" name="hdnCurrPage" value="1" />
				<input type="hidden" id="hdnRecLimit" name="hdnRecLimit" value="21" />
				<input type="hidden" id="hdnTotalRec" name="hdnTotalRec" value="" />
				<input type="hidden" id="hdnSearchUid" name="hdnSearchUid" value="<?=$hdnUid;?>" />
				<input type="hidden" id="hdnTag" name="hdnTag" value="<?=$hdnTag;?>" />
				<input type="hidden" id="searchKeyword" name="searchKeyword" value="<?=$searchKeyword;?>" />
				<button class="btn btn-block btn-white search-btn" id="btnSearchStamp" type="submit">Search</button>
			</div>
		</div>
	</div>
</form>
<?php 
	if(isset($uinfoArr) && !empty($uinfoArr))
	{
		if($uinfoArr['u_photo'] != '')
			$uphoto = base_url().UPLOADPATH.$uinfoArr['u_photo'];
		else
			$uphoto = base_url().UPLOADPATH.'nophoto.jpg';

		?>
		<div class="container">
		<article class="comment">
			<div class="comment-author">
				<img title="Me with the Uke" alt="Image Alternative text" src="<?=$uphoto?>">
			</div>
			<div class="comment-inner">
				<span class="comment-author-name"><?=$uinfoArr['u_fname'].' '.$uinfoArr['u_lname']?> <?=($uinfoArr['u_country'] != "")?"(".$uinfoArr['u_country'].")":"" ?></span>
				<p class="comment-content"><?=$uinfoArr['u_bio']?></p>
			</div>
		</article>
		</div>
		<?php
	}
?>
<div class="gap"></div>

<div class="container">
	<div class="text-center">
		<h2 class="mb30">New Stamps</h2>
		<div class="row row-wrap" id="stamp_area"></div>	
		<a href="#" class="btn btn-primary btn-ghost">Explore All New Deals</a>
	</div>
	<div class="gap"></div>
</div>