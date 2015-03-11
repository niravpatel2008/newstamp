<!-- LOGIN REGISTER LINKS CONTENT -->
        <div id="login-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
            <i class="fa fa-sign-in dialog-icon"></i>
            <h3>Member Login</h3>
            <h5>Welcome back, friend. Login to get started</h5>
			<form  class="dialog-form" method="POST" name="loginform" id="loginform" accept-charset="UTF-8">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" placeholder="email@domain.com" class="validate[required,custom[email]] form-control" id="txtuseremail" name="txtuseremail">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input placeholder="My secret password" class="validate[required] form-control" id="txtpassword" type="password" name="txtpassword" >
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox">Remember me
                    </label>
                </div>
                <input type="submit" value="Sign in" class="btn btn-primary">
            </form>
            <ul class="dialog-alt-links">
                <li><a class="popup-text" href="#register-dialog" data-effect="mfp-zoom-out">Not member yet</a>
                </li>
                <li><a class="popup-text" href="#password-recover-dialog" data-effect="mfp-zoom-out">Forgot password</a>
                </li>
            </ul>
        </div>


        <div id="register-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
            <i class="fa fa-edit dialog-icon"></i>
            <h3>Member Register</h3>
            <h5>Ready to get best offers? Let's get started!</h5>
            <form class="dialog-form" name="signupform" id="signupform" method="post" accept-charset="UTF-8">
				<div class="form-group">
					<label for="username" class="control-label">Name</label>
					<input class="validate[required] form-control" name='name' id='name' placeholder="Name" type="text">
				</div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input class="validate[required,custom[email]] form-control" placeholder="E-mail" name="email" type="text" id="email">
                </div>
                <div class="form-group">
                    <label>Password</label>
					<input class="validate[required] form-control" placeholder="My secret password" name="password" type="password" value="" id="password">
                </div>
                <div class="form-group">
                    <label>Repeat Password</label>
					<input class="validate[required,equals[password]] form-control" placeholder="Type your password again" name="password2" type="password" value="" id="password2">
                </div>
                <input type="submit" id='signup' value="Sign up" class="btn btn-primary">
            </form>
            <ul class="dialog-alt-links">
                <li><a class="popup-text" href="#login-dialog" data-effect="mfp-zoom-out">Already member</a>
                </li>
            </ul>
        </div>


        <div id="password-recover-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
            <i class="icon-retweet dialog-icon"></i>
            <h3>Password Recovery</h3>
            <h5>Fortgot your password? Don't worry we can deal with it</h5>
            <form class="dialog-form" name="forgotpwdform" id="forgotpwdform" accept-charset="UTF-8">
                <label>E-mail</label>
				<input class="form-control validate[required,custom[email]]" placeholder="email@domain.com" name="txtemail" type="text" id="txtemail">
                <input name="forgotpassword" id="forgotpassword" type="submit" value="Request new password" class="btn btn-primary">
            </form>
        </div>
        <!-- END LOGIN REGISTER LINKS CONTENT -->