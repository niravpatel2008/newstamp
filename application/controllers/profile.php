<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->front_session = $this->session->userdata('front_session');
		$this->session_album = $this->session->userdata('session_album');
		is_front_login();
	}


	public function index()
	{
		// Get login userinfo
		$result = $this->common_model->selectData(USERS,"*",'u_id = '.$this->front_session['id']);
		$data['userinfo'] = $result;
		//pr($this->session_album,1);
		$data['view'] = "index";
		$this->load->view('content', $data);
	}

	public function fileupload()
	{
		$file = $_FILES;
		## Upload Photo
		 if(!empty($file))
		{
			if(isset($file['profile_photo'])	 && !empty($file['profile_photo']))
			{
				if($file['profile_photo']['name'] != '' && $file['profile_photo']['error'] == 0)
				{
					$config['upload_path'] = UPLOADPATH;
					$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';

					$file_name_arr = explode('.',$file['profile_photo']['name']);
					$file_name_arr = array_reverse($file_name_arr);
					$file_extension = $file_name_arr[0];
					$file_name = $config['file_name'] = "user_".$this->front_session['id']."_".time().".".$file_extension;

					$this->load->library('upload', $config);
					$error = '';
					if ( ! $this->upload->do_upload('profile_photo'))
					{
						$e_flag = 1;
						$error = $this->upload->display_errors();
					}
					else
					{
						if(isset($_POST['hdnOldPhoto'])	 && !empty($_POST['hdnOldPhoto'])){
							if(file_exists(UPLOADPATH.$_POST['hdnOldPhoto']))
								unlink(UPLOADPATH.$_POST['hdnOldPhoto']);
						}
						$res = $this->common_model->updateData(USERS,array('u_photo'=>$file_name), 'u_id = 
						'.$this->front_session['id']);
						$data=array('link_object_id'=>$this->front_session['id'],
										 'link_type'=>'user',
										 'link_url'=>$file_name);
						$where = 'link_object_id = '.$this->front_session['id']. ' AND link_type="user" ';
						$res = $this->common_model->updateData(TICKET_LINKS,$data, $where);

						$tmpSessionArr = $this->front_session;
						$tmpSessionArr['u_photo'] = $file_name;
						$this->session->set_userdata('front_session',$tmpSessionArr);
						$this->front_session = $this->session->userdata('front_session');
						redirect(base_url()."profile");
					}


					if ($error != ""){
						$msg = "Error:".$error;
						echo '<script language="javascript">alert("'.strip_tags($msg).'")</script>';
					}
					//
				}
			}
		}
		//redirect(base_url()."profile");
		
	}
	public function edit()
	{
		$post = $this->input->post();
		$data = array();
		$flash_arr = array();
		$error = array();
		if ($post) {
			#pr($post);
			
			$e_flag=0;
			if(trim($post['email']) == ''){
				$error['email'] = 'Please enter email.';
				$e_flag=1;
			}
			
			if ($e_flag == 0) {

				$data = array('u_fname' => $post['fname'],
								'u_lname' => $post['lname'],
								'u_phone' => $post['contact'],
								'u_country' => $post['country'],
								'u_state' => $post['state'],
								'u_city' => $post['city'],
								'u_gender' => $post['gender'],
								'u_url' => $post['website'],
								'u_bio' => $post['bio'],
								'u_birthdate' => $post['birthdate']
							);
				$ret = $this->common_model->updateData(USERS, $data, 'u_id = '.$this->front_session['id']);
				

				if ($ret > 0) {
					# update session
					$session_data = array('id' => $this->front_session['id'],
									'u_fname' => $post['fname'],
									'u_lname' => $post['lname'],
								'u_email' => $post['email'],
								'u_phone' => $post['contact'],
								'u_country' => $post['country'],
								'u_state' => $post['state'],
								'u_city' => $post['city'],
								'u_gender' => $post['gender'],
								'u_url' => $post['website']
								);
					$this->session->set_userdata('front_session',$session_data);
					$this->front_session = $this->session->userdata('front_session');

					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'Profile updated successfully.'
									);
					#$this->session->set_flashdata($flash_arr);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
					#$this->session->set_flashdata($flash_arr);
				}
				//$data['flash_msg'] = $flash_arr;
			}
			//$data['error_msg'] = $error;
		}
		$result = $this->common_model->selectData(USERS,"*",'u_id = '.$this->front_session['id']);
		$data['view'] = "edit"; ## Old edit file. 
		//$data['view'] = "index";
		$data['error_msg'] = $error;
		$data['flash_msg'] = $flash_arr;
		$data['userinfo'] = $result;
		$this->load->view('content', $data);
	}

	public function change_password()
	{
		$post = $this->input->post();
		if ($post) {

			$error = array();
			$e_flag=0;
			if(trim($post['password']) == ''){
				$error['password'] = 'Please enter new password.';
				$e_flag=1;
			}
			if(trim($post['re_password']) == ''){
				$error['re_password'] = 'Please enter repeat password.';
				$e_flag=1;
			}
			if(trim($post['password']) != trim($post['re_password'])){
				$flash_arr = array('flash_type' => 'error',
									'flash_msg' => 'Both paswords should be same.'
								);
				$e_flag=1;
			}

			if ($e_flag == 0) {
				# update password
				$data = array('u_password' => sha1(trim($post['password'])) );
				$ret = $this->common_model->updateData(USERS, $data, 'u_id = '.$this->front_session['id']);

				if ($ret > 0) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'Password updated successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
			}
			$data['error_msg'] = $error;
			$data['flash_msg'] = @$flash_arr;
			$data = json_encode($data);
			echo $data;
			exit;
		}
		
			$data['view'] = "password";
			$this->load->view('content', $data);
	}


	public function logout()
	{
		$this->session->unset_userdata('front_session');
		$this->session->unset_userdata('session_album');
		redirect(base_url());
	}

	public function updateBio()
	{
		$post = $this->input->post();
		if($post)
		{
			if(isset($post['bio']) && $post['bio'] != '')
			{
				$res = $this->common_model->updateData(USERS, array('u_bio'=>trim($post['bio'])), 'u_id = '.$this->front_session['id']);
				echo $res;
				exit;
			}else {
			echo '0';exit;
			}
		}else
		{
			echo '0';exit;
		}
	}

	public function myalbum()
	{
		$post = $this->input->post();
		$data['view'] = "album";
		$this->load->view('content', $data);
	}

	public function mystamp()
	{
		$post = $this->input->post();
		$data['view'] = "mystamp";
		$this->load->view('content', $data);
	}
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */
