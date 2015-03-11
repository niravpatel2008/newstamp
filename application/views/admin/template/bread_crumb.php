<ol class="breadcrumb">
    <li><a href="<?=admin_path()."dashboard"?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?=admin_path().$this->router->fetch_class()?>"><?=$this->router->fetch_class()?></a></li>
    <li class="active"><?=$this->router->fetch_method()?></li>
</ol>