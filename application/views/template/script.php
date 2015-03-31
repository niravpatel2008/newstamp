<script type="text/javascript">
  function base_url () {
	  return '<?=base_url()?>';
  }

  function public_path()
  {
	  return '<?=public_path()?>';
  }
</script>

<script src="<?=public_path()?>js/front/jquery.js"></script>
<script src="<?=public_path()?>js/front/boostrap.min.js"></script>
<script src="<?=public_path()?>js/front/flexnav.min.js"></script>
<script src="<?=public_path()?>js/front/magnific.js"></script>
<script src="<?=public_path()?>js/front/ionrangeslider.js"></script>
<script src="<?=public_path()?>js/front/icheck.js"></script>
<script src="<?=public_path()?>js/front/owl-carousel.js"></script>
<script src="<?=public_path()?>js/front/masonry.js"></script>
<script src="<?=public_path()?>js/front/nicescroll.js"></script>
<script src="<?=public_path()?>js/front/btvalidation.js"></script>
<script src="<?=public_path()?>js/front/btvalidation.min.js"></script>
	

<!-- common scripts -->
<script src="<?=public_path()?>js/front/common.js"></script>

<script src="<?=public_path()?>js/front/tmpl.js"></script>
<script src='<?=public_path()?>js/front/<?=$view?>.js'></script>

<?php $this->load->view('tmpl/stamp');?>

<?php 
	if (in_array($this->router->fetch_method(), array("add","edit"))) { ?>
		<script src="<?=public_path()?>js/jquery-ui-1.10.3.js" type="text/javascript"></script>
		<script src="<?=public_path()?>js/plugins/tagedit/jquery.autoGrowInput.js" type="text/javascript"></script>
		<script src="<?=public_path()?>js/plugins/tagedit/jquery.tagedit.js" type="text/javascript"></script>
		<script src="<?=public_path()?>js/plugins/dropzone/dropzone.js" type="text/javascript"></script>
	<?php }
	
	if(in_array($this->router->fetch_class(),array('album'))) { ?>
		<script src="<?=public_path()?>js/plugins/imageCrop/imagecrop.js" type="text/javascript"></script>
	<?php }?>