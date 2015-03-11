<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StampDetail extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->front_session = $this->session->userdata('front_session');
	}

	public function viewDetail()
	{
		$post = $this->input->post();
		$uploadpath = base_url()."uploads/stamp/";
		$where = array();
		if(isset($_GET['tid']) && ($_GET['tid'] != '' || $_GET['tid'] != 0))
			$where = array('t_id'=> $_GET['tid']);
		$sortBy = (isset($post) && isset($post['sortBy']))?$post['sortBy']:"t_modified_date";
		$sortType = (isset($post) && isset($post['sortType']))?$post['sortType']:"ASC";
		$page = (isset($post) && isset($post['page']))?$post['page']:1;
		$limit = (isset($post) && isset($post['limit']))?$post['limit']:'';
		$selectFields_stamp = (isset($post) && isset($post['selectFields_stamp']))?$post['selectFields_stamp']:"*";
		$selectFields_users = (isset($post) && isset($post['selectFields_users']))?$post['selectFields_users']:'';
		
		## Get all details info of Stamp & users
		$stampRes = $this->common_model->searchStamp($selectFields_stamp,$selectFields_users,$where,$sortBy,$sortType,$page,$limit);
		//pr($stampRes,1);
		if ($stampRes['totalRecordsCount'] == 1) {
			//echo json_encode($stampRes);exit;	
			$stampRes = $stampRes[0];
			$stampRes['t_created_date'] = Date("jS M, Y",strtotime($stampRes['t_created_date']));
			$stampRes['t_modified_date'] = Date("jS M, Y",strtotime($stampRes['t_modified_date']));
			$stampRes['stamp_main_photo'] = $uploadpath.$stampRes['stamp_photo'];
			$stampRes['user_fullname'] = ucwords($stampRes['u_fname']." ".$stampRes['u_lname']);

			## Get all stamp images
			$where = array('link_type'=>'stamp','link_object_id'=>$_GET['tid']);
			$stampPhotos = $this->common_model->selectData(TICKET_LINKS,"link_url",$where);
			foreach($stampPhotos as $k=>$v)
				$stampRes['all_photos'][] = $uploadpath.$v->link_url;


			## Get All tags belonging to this stamp
			$stampTags = $this->common_model->getTags($_GET['tid'],'stamp');
			$stampRes['all_tags'] = array();
			if(!empty($stampTags))
			{
				foreach($stampTags as $k=>$v)
					$stampRes['all_tags'][] = $v;
			}

			$data['details'] = $stampRes;
		}else
			$data['details'] = '';
		
		//pr($stampRes,1);
		$data['view'] = "viewDetail";
		$this->load->view('content', $data);
	}

}