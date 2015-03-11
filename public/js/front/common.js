"use strict";

// Bootstrap carousel
$('.carousel').carousel({
    interval: 6000
});

// Responsive navigation
$('#flexnav').flexNav();

// Lighbox text
$('.popup-text').magnificPopup({
    removalDelay: 500,
    closeBtnInside: true,
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.el.attr('data-effect');
        }
    },
    midClick: true
});

// Bootstrap tooltips
$('[data-toggle="tooltip"]').tooltip();

// Lighbox gallery
$('#popup-gallery').each(function() {
    $(this).magnificPopup({
        delegate: 'a.popup-gallery-image',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

// Lighbox gallery
$('#popup-gallery').each(function() {
    $(this).magnificPopup({
        delegate: 'a.popup-gallery-image',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

// Lighbox image
$('.popup-image').magnificPopup({
    type: 'image'
});

$(window).load(function() {
    if ($(window).width() > 992) {
        $('#stamp_area').masonry({
            itemSelector: '.col-masonry'
        });
    }
});


function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function openLoginForm()
{
	$("#divCreateAccountForm").modal('hide');
	$("#divForgotPasswordForm").modal('hide');
    $('#divConsLogin').modal();
}

function openSignupForm()
{
	$('#divConsLogin').modal('hide');
	$("#divForgotPasswordForm").modal('hide');
    $("#divCreateAccountForm").modal();
}

function openForgotPasswordForm () {
	$('#divConsLogin').modal('hide');
	$("#divCreateAccountForm").modal('hide');
    $("#divForgotPasswordForm").modal();
}

// Document ready functions
$(document).ready(function() {
    $('html').niceScroll({
        cursorcolor: "#000",
        cursorborder: "0px solid #fff",
        railpadding: {
            top: 0,
            right: 0,
            left: 0,
            bottom: 0
        },
        cursorwidth: "5px",
        cursorborderradius: "0px",
        cursoropacitymin: 0,
        cursoropacitymax: 0.7,
        boxzoom: true,
        horizrailenabled: false,
        zindex: 9999
    });

     // footer always on bottom
   var docHeight = $(window).height();
   var footerHeight = $('#main-footer').height();
   var footerTop = $('#main-footer').position().top + footerHeight;
   
   if (footerTop < docHeight) {
    $('#main-footer').css('margin-top', (docHeight - footerTop) + 'px');
   }

	$("#loginform,#signupform").validationEngine();
	$("#loginform").on('submit', function (e) {
		e.preventDefault();
		if(!$("#loginform").validationEngine('validate')) return ;
		var url =  base_url()+'login';
		var data =  $("#loginform").serialize();
		$.post(url,data,function(e){
			if(e == 'success'){
				//location.reload();
				location.href=base_url()+'profile';
			}else{
				alert("Invalid Username or Password");
				return false;
			}
	});

	$("#signupform").on('submit', function (e) {
		e.preventDefault();
		if(!$("#signupform").validationEngine('validate')) return ;
	var url = base_url()+'signup';
	var data = $("#signupform").serialize();
	
		$.post(url,data,function(e){
				if(e == 'success'){
					alert("Account Successfully Created");
					location.href=base_url()+'profile';
				}else{
					alert(e);
					return false;
				}
			});
	});

	$("#forgotpwdform").validationEngine();
	$("#forgotpwdform").on('submit', function (e) {
		e.preventDefault();
		if(!$("#forgotpwdform").validationEngine('validate')) return ;
		var url = base_url()+'forgotpassword';
		var data = $("#forgotpwdform").serialize();
		$.post(url,data,function(e){
				if(e == 'success'){
					alert("Email has been sent to your email.");
					$('#divForgotPasswordForm').modal('toggle');
				}else{
					alert(e);
					return false;
				}
			});
	});

	$("#frmChangePwd").validationEngine();
	$("#frmChangePwd").on('submit', function (e) {
		e.preventDefault();
		if(!$("#frmChangePwd").validationEngine('validate')) return ;
		var url = base_url()+'profile/change_password';
		var data = $("#frmChangePwd").serialize();
		$.post(url,data,function(e){
			var result = jQuery.parseJSON(e);
			resVal = result.flash_msg.flash_type;
			if(resVal == 'success'){
				alert(result.flash_msg.flash_msg);
				location.href = base_url();
				//$('#divForgotPasswordForm').modal('toggle');
			}else{
				alert(result.flash_msg.flash_msg);
				return false;
			}
		});
	});


	$('.allow-enter').keydown(function(e){
		 if (e.which == 13) {
			var $targ = $(e.target).closest("form");
			$targ.find(".sumitbtn").focus();
		}	
	})
});

});


function loadTmpl(tplid)
{
	var $tmplDom = $('#'+tplid);
	if ($($tmplDom.data('id')).length == 0)
	{
		var src = $tmplDom.data('script');
		$.get(src,{},function(tmpl){
			var id = $tmplDom.data('id');
			var type = $tmplDom.data('type');
			var tag = "<script id='"+id+"' type='"+type+"'>"+tmpl+"</script>";
			$("head").append(tag);
		})
	}
}


function getStamps(curPage)
{
	var url =  base_url()+'getstamps';
	
	var page ;
	if($('#hdnCurrPage').length > 0)
		page = $('#hdnCurrPage').val();
	else if(!isNaN(curPage)) 
		page = $.trim(curPage);

	var limit = $('#hdnRecLimit').val();
	
	var hdnTag = $('#hdnTag').val();
	var hdnUid = $('#hdnSearchUid').val();
	var searchKeyword = $('#searchKeyword').val();
	var from = 'user';
	if($('#pageFrom').length > 0 )
		from = $('#pageFrom').val();

	var data =  {from:from,page:page,limit:limit,hdnTag:hdnTag,searchKeyword:searchKeyword,hdnUid:hdnUid};
	isAjaxLoad = true;
	loadTmpl("stamp_wrapper_tmpl");
	$.post(url,data,function(e){
		if(e != ""){
			isAjaxLoad = false;
			displayStamps(e);
		}else{
			$('#mainStampContainer').html('<div class="col-lg-12"><div class="alert alert-danger">Ooops!! No Record Found</div></div>');
			isAjaxLoad = false;
			return false;
		}
	});
}

function displayStamps(result)
{
	var flag = false;
	var stampHtml = '';
	var resultJson = JSON.parse(result);
	var imgPath = base_url()+"uploads/stamp/";
	var totalRec = resultJson.total;
	result = resultJson.data;
	$('#hdnTotalRec').val(totalRec);
	$.each(result, function(index,element)
	{ 
		if(index != 'totalRecordsCount')
		{
			element.ismy = (element.t_uid == u_id)?true:false;
			element.stamp_photo = imgPath+element.stamp_photo;
			var $stamp = $('#stamp_wrapper').tmpl( element );
			$("#stamp_area").append( $stamp ).masonry( 'appended', $stamp );
		}
	});
	$('#stamp_area').masonry({itemSelector: '.col-masonry'});
}