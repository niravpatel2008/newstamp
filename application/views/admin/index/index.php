<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=public_path()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?=public_path()?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?=public_path()?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<script src="<?=public_path()?>js/jquery-2.1.1.min.js"></script>
		<script src="<?=public_path()?>js/jquery.cookie.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="<?=base_url()?>admin/index" method="post">
                <div class="body bg-gray">
                    <?php
                        if(@$error_msg['invalid_login'] != ''){
                    ?>
                        <div class="box box-solid box-danger">
                            <div class="box-header">
                                <h3 class="box-title"><?=$error_msg['invalid_login']?></h3>
                                <div class="box-tools pull-right">
                                    <button data-widget="collapse" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                                    <button data-widget="remove" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    <div class="form-group <?=(@$error_msg['userid'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['userid'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['userid']?></label>
                        <?php
                            }
                        ?>
                        <input type="text" id="txtUsername" name="userid" class="form-control allow-enter" placeholder="User ID" value="<?php if(isset($_COOKIE['uname'])) echo $_COOKIE['uname']; ?>"/>
                    </div>
                    <div class="form-group <?=(@$error_msg['password'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['password'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['password']?></label>
                        <?php
                            }
                        ?>
                        <input id="txtPassword" type="password" name="password" class="form-control allow-enter" placeholder="Password" value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember_me" id="chkRemember" name="chkRemember"/> Remember me
                    </div>
                </div>
                <div class="footer">
                    <button id="btnSignin" type="submit" class="btn bg-olive btn-block sumitbtn">Sign me in</button>

                    <p><a href="<?=admin_path()?>forgotpassword">I forgot my password</a></p>

                    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
                </div>
            </form>

            <!-- <div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div> -->
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?=public_path()?>js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=public_path()?>js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>
<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function(){
	$('#btnSignin').click(function(e){
		//e.preventDefault();
		//rememberBkaIdPassword($("#txtUsername").val(),$("#txtPassword").val());
	});
	function chkBkaCookieRemember()
	{
		var strck = "";
		strck = $.cookie("rememberBrokerIdPassword");
		if(strck=="" || strck==null )
		{}
		else
		{
			var strcksplit = strck.split(";");
			$("#txtUsername").val(strcksplit[0]);
			$("#txtPassword").val(strcksplit[1]);
			$("input[name=chkRemember]").attr("checked",true);
		}
	}
	function rememberBkaIdPassword(uname,password)
	{
		strCookie = uname+";"+password;
		if($('input[name=chkRemember]').is(':checked'))
		{
			$.cookie("rememberBrokerIdPassword",strCookie,{ expires: 365});
		}
		else
		{
			$.cookie("rememberBrokerIdPassword","");
		}
	}
});
</script>
