<div class="wrapper row-offcanvas row-offcanvas-left">
	<?php
		$this->load->view(ADMIN."/template/side_bar");
	?>
	 <!-- Right side column. Contains the navbar and content of the page -->
	 <aside class="right-side">
	<?php
		$this->load->view(ADMIN."/".$this->router->fetch_class()."/".$view);
	?>
	</aside>
	<!-- /.right-side -->
</div><!-- ./wrapper -->
