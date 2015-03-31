<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->front_session = $this->session->userdata('front_session');
    }

	public function index($tag="")
	{
		$data['view'] = "index";
		$data['hdnTag'] = $tag;
		$data['searchKeyword'] = '';
		$data['hdnUid'] = '';
		if(isset($_GET['search']) && $_GET['search'] != '')
			$data['searchKeyword'] = $_GET['search'];
		if($this->uri->segment(1) == 'user' && $this->uri->segment(2) != '')
		{
			$data['hdnUid'] = $this->uri->segment(2);
			$uinfoArr = $this->getuinfo($this->uri->segment(2));
			//pr($uinfoArr);
			$data['uinfoArr'] = $uinfoArr;
		}
		//print_r($data);
		$this->load->view('content', $data);
	}

	public function album($tag="")
	{
		$data['view'] = "album";
		$this->load->view('content', $data);
	}

	public function login()
	{
		$post = $this->input->post();
		$where = array('u_email' => $post['txtuseremail'],
							'u_password' => sha1(trim($post['txtpassword']))
						);
			$user = $this->common_model->selectData(USERS, '*', $where);
			
			if (count($user) > 0) {
				# create session
				$data = array('id' => $user[0]->u_id,
								'u_fname' => $user[0]->u_fname,
								'u_lname' => $user[0]->u_lname,
								'u_photo' => $user[0]->u_photo,
								'u_email' => $user[0]->u_email,
								'u_url' => $user[0]->u_url,
								'u_created_date' => $user[0]->u_created_date,
								'u_photo' => $user[0]->u_photo
							);
				$this->session->set_userdata('front_session',$data);
				// Get all album of login user
				$result = $this->common_model->selectData(TICKET_ALBUM,"*",'al_uid =' .$user[0]->u_id);
				$this->session->set_userdata('session_album',$result);
				//pr($this->session->userdata('session_album'),1);
				echo "success";
			}else{
				echo "Invalid username or password";
			}

		}

	public function signup()
	{
		$post = $this->input->post();
		//echo '<pre>';print_r($post);die;
		if ($post) {
			$is_unique_email = $this->common_model->isUnique(USERS, 'u_email', trim($post['email']));

			if (!$is_unique_email) {
				echo 'Email already exists.';
				exit;
			}

			$data = array('u_fname' => $post['name'],
								'u_email' => $post['email'],				
								'u_password' => sha1(trim($post['password'])),
								'u_created_date' => date('Y-m-d H:i:s'),
								'u_modified_date' => date('Y-m-d H:i:s')
						);
			$ret = $this->common_model->insertData(USERS, $data);
			
			if ($ret > 0) {
				# create session
				$data = array('id' => $ret,
								'u_fname' => $post['name'],
								'u_lname' => '',
								'u_photo' => '',
								'u_url' => '',
								'u_email' => $post['email'],
								'u_created_date' => date('Y-m-d H:i:s')
							);
				$this->session->set_userdata('front_session',$data);

				##Insert Blank entry as of now in link table for user photo
				$arrData = array('link_object_id'=>$ret,'link_type'=>'user');
				$insLinkTable = $this->common_model->insertData(TICKET_LINKS, $arrData);

				$login_details = array('username' => $post['email'],
										'password' => trim($post['password'])
									);
				//$emailTpl = $this->get_welcome_tpl($login_details);
				//$ret = sendEmail($post['email'], SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);
				$emailTpl = $this->load->view('email_templates/signup', '', true);

				$search = array('{username}', '{password}');
				$replace = array($login_details['username'], $login_details['password']);
				$emailTpl = str_replace($search, $replace, $emailTpl);

				$ret = sendEmail($post['email'], SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);

				echo "success";
			}else{
				#show error
				echo "An error occurred while processing.";
			}

		}
	}

	public function autosuggest()
	{
		$get = $this->input->get();
		if (!isset($get["keyword"])) exit;
		$tag = $get["keyword"];
		$tags = $this->common_model->getTagAutoSuggest($tag);
		echo json_encode($tags);exit;
	}


	public function forgotpassword()
	{
		$post = $this->input->post();
		if ($post) {
			$where = array('u_email' => trim($post['txtemail']));
			$user = $this->common_model->selectData(USERS, '*', $where);
			if (count($user) > 0) {

				$newpassword = random_string('alnum', 8);
				$data = array('u_password' => sha1($newpassword));
				$upid = $this->common_model->updateData(USERS,$data,$where);

				$login_details = array('username' => $user[0]->u_email,'password' => $newpassword);
				$emailTpl = $this->load->view('email_templates/forgot_password', '', true);

				$search = array('{username}', '{password}');
				$replace = array($login_details['username'], $login_details['password']);
				$emailTpl = str_replace($search, $replace, $emailTpl);

				$ret = sendEmail($user[0]->u_email, SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);
				print_r($ret);die;
				if ($ret) {
					echo "success";
				}else{
					echo 'An error occurred while processing.';
					exit;
				}

			}else{
				echo "User does not exist.";
				exit;
			}

		}
	}

	public function contact()
	{
		$post = $this->input->post();
		if ($post) {
			$error = array();
			$e_flag=0;

			if(trim($post['name']) == ''){
				$error['name'] = 'Please enter your name.';
				$e_flag=1;
			}

			if(!valid_email(trim($post['email'])) && trim($post['email']) == ''){
				$error['email'] = 'Please enter valid email.';
				$e_flag=1;
			}

			if(trim($post['message']) == ''){
				$error['message'] = 'Please enter message.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$emailData = array_merge($post,array('email'=>'contact'));
				$emailTpl = $this->load->view('email_templates/template',$emailData , true);
				$ret = sendEmail(FROM_EMAIL, SUBJECT_CONTACT_ADMIN, $emailTpl, FROM_EMAIL, FROM_NAME);
				if ($ret) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => "Your contact us form has been submitted successfully."
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
				$data['flash_msg'] = $flash_arr;
			}
			$data['error_msg'] = $error;
		}
		$data['view'] = 'contactus';
		$this->load->view('content',$data);
	}

	public function about()
	{
		$data['view'] = 'aboutus';
		$this->load->view('content',$data);
	}

	public function getuinfo($uid = '')
	{
		if($uid != '')
		{
			$userarr = array();
			$userarr = $this->common_model->selectData(USERS, '*', array('u_id'=>$uid));
			if(!empty($userarr))
				return get_object_vars($userarr[0]);
			else
				return $userarr;
		}
		else
			return false;
	}

	function getStamp($tag= ''){
		$post = $this->input->post();
		$where = array();
		$orwhere = array();
		
			if(isset($post['hdnTag']) && $post['hdnTag'] != '')
				$where = array('t_tags like'=> '%'.$post['hdnTag'].'%');

			if(isset($post['searchKeyword']) && $post['searchKeyword'] != '')
			{
				$where = array('t_tags like'=> '%'.$post['searchKeyword'].'%');
				$orwhere = array('t_name like' => '%'.$post['searchKeyword'].'%' , 
												   't_bio like' => '%'.$post['searchKeyword'].'%' ,
												   't_ownercountry like' => '%'.$post['searchKeyword'].'%' );
			}

			if(isset($post['hdnUid']) && $post['hdnUid'] != '')
				$where = array('t_uid'=>$post['hdnUid']);
			
			$sortBy = (isset($post) && isset($post['sortBy']))?$post['sortBy']:"t_modified_date";
			$sortType = (isset($post) && isset($post['sortType']))?$post['sortType']:"DESC";
			$page = (isset($post) && isset($post['page']))?$post['page']:1;
			$limit = (isset($post) && isset($post['limit']))?$post['limit']:21;
			$selectFields_stamp = (isset($post) && isset($post['selectFields_stamp']))?$post['selectFields_stamp']:"*";
			$selectFields_users = (isset($post) && isset($post['selectFields_users']))?$post['selectFields_users']:'CONCAT(u_fname," ", `users`.u_lname) as uname';
			$stampRes = $this->common_model->searchStamp($selectFields_stamp,$selectFields_users,$where,$sortBy,$sortType,$page,$limit,$orwhere);
			
			$totalCount = $stampRes['totalRecordsCount'];
			unset($stampRes['totalRecordsCount']);

			if($totalCount > 0) {
				foreach($stampRes as $k=>$v)
				{
					$v['t_modified_date'] = Date("jS M, Y",strtotime($v['t_modified_date']));
					$v['t_tags'] = array_filter(explode(',',$v['t_tags']));
					$finalResArr['data'][] = $v;
				}
				$finalResArr['total'] = $totalCount;
				echo json_encode($finalResArr);exit;	
			}
			else
				echo "";
	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */
