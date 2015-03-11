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

$(document).ready(function(){
	$("#stamp_form").validationEngine();
	if ($("#my-awesome-dropzone").length > 0)
	{
		setTimeout(function(){
				var myDropzone = Dropzone.forElement("#my-awesome-dropzone");
				myDropzone.on("success", function(file, res) { 
					if (res.indexOf("Error:") === -1)
					{
						var file = JSON.parse(res);
						var html = "<li class='pull-left'>";
						html += "<img src='"+file.path+"' class='newimg' imgid = '"+file.id+"'>";
						html += "<br>";
						html += "<center><a class='removeimage' link_id='"+file.id+"' href='#'><i class='fa fa-trash-o'></i></a></center></li>";
						$("#img-container").append(html);
						$('#newimages').val($('#newimages').val() +"," +file.id);
						doOrderImage();
					}
				});
		},1000)
	}

	$('#img-container').delegate("img",'click',function(){
		$('#img-container img').removeClass('selected');
		$(this).addClass('selected');
		$('#t_mainphoto').val($(this).attr('imgid'));
	});

	var mainimgid = $('#t_mainphoto').val();
	$('#img-container img[imgid="'+mainimgid+'"]').addClass('selected');

	$( ".t_tags").tagedit({
		autocompleteURL: admin_path ()+'stamp/autocomplete',
	});

	$( "#img-container" ).sortable({stop: function( event, ui ) {doOrderImage();}});

	$('#img-container').delegate(".removeimage","click",function(e){
		e.preventDefault();
		atag = $(this);
		link_id = $(atag).attr('link_id');
		url = admin_path()+'stamp/delete',
		data = {id:link_id,from:'addedit'};
		$.post(url,data,function(e){
			if (e == "success") {
				if ($('#t_mainphoto').val() == link_id)
				{
					$('#t_mainphoto').val("");
				}
				$(atag).closest('li.pull-left').remove();
				$("#flash_msg").html(success_msg_box ('Image deleted successfully.'));
			}else{
				$("#flash_msg").html(error_msg_box ('An error occurred while processing.'));
			}
		});
	});

	doOrderImage();
});