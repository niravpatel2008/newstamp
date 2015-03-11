<div class="row">
	<div class="col-lg-9 col-md-8">
		<div class="content-box">
			<div class="trick-user">
				<div class="trick-user-image">
					<img class="user-avatar" src="<?=$details['stamp_photo'];?>">
				</div>
				<div class="trick-user-data">
					<h1 class="page-title">
						<?= $details['t_name'];?>
					</h1>
					<div>
						Posted by <b><a href="#"><?= $details['user_fullname'];?></a></b> - <?= $details['t_modified_date'];?>
					</div>
				</div>
			</div>
			
			<pre>
				<code class="php">
					<span class=""><?=$details['t_bio'];?></span>
				</code>
			</pre>

			<div>
				<h1 class="page-title">View All Stamps Here :-</h1>
				<?php
					foreach($details['all_photos'] as $k=>$v)
						echo '<img src="'.$v.'" class="stampDetail" alt="Stamp" title="Stamp-'.$details['t_name'].'"/>';
				?>
				
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-4">
		<div class="content-box">
			<b>Stats</b>
			<ul class="list-group trick-stats">
				<a data-liked="0" class="list-group-item js-like-trick" href="#">
					<span class="fa fa-heart "></span>24 likes
				</a>
				<li class="list-group-item">
					<span class="fa fa-eye"></span> 5106 views
				</li>
			</ul>
			<b>Categories</b>
			<ul class="nav nav-list push-down">
				<li>
					<a href="http://www.laravel-tricks.com/categories/eloquent">
						Eloquent
					</a>
				</li>
				<li>
					<a href="http://www.laravel-tricks.com/categories/form">
						Form
					</a>
				</li>
				<li>
					<a href="http://www.laravel-tricks.com/categories/views">
						Views
					</a>
				</li>
			</ul>
			<?php
				if(!empty($details['all_tags']))
				{ ?>
				<b>Tags</b>
				<ul class="nav nav-list push-down">
					<?php
						foreach($details['all_tags'] as $k => $v)
						{
							echo '<li><a href="'.base_url().'tags/'.$v['tag_name'].'">'.$v['tag_name'].'</a></li>';
						}
					?>
				</ul>
			<?php }?>
			<div class="clearfix">
				<a class="btn btn-sm btn-primary" data-toggle="tooltip" title="" href="http://www.laravel-tricks.com/tricks/create-your-own-anything-trickscom" data-original-title="Create your own Anything-tricks.com!">
					« Previous Trick
				</a>
				
				<a class="btn btn-sm btn-primary pull-right" data-toggle="tooltip" title="" href="http://www.laravel-tricks.com/tricks/using-eloquentfirstorcreate-to-prevent-duplicate-seeding" data-original-title="Using Eloquent::firstOrCreate() to prevent duplicate seeding">
						Next Trick »
				</a>
			</div>
		</div>
	</div>
</div>
</div>