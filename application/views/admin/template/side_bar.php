<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas" style="min-height: 2038px;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <!--<div class="pull-left image">
                <img alt="User Image" class="img-circle" src="img/avatar3.png">
            </div> -->
            <div class="pull-left info">
                <p>Hello, <?php echo $this->user_session['u_fname'];?></p>

                <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
        </div>
        <!-- search form -->
        <?php /*<form class="sidebar-form" method="get" action="#">
            <div class="input-group">
                <input type="text" placeholder="Search..." class="form-control" name="q">
                <span class="input-group-btn">
                    <button class="btn btn-flat" id="search-btn" name="seach" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>*/ ?>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="<?=get_active_tab("dashboard")?>">
                <a href="<?=admin_path()."dashboard"?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="<?=get_active_tab("users")?>">
				<a href="<?=admin_path()."users"?>">
					<i class="fa fa-dashboard"></i> <span>Users</span>
				</a>
            </li>
            <li class="<?=get_active_tab("album")?>">
				<a href="<?=admin_path()."album"?>">
					<i class="fa fa-dashboard"></i> <span>Album</span>
				</a>
            </li>
			 <li class="<?=get_active_tab("stamp")?>">
				<a href="<?=admin_path()."stamp"?>">
					<i class="fa fa-dashboard"></i> <span>Stamp</span>
				</a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
