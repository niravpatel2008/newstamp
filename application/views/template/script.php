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
<tmpl id='stamp_wrapper_tmpl' data-id="stamp_wrapper" data-type="text/x-jquery-tmpl" data-script="<?=public_path()?>tmpl/stamp.tmpl"></tmpl>
<tmpl id='album_wrapper_tmpl' data-id="album_wrapper" data-type="text/x-jquery-tmpl" data-script="<?=public_path()?>tmpl/album.tmpl"></tmpl>
<script src='<?=public_path()?>js/front/<?=$view?>.js'></script>