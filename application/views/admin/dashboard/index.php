<section class="content-header">
    <h1>
        Dashboard
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
            <div id="list">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Purchased Deals</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="dealsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Deal</th>
                                    <th>Dealer</th>
                                    <th>User</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Payment Option</th>
                                    <th>Amount Paid</th>
                                    <th>Deal Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Deal</th>
                                    <th>Dealer</th>
                                    <th>User</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Payment Option</th>
                                    <th>Amount Paid</th>
                                    <th>Deal Status</th>
                                    <th>Created At</th>
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
