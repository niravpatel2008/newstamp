<header class="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <!-- MAIN NAVIGATION -->
                        <div class="flexnav-menu-button" id="flexnav-menu-button">Menu</div>
                        <nav>
                            <ul class="nav nav-pills flexnav" id="flexnav" data-breakpoint="800">
								<li <?=($view == 'index')?"class='active'":"" ?>><a href="<?=base_url()?>">Home</a></li>
								<li <?=($view == 'album')?"class='active'":"" ?>><a href="<?=base_url()?>album">Album</a></li>
                                <li <?=($view == 'contactus')?"class='active'":"" ?>><a href="<?=base_url()?>contactus">Contact Us</a></li>
								<li <?=($view == 'aboutus')?"class='active'":"" ?>><a href="<?=base_url()?>aboutus">About Us</a></li>
                            </ul>
                        </nav>
                        <!-- END MAIN NAVIGATION -->
                    </div>
                    <div class="col-md-6">
                        <!-- LOGIN REGISTER LINKS -->
						<?php if($this->front_session['id'] > 0) { ?>
                       <ul class="login-register">
							<li class="dropdown ">
								<a data-toggle="dropdown" class="dropdown-toggle btn btn-primary" href="#">
									Welcome <?=$this->front_session['u_fname']?>
									<b class="caret"></b>
								 </a>
								<ul class="dropdown-menu">
									<li class=""><a href="<?=base_url()?>profile/">Profile</a></li>
									<li class=""><a href="<?=base_url()?>profile/change_password">Change Password</a></li>
									<li><a href="<?=base_url()?>profile/logout">Logout</a></li>
								</ul>
							</li>
						</ul>
						<?php }else{ ?>
						 <ul class="login-register">
                            <li><a class="popup-text" href="#login-dialog" data-effect="mfp-move-from-top"><i class="fa fa-sign-in"></i>Sign in</a>
                            </li>
                            <li><a class="popup-text" href="#register-dialog" data-effect="mfp-move-from-top"><i class="fa fa-edit"></i>Sign up</a>
                            </li>
                        </ul>
						<?php }?>
                    </div>
                </div>
            </div>
        </header>