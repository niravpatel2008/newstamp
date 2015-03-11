$(document).ready(function(){
	$("#frmAddPhoto").on('submit', function (e) {
		
		if($('#profile_photo').val() == "")
		{
			e.preventDefault();
			alert("Please Upload Photo");
			return false;
		}
		if($('#imgUserPhoto').attr('imgname') != "nophoto.jpg")
			$('#hdnOldPhoto').val($('#imgUserPhoto').attr('imgname'));
		$('#frmAddPhoto').submit();
		
	});
	
	$('#mainStampContainer').delegate('.delStamp','click',function(){
		var ob = $(this);
		var del_id = ob.attr('id').split('_')[1];
		var cnf = confirm('Are You sure want to remove this stamp?');
		if(cnf == true)
		{
			delete_stamp(del_id);
		}
	});
});

$('#btnPost').on('click',function(){
	if($('#txtBioStatus').val() == "")
		alert("Please Insert Something to Post");
	else
	{
		var url = base_url()+'profile/updateBio';
		var data = "bio="+$.trim($('#txtBioStatus').val());
	
		$.post(url,data,function(e){
			if(e == '1'){
				$('#divBio').html($('#txtBioStatus').val());
				$('#txtBioStatus').val('');
			}else{
				alert("Error occured during Updating Bio !! Please Try again");
				return false;
			}
		});		
	}
});


$('#birthdate').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-3d',
	autoClose:true
})

function delete_stamp (del_id) {
	var url = base_url()+'userstamp/deletestamp';
	var data = 'id='+del_id;
	$.post(url,data,function(e){
		if(e == "success"){
			alert('Stamp removed successfully');
			location.reload();
		}else{
			alert('An error occurred while processing.');
			location.reload();
		}
	});	
}
