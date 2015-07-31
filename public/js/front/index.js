var isAjaxLoad = false;
$(document).ready(function(){
	document.body.scrollTop = document.documentElement.scrollTop = 0; // Always starts page load from Top
	$('#hdnCurrPage').val('1');
	getStamps('');

	$(window).scroll(function () {
		var curPage = $('#hdnCurrPage').val();
		if((curPage * $('#hdnRecLimit').val()) <= $('#hdnTotalRec').val())
		{
			//if (isAjaxLoad == false && $(document).height() <= $(window).scrollTop() + $(window).height()) {
			if (isAjaxLoad == false && $(window).scrollTop() >= ($(document).height() - $(window).height())*0.75) {
				// Lazy Load made ajax call when 75% scroll has been made 
				curPage++;
				$('#hdnCurrPage').val(curPage);
				getStamps(curPage);
			}
		}
		else
			return;
    });
	
	$('#btnSearchStamp').on('click',function(e){
		e.preventDefault();
		if($('#txtSearchStamp').val() == null || $('#txtSearchStamp').val() == '')
	{
		alert("please fill up seach criteria first..");
		return false;
	}else
		{
		$('form#frmSearchStamp').submit();
		return true;
		}
	});
	
	
});