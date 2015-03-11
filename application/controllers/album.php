<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->front_session = $this->session->userdata('front_session');
		$this->session_album = $this->session->userdata('session_album');
		is_front_login();
	}

	public function index()
	{
		#pr($this->session->flashdata('flash_msg'));
		$data['view'] = "index";
		$this->load->view('content', $data);
	}

	
	public function add()
	{
		$post = $this->input->post();
		
		if ($post) {
			#pr($post);
			$error = array();
			$e_flag=0;

			if(trim($post['al_name']) == ''){
				$error['al_name'] = 'Please enter album name.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$data = array('al_name' => $post['al_name'],
								'al_uid' => (isset($post['al_uid']) && $post['al_uid'] != "")?$post['al_uid']:$this->front_session['id'],
								'al_country' => $post['al_country'],
								'al_price' => $post['al_price'],
								'al_url' => $post['al_url'],
								'al_created_date' =>  date('Y-m-d H:i:s'),
								'al_modified_date' => date('Y-m-d H:i:s')
							);
				
				$ret = $this->common_model->insertData(TICKET_ALBUM, $data);

				if ($ret > 0) {
					
					/*update id to uploaded image link*/
					$newimages = array_filter(explode(",",$post['newimages']));
					if (count($newimages) > 0)
						$this->common_model->assingImagesToStamp($ret,$newimages);

					## Insert entries in stamp(ticket_collection) table
					if(isset($post['t_new_dimension']) && $post['t_new_dimension'] != '')
					{
						$data = $this->common_model->selectData(TICKET_LINKS, 'link_id,link_url',array("link_object_id"=>$ret,"link_type"=>"album"),"link_order","ASC");
						$post['mainimg'] = base_url()."uploads/stamp/".$data[0]->link_url;
						$post['t_new_dimension'] = urldecode($post['t_new_dimension']);
						$post['stampJson'] = json_decode($post['t_new_dimension'],true);
						$post['al_id'] = $ret;
						$this->user_session['u_id'] = $this->front_session['id'];
						$this->common_model->createAlbumStamp($post);
						unset($this->user_session['u_id']);
					}	

					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'Stamp added successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}

				if ($ret > 0) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'Album added successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
				$this->updateAlbumSession();

				redirect("album/edit/".$ret);
			}
			$data['error_msg'] = $error;
		}
		$data['users'] = $this->common_model->selectData(USERS, 'u_id,u_fname,u_email');
		$data['view'] = "add_edit_album";
		$data['ticket_links'] = array();
		$data['ticket_collection'] = '';
		$this->load->view('content', $data);
	}

	public function edit($id)
	{
		if ($id == "" || $id <= 0) {
			redirect('profile');
		}

		$where = 'al_id = '.$id;

		$post = $this->input->post();
		if ($post) {
			#pr($post);
			$error = array();
			$e_flag=0;

			if(trim($post['al_name']) == ''){
				$error['al_name'] = 'Please enter album name.';
				$e_flag=1;
			}
			
			if ($e_flag == 0) {
				$data = array('al_name' => $post['al_name'],
								'al_country' => $post['al_country'],
								'al_url' => $post['al_url'],
								'al_uid' => $post['al_uid'],
								'al_price' => $post['al_price'],
								'al_modified_date' => date('Y-m-d H:i:s')
							);
				
				$ret = $this->common_model->updateData(TICKET_ALBUM, $data, $where);

				if ($ret > 0) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'Album updated successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
				$this->session->set_flashdata($flash_arr);
				redirect("album/edit/".$id);
			}
			$data['error_msg'] = $error;
		}
		$data['album'] = $album= $this->common_model->selectData(TICKET_ALBUM, '*', $where);

		if (empty($album)) {
			redirect('album/edit/'.$id);
		}
		
		$data['ticket_links'] = $this->common_model->selectData(TICKET_LINKS, 'link_id,link_url',array("link_object_id"=>$id,"link_type"=>"album"),"link_order","ASC");

		## Get dimensions of stamp to plot all stamp on main album during edit time. 
		$data['ticket_collection'] = $this->common_model->selectData(TICKET_COLLECTION, '*',array("t_albumid"=>$id),"t_id","ASC");
		$tmpNewArr = array();
		foreach($data['ticket_collection'] as $k => $v)
			$tmpNewArr[] = array("id"=>$v->t_id,"area"=>$v->t_dimension,"st_country"=>$v->t_ownercountry,"st_price"=>$v->t_price,"st_year"=>$v->t_year,"st_bio"=>$v->t_bio,"st_name"=>$v->t_name);
		
		$data['ticket_collection'] = json_encode($tmpNewArr);
		$data['view'] = "add_edit_album";
		$data['users'] = $this->common_model->selectData(USERS, 'u_id,u_fname,u_email');
		$this->updateAlbumSession();
		$this->load->view('content', $data);
	}
	public function fileupload()
	{
		$file_name = "";
		$error = "";
		$post = $this->input->post();
		if($_FILES['file']['name'] != '' && $_FILES['file']['error'] == 0){
			$config['upload_path'] = UPLOADPATH;
			$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';

			$file_name_arr = explode('.',$_FILES['file']['name']);
			$file_name_arr = array_reverse($file_name_arr);
			$file_extension = $file_name_arr[0];
			$file_name = $config['file_name'] = "album_".time().".".$file_extension;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file'))
			{
				$e_flag = 1;
				$error = $this->upload->display_errors();
			}

			if ($error != "")
				echo "Error:".$error;
			else
			{
				$al_id = isset($post['al_id'])?$post['al_id']:"";
				$linkdata =  array("link_object_id"=>$al_id,"link_type"=>"album","link_url"=>$file_name);
				$link_id = $this->common_model->insertData(TICKET_LINKS, $linkdata);
				echo '{"id":"'.$link_id.'","path":"'.base_url()."uploads/stamp/".$file_name.'"}';
			}
			exit;
		}else
		{
			echo "Error: File not uploaded to server.";
		}
	}



	public function delete()
	{
		$post = $this->input->post();
		//pr($post,1);
		if ($post) {
			$imgPath = UPLOADPATH;

			$stampsToDel = $this->common_model->selectData(TICKET_COLLECTION, 'GROUP_CONCAT(t_id) AS t_id', array("t_albumid" => $post['al_id'])); ## Get all stamps id belonging to album

			## Delete all stamps image from link table belonging to album and unlink images
			$idStr=$stampsToDel[0]->t_id;
			if($idStr != '')
			{
				$idArr = explode(',',$idStr);
				$stampsPathArr = $this->common_model->selectData_whereIn(TICKET_LINKS, 'link_url', array('link_object_id'=>$idArr));
				deleteImage($stampsPathArr);// pass array with image name

				$resLink = $this->common_model->deleteData(TICKET_LINKS,'',array('link_object_id'=>$idArr));
			}

			$resStamp = $this->common_model->deleteData(TICKET_COLLECTION, array('t_albumid' => $post['al_id'] )); ## Delete stamp details entry from Stamp(collection) table belonging to album.

			
			//delete main album image
			
			$imgPath = $this->common_model->selectData(TICKET_LINKS, '*',array('link_object_id'=>$post['al_id']));
			if(!empty($imgPath))
				deleteImage($imgPath);
			$ret = $this->common_model->deleteData(TICKET_LINKS, array('link_object_id' => $post['al_id'] ));
			
			if(isset($post['from']) && $post['from'] == 'listview')
				$ret = $this->common_model->deleteData(TICKET_ALBUM, array('al_id' => $post['al_id'] ));

			if ($ret > 0) {
				echo "success";
				#echo success_msg_box('record deleted successfully.');;
			}else{
				echo "error";
				#echo error_msg_box('An error occurred while processing.');
			}
			$this->updateAlbumSession();
		}
		
	}

	public function createStamp()
	{
		$post = $this->input->post();
		//pr($post,1);
		if(isset($post['stampJson'])){
			$stampIdsArr = $this->common_model->createAlbumStamp($post);
			echo "success";
		}
		
		//pr($post,1);
	}

	public function updateAlbumSession()
	{
		$this->session->unset_userdata('session_album');
		$result = $this->common_model->selectData(TICKET_ALBUM,"*",'al_uid =' .$this->front_session['id']);
		$this->session->set_userdata('session_album',$result);
	}
}