<section class="content-header">
    <h1>
        Stamp
        <!-- <small>Control panel</small> -->
    </h1>
    <?php
		$this->load->view(ADMIN."/template/bread_crumb");
	?>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
    		<div id="flash_msg">
	    		<?php
					if ($this->session->flashdata('flash_type') == "success") {
						echo success_msg_box($this->session->flashdata('flash_msg'));
					}

					if ($this->session->flashdata('flash_type') == "error") {
						echo error_msg_box($this->session->flashdata('flash_msg'));
					}
				?>
			</div>
    		<a class="btn btn-default pull-right" href="<?=admin_path()."stamp/add"?>">
            <i class="fa fa-plus"></i>&nbsp;Add Stamp</a>
            <div id="list">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Stamp list</h3>                                    
					</div><!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="stampTable" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Owner Name</th>
									<th>Stamp Title</th>
									<th>Album</th>
									<th>Price</th>
									<th>Year</th>
									<th>Bio</th>
									<th>Country</th>
									<th>Last Modified</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Owner Name</th>
									<th>Stamp Title</th>
									<th>Album</th>
									<th>Price</th>
									<th>Year</th>
									<th>Bio</th>
									<th>Country</th>
									<th>Last Modified</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
    	</div>
    </div>
</section>