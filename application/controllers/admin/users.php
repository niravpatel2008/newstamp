<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();

		is_login();

		$this->user_session = $this->session->userdata('user_session');
	}

	public function index()
	{
		#pr($this->session->flashdata('flash_msg'));
		$data['view'] = "index";
		$this->load->view('admin/content', $data);
	}

	public function ajax_list($limit=0)
	{
		$post = $this->input->post();

		$columns = array(
			array( 'db' => 'u_fname', 'dt' => 0 ),
			array( 'db' => 'u_lname',  'dt' => 1 ),
			array( 'db' => 'u_phone',  'dt' => 2 ),
			array( 'db' => 'u_email',  'dt' => 3 ),
			array('db'        => 'u_created_date',
					'dt'        => 4,
					'formatter' => function( $d, $row ) {
						return date( 'jS M y', strtotime($d));
					}
			),
			array( 'db' => 'u_id',
					'dt' => 5,
					'formatter' => function( $d, $row ) {
						return '<a href="'.site_url('/admin/users/edit/'.$d).'" class="fa fa-edit"></a> <a href="javascript:void(0);" onclick="delete_user('.$d.')" class="fa fa-trash-o"></a>';
					}
			),
		);
		echo json_encode( SSP::simple( $post, USERS, "u_id", $columns ) );exit;
	}

	public function add()
	{
		$post = $this->input->post();
		if ($post) {
			#pr($post);
			$error = array();
			$e_flag=0;

			if(!valid_email(trim($post['email'])) && trim($post['email']) == ""){
				$error['email'] = 'Please enter valid email.';
				$e_flag=1;
			}
			else{
				$is_unique_email = $this->common_model->isUnique(USERS, 'u_email', trim($post['email']));
				if (!$is_unique_email) {
					$error['email'] = 'Email already exists.';
					$e_flag=1;
				}
			}

			if(trim($post['u_fname']) == ''){
				$error['u_fname'] = 'Please enter first name.';
				$e_flag=1;
			}
			
			if (trim($post['password']) != "") {
				if($post['password'] == $post['re_password'])
				{
					$psFlas = true;
				}
				else
				{
					$error['password'] = 'Password field does not match.';
					$e_flag=1;
				}
			}
			else
			{
				$error['password'] = 'Please enter password.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$data = array('u_fname' => $post['u_fname'],
								'u_lname' => $post['u_lname'],
								'u_email' => $post['email'],
								'u_url' => $post['u_url'],
								'u_gender' => $post['u_gender'],
								'u_phone' => $post['u_phone'],
								'u_country' => $post['u_country'],
								'u_state' => $post['u_state'],
								'u_city' => $post['u_city'],
								'u_bio' => $post['u_bio'],
								'u_created_date' => date('Y-m-d H:i:s'),
								'u_password' => sha1(trim($post['password'])),
								'u_modified_date' => date('Y-m-d H:i:s')
							);
				
				$ret = $this->common_model->insertData(USERS, $data);

				if ($ret > 0) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'User added successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
				$this->session->set_flashdata($flash_arr);
				redirect("admin/users");
			}
			$data['error_msg'] = $error;
		}
		$data['view'] = "add_edit";
		$this->load->view('admin/content', $data);
	}

	public function edit($id)
	{
		if ($id == "" || $id <= 0) {
			redirect('admin/users');
		}

		$where = 'u_id = '.$id;

		$post = $this->input->post();
		if ($post) {
			//pr($post);die;
			$error = array();
			$e_flag=0;

			if(!valid_email(trim($post['email'])) && trim($post['email']) == ""){
				$error['email'] = 'Please enter valid email.';
				$e_flag=1;
			}
			else{
				$is_unique_email = $this->common_model->isUnique(USERS, 'u_email', trim($post['email']),"u_id <> ". $id);
				if (!$is_unique_email) {
					$error['email'] = 'Email already exists.';
					$e_flag=1;
				}
			}

			if(trim($post['u_fname']) == ''){
				$error['u_fname'] = 'Please enter first name.';
				$e_flag=1;
			}
			$psFlas = false;
			if (trim($post['password']) != "") {
				if($post['password'] == $post['re_password'])
				{
					$psFlas = true;
				}
				else
				{
					$error['password'] = 'Password field does not match.';
					$e_flag=1;
				}
			}

			if ($e_flag == 0) {

				$data = array(  'u_fname' => $post['u_fname'],
								'u_lname' => $post['u_lname'],
								'u_email' => $post['email'],
								'u_url' => $post['u_url'],
								'u_gender' => $post['u_gender'],
								'u_phone' => $post['u_phone'],
								'u_country' => $post['u_country'],
								'u_state' => $post['u_state'],
								'u_city' => $post['u_city'],
								'u_bio' => $post['u_bio'],
								'u_modified_date' => date('Y-m-d H:i:s')
							);
				if($psFlas)
					$data['u_password'] = sha1(trim($post['password']));
				$ret = $this->common_model->updateData(USERS, $data, $where);

			#echo "<pre>"; print_r($this->db->queries); exit;
				if ($ret > 0) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'User updated successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
				$this->session->set_flashdata($flash_arr);
				redirect("admin/users");
			}
			$data['error_msg'] = $error;
		}
		$data['user'] = $user = $this->common_model->selectData(USERS, '*', $where);

		if (empty($user)) {
			redirect('admin/users');
		}
		$data['view'] = "add_edit";
		$this->load->view('admin/content', $data);
	}


	public function delete()
	{
		$post = $this->input->post();

		if ($post) {
			$ret = $this->common_model->deleteData(USERS, array('u_id' => $post['id'] ));
			if ($ret > 0) {
				echo "success";
				#echo success_msg_box('User deleted successfully.');;
			}else{
				echo "error";
				#echo error_msg_box('An error occurred while processing.');
			}
		}
	}
}
