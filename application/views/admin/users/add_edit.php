<section class="content-header">
    <h1>
        Users
        <small>
            <?=($this->router->fetch_method() == 'add')?'Add User':'Edit User'?>
        </small>
    </h1>
    <?php
		$this->load->view(ADMIN."/template/bread_crumb");
	?>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-6">
    		<div class="box-body">
                <?php
                    if (@$flash_msg != "") {
                ?>
                    <div id="flash_msg"><?=$flash_msg?></div>
                <?php
                    }
                ?>
                <form id='user_form' name='user_form' role="form" action="" method="post">
                    <div class="form-group <?=(@$error_msg['u_fname'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['u_fname'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['u_fname']?></label><br/>
                        <?php
                            }
                        ?>
                        <label>First Name:</label>
                        <input type="text" placeholder="Enter ..." class="form-control validate[required]" name="u_fname" id="u_fname" value="<?=@$user[0]->u_fname?>" >
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" placeholder="Enter ..." class="form-control" name="u_lname" id="u_lname" value="<?=@$user[0]->u_lname?>" >
                    </div>
                    <div class="form-group <?=(@$error_msg['email'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['email'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['email']?></label><br/>
                        <?php
                            }
                        ?>
                        <label for="email">Email address:</label>
                        <input type="email" placeholder="Enter email" id="email" class="form-control validate[required,custom[email]]" name="email" value="<?=@$user[0]->u_email?>" >
                    </div>
					<div class="form-group">
						<label>Password:</label>
                        <input type="password" placeholder="Password" class="form-control validate[minSize[5],maxSize[15]]" name="password" id="password" >
                    </div>
					<div class="form-group">
                        <label>Repeat Password:</label>
                        <input type="password" placeholder="Repeat Password" class="form-control validate[equals[password]]" name="re_password" id="re_password">
                    </div>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" placeholder="Enter ..." class="form-control validate[custom[url]" name="u_url" id="u_url" value="<?=@$user[0]->u_url?>">
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <select class="form-control" name="u_gender" id="u_gender">
                            <option value="">Select</option>
                            <option value="m" <?=(@$user[0]->u_gender == 'm')?'selected':''?> >Male</option>
                            <option value="f" <?=(@$user[0]->u_gender == 'f')?'selected':''?> >Female</option>
                        </select>
                    </div>
					<div class="form-group">
                        <label>Contact :</label>
                        <input type="text" placeholder="Enter ..." class="form-control validate[custom[phone]]" name="u_phone" id="u_phone" value="<?=@$user[0]->u_phone?>">
                    </div>
					<div class="form-group">
                        <label>Country :</label>
                        <input type="text" placeholder="Enter ..." class="form-control" name="u_country" id="u_country" value="<?=@$user[0]->u_country?>">
                    </div>
					<div class="form-group">
                        <label>State :</label>
                        <input type="text" placeholder="Enter ..." class="form-control" name="u_state" id="u_state" value="<?=@$user[0]->u_state?>">
                    </div>
					<div class="form-group">
                        <label>City :</label>
                        <input type="text" placeholder="Enter ..." class="form-control" name="u_city" id="u_city" value="<?=@$user[0]->u_city?>">
                    </div>
					<div class="form-group">
                        <label>Bio-graphy :</label>
                        <textarea class="form-control" id="u_bio" name="u_bio" title="Say something about you" rows="6"><?=@$user[0]->u_bio?></textarea>
                    </div>
					
                    <div class="form-group">
                        <button class="btn btn-primary btn-flat" type="submit" id="submit">Submit</button>
                    </div>
                </form>
            </div>
    	</div>
    </div>
</section>
