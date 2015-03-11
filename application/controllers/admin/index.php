<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index()
	{

		$session = $this->session->userdata('user_session');
		#pr($session,1);
		if (isset($session['u_id'])) {
			redirect(admin_path()."dashboard");
		}

		$data = array();
		$post = $this->input->post();
		if ($post) {
			$error = array();
			$e_flag=0;
			if(trim($post['userid']) == ''){
				$error['userid'] = 'Please enter userid.';
				$e_flag=1;
			}else if(trim($post['userid']) != 'admin@stampstockist.com'){
				$error['userid'] = 'Invalid email address.';
				$e_flag=1;
			}
			if(trim($post['password']) == ''){
				$error['password'] = 'Please enter password.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$where = array('u_email' => $post['userid'],
								'u_password' => sha1($post['password']),
							 );
				$user = $this->common_model->selectData(USERS, '*', $where);
				if (count($user) > 0) {
					# create session
					$data = array('u_id' => $user[0]->u_id,
									'u_fname' => $user[0]->u_fname,
									'u_lname' => $user[0]->u_lname,
									'u_email' => $user[0]->u_email,
								);
					$this->session->set_userdata('user_session',$data);
					setcookie('uname',$post['userid'],time() + (86400 * 365));
					setcookie('password',$post['password'],time() + (86400 * 365));
					redirect('admin/users');
				}else{
					$error['invalid_login'] = "Invalid userid or password";
				}
			}

			$data['error_msg'] = $error;
		}

		$this->load->view('admin/index/index', $data);
	}


	public function logout()
	{
		$this->session->unset_userdata('user_session');
		redirect(admin_path());
	}



	public function forgotpassword()
	{
		$data = '';
		$post = $this->input->post();
		if ($post) {
			$error = array();
			$e_flag=0;
			if(!valid_email(trim($post['email'])) && trim($post['email']) == ''){
				$error['email'] = 'Please enter email.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$where = array('u_email' => trim($post['email']));
				$user = $this->common_model->selectData(USERS, '*', $where);
				if (count($user) > 0) {

					$newpassword = random_string('alnum', 8);
					$data = array('u_password' => sha1($newpassword));
					$upid = $this->common_model->updateData(USERS,$data,$where);

					$login_details = array('username' => $user[0]->u_fname,'password' => $newpassword);
					#$emailTpl = $this->get_forgotpassword_tpl($login_details);

					$emailTpl = $this->load->view('email_templates/admin_forgot_password', '', true);

					$search = array('{username}', '{password}');
					$replace = array($login_details['username'], $login_details['password']);
					$emailTpl = str_replace($search, $replace, $emailTpl);

					$ret = sendEmail($user[0]->u_email, SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);
					if ($ret) {
						$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'Login details sent successfully.'
									);
					}else{
						$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
					}
					$data['flash_msg'] = $flash_arr;
				}else{
					$error['email'] = "Invalid email address.";
				}
			}
			$data['error_msg'] = $error;
		}
		$this->load->view('admin/index/forgotpassword', $data);
	}

}
