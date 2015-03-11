var $cropObj = "";
$(document).ready(function(){
	$("#album_form").validationEngine();
	Dropzone.options.myAwesomeDropzone = {
	  maxFiles: 1,
	  accept: function(file, done) {
		console.log("uploaded");
		done();
	  },
	  init: function() {
		this.on("maxfilesexceeded", function(file){
			this.removeFile(file);
			alert("No more files please!");
		});
	  }
	};

	initCrop();

	if ($("#my-awesome-dropzone").length > 0)
	{
		setTimeout(function(){
				var myDropzone = Dropzone.forElement("#my-awesome-dropzone");
				myDropzone.on("success", function(file, res) { 
					if (res.indexOf("Error:") === -1)
					{
						var file = JSON.parse(res);
						var needHtml = "";
						if ($('#al_id').val() != "")
						{
							needHtml = "<button class='btn btn-primary btn-flat' style='margin-left:14px;' id='btn_createstamp'>Create Stamp</button></center>";
						}

						var html = "<li class='pull-left'>";
						html += "<img src='"+file.path+"' id='albumImg' class='newimgFull' imgid = '"+file.id+"'>";
						html += "<br>";
						html += "<center><a class='removeimage' link_id='"+file.id+"' href='#'><i class='fa fa-trash-o'></i></a>"+needHtml+"</li>";
						$("#img-container").html(html);
						$('#newimages').val($('#newimages').val() +"," +file.id);
						initCrop();
						doOrderImage();
						
					}
				});
		},1000)
	}
	

	var mainimgid = $('#t_mainphoto').val();
	$('#img-container img[imgid="'+mainimgid+'"]').addClass('selected');

	$('#img-container').delegate(".removeimage","click",function(e){
		e.preventDefault();
		atag = $(this);
		link_id = $(atag).attr('link_id');

		var cnf = confirm("All Associated Stamps with this Album will be deleted. Do You want to Continue ?");
		if(cnf == true)
		{
			url = admin_path()+'album/delete',
			data = {link_id:link_id,from:'addedit',al_id:$('#al_id').val()};
			$.post(url,data,function(e){
				if (e == "success") {
					if ($('#t_mainphoto').val() == link_id)
					{
						$('#t_mainphoto').val("");
					}
					$(atag).closest('li.pull-left').remove();
					//$("#flash_msg").html(success_msg_box ('Image deleted successfully.'));
					alert("Images Deleted Successfully");
					//Dropzone.empty();
					location.reload();
				}else{
					$("#flash_msg").html(error_msg_box ('An error occurred while processing.'));
				}
			});
		}
	});
	
	$('#img-container').delegate('#btn_createstamp','click',function(){
		var cropJson = $cropObj[0].crop.getSelection();
		if(cropJson == null || cropJson == '')
		{
			alert("Create Stamp , You must have to crop image");return false;
		}
		var mainSrc = $('img#albumImg').attr('src');
		var al_id = $('#al_id').val();
		if (al_id == "") return; //Do not create stamp if album is not created
		
		var albumName = $('#al_name').val();
		var price = $('#al_price').val();
		var country = $('#al_country').val();
		var al_uid = $('#al_uid').val();
		
		url = admin_path()+'album/createStamp',
		data = {stampJson:cropJson,mainimg:mainSrc,al_id:al_id,al_name:albumName,al_price:price,al_country:country,al_uid:al_uid};
		$.post(url,data,function(e){
			if (e == "success") {
				alert("Stamps Created Successfully");
			}else
			{
				alert("Please try again later");
			}
		});
	});

	$("#album_form").on('submit',function(){
		if ($('#al_id').val() != "") return true;

		if(typeof($cropObj[0]) == 'undefined')
		{
			alert("Please upload album image to create stamps");return false;
		}

		var cropJson = $cropObj[0].crop.getSelection();
		if(cropJson == null || cropJson == '')
		{
			alert("Create Stamp , You must have to crop image");return false;
		}
		$('#t_new_dimension').val(encodeURIComponent(JSON.stringify(cropJson)));
	});
});

function initCrop()
{
	var stampJson = '';
	stampJson = $('#t_dimension').val();
	//console.log(stampJson);
	$cropObj = $('img#albumImg').imageCrop({
		overlayOpacity : 0.25,
//		selections : [{"x":"125px","y":"78px","w":50,"h":50},{"x":"114px","y":"169px","w":73,"h":131},{"x":"277px","y":"167px","w":126,"h":65},{"x":"335px","y":"275px","w":50,"h":50},{"x":"416px","y":"7px","w":50,"h":50}]
		selections : JSON.parse("["+stampJson+"]")
	});console.log($cropObj);
}
function doOrderImage(){
	var order = {};
	$('.newimg').each(function(k,v){
		imageid = $(this).attr('imgid');
		imageorder = k;
		order[k] = ({"link_id":imageid,"link_order":imageorder});
	});
	orderStr = JSON.stringify(order);
	$('#sortOrder').val(orderStr);
}