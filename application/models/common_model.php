<?php
class common_model extends CI_Model{
	public function  __construct(){
		parent::__construct();
		$this->load->database();
	}


	/**
	* Select data
	*
	* general function to get result by passing nesessary parameters
	*/
	public function selectData($table, $fields='*', $where='', $order_by="", $order_type="", $group_by="", $limit="", $rows="", $type='')
	{
		$this->db->select($fields);
		$this->db->from($table);
		if ($where != "") {
			$this->db->where($where);
		}

		if ($order_by != '') {
			$this->db->order_by($order_by,$order_type);
		}

		if ($group_by != '') {
			$this->db->group_by($group_by);
		}

		if ($limit > 0 && $rows == "") {
			$this->db->limit($limit);
		}
		if ($rows > 0) {
			$this->db->limit($rows, $limit);
		}


		$query = $this->db->get();

		if ($type == "rowcount") {
			$data = $query->num_rows();
		}else{
			$data = $query->result();
		}

		#echo "<pre>"; print_r($this->db->queries); exit;
		$query->free_result();

		return $data;
	}


	/**
	* Insert data
	*
	*general function to insert data in table
	*/
	public function insertData($table, $data)
	{
		$result = $this->db->insert($table, $data);
		if($result == 1){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}


	/**
	* Update data
	*
	* general function to update data
	*/
	public function updateData($table, $data, $where)
	{
		$this->db->where($where);
		if($this->db->update($table, $data)){
			return 1;
		}else{
			return 0;
		}
	}


	/**
	* Delete data
	*
	* general function to delete the records
	*/
	public function deleteData($table, $data,$where_in='')
	{
		if(!empty($where_in))
		{
			$key = key($where_in);
			$this->db->where_in($key,$where_in[$key]);
			if($this->db->delete($table)){
				return 1;
			}else{
				return 0;
			}
		}
		else if($this->db->delete($table, $data)){
			return 1;
		}else{
			return 0;
		}
	}



	/**
	* check unique fields
	*/
	public function isUnique($table, $field, $value,$where = "")
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field,$value);
		if ($where != "")
			$this->db->where($where);
		$query = $this->db->get();
		$data = $query->num_rows();
		$query->free_result();

		return ($data > 0)?FALSE:TRUE;
	}


	function setImageOrder($imglist,$objid,$type)
	{
		$imglist = json_decode($imglist,1);
		foreach($imglist as $imgdata)
		{
			$where = array();
			$where['link_id'] = $imgdata['link_id'];
			$where['link_object_id'] = $objid;
			$where['link_type'] = $type;

			$data = array();
			$data['link_order'] = $imgdata['link_order'];
			$this->common_model->updateData(TICKET_LINKS, $data, $where);
		}
	}

	public function assingImagesToStamp($t_id,$image_ids)
	{
		$this->db->where_in('link_id',$image_ids);
		$data = array("link_object_id"=>$t_id);
		if($this->db->update(TICKET_LINKS, $data)){
			return 1;
		}else{
			return 0;
		}
	}

	public function getTags($obj_id,$type)
	{
		$this->db->select("tag_id,tag_name");
		$this->db->from(TICKET_TAG);
		$this->db->join(TICKET_TAG_MAPPING, "tm_tagid = tag_id");
		$this->db->where(array("tm_object_id"=>$obj_id,"tm_type"=>$type));

		$query = $this->db->get();
		$tags = $query->result_array();
		$query->free_result();
		return ($tags);
	}
	
	public function deleteTags($tm_tagid,$obj_id,$type)
	{
		$this->db->where_in('tm_tagid', $tm_tagid);
		$this->db->where(array('tm_object_id'=>$obj_id));
		$this->db->where(array('tm_type'=>$type));
		$del = $this->db->delete(TICKET_TAG_MAPPING);
		if($del){
			$delqry = "DELETE FROM TICKET_TAG WHERE tag_id IN (".implode(",",$tm_tagid).") AND (SELECT IF (COUNT(*)=0,1,0) FROM TICKET_TAG_MAPPING WHERE tm_tagid = tag_id AND tm_type = '$type')";
			$this->db->query($delqry);
			return 1;
		}else{
			return 0;
		}
	}

	public function selectData_whereIn($table, $fields='*', $whereIn='', $order_by="", $order_type="", $group_by="", $limit="", $rows="", $type='')
	{
		$this->db->select($fields);
		$this->db->from($table);
		if ($whereIn != "") {
			$key = key($whereIn);
			$this->db->where_in($key,$whereIn[$key]);
		}

		if ($order_by != '') {
			$this->db->order_by($order_by,$order_type);
		}

		if ($group_by != '') {
			$this->db->group_by($group_by);
		}

		if ($limit > 0 && $rows == "") {
			$this->db->limit($limit);
		}
		if ($rows > 0) {
			$this->db->limit($rows, $limit);
		}


		$query = $this->db->get();

		if ($type == "rowcount") {
			$data = $query->num_rows();
		}else{
			$data = $query->result();
		}

		#echo "<pre>"; print_r($this->db->queries); exit;
		$query->free_result();

		return $data;
	}

	public function searchStamp($selectFields_stamp="*", $selectFields_users='',$where, $sortBy='t_modified_date',$sortType='DESC',$page,$limit,$orwhere='')
	{
		$this->db->select("SQL_CALC_FOUND_ROWS t_id", FALSE);
		if($selectFields_users == '')
			$selectFields_users = "`users`.* ";
		$this->db->select(' ticket_collection.'.$selectFields_stamp.', '.$selectFields_users.', (select link_url from '.TICKET_LINKS.' where link_id = t_mainphoto and link_type="stamp") as `stamp_photo`',FALSE);
		$this->db->from(TICKET_COLLECTION);

		//if (count ($tags) > 0)
		//{
			$this->db->join(USERS, 'u_id = t_uid', 'left');
			
		//}
		if ($where != "") {
			$this->db->where($where);
		}
		if ($orwhere != "") {
			$this->db->or_where($orwhere);
		}
		if ($sortBy != '') {
			$this->db->order_by($sortBy,$sortType);
		}
		
		if($page != "" && $limit != "")
		{
			$page = ($page-1)*$limit;
			$this->db->limit($limit, $page);
		}

		$query = $this->db->get();
		#echo "<pre>"; print_r($this->db->queries); exit;
		$resArr = $query->result_array();
		//pr($resArr,1);
		$query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$totalRecordsCount = $query->row()->Count;
		
		$finalResArr = array();
		$finalResArr = $resArr;
		$finalResArr['totalRecordsCount'] = $totalRecordsCount;
		return $finalResArr;
	}
	

	function createAlbumStamp($post)
	{
		$jsonArr = $post['stampJson'];
			
			$err_flg = 0;
			$stampIdsArr = array();

			foreach($jsonArr as $k=>$v)
			{	
				$stampId = (isset($v['t_id']) && $v['t_id'] != "")?$v['t_id']:"";
				$st_name = @$v["st_name"]; 
				$st_price = @$v["st_price"];
				$st_year = @$v["st_year"];
				$st_country = @$v["st_country"];
				$st_bio = @$v["st_bio"];
				unset($v["t_id"]);
				unset($v["st_name"]);
				unset($v["st_price"]);
				unset($v["st_country"]);
				unset($v["st_bio"]);
				unset($v["st_year"]);
				$vJson = json_encode($v);
				$newStamp = createStamp($post['mainimg'],$v,$k);
				if($newStamp == "0")
				{
					echo "Issue occur during creating stamp";
					exit;
				}

				if ($stampId != "")
				{
					$data = array('t_name' => ($st_name != "")?$st_name:$post['al_name'],
									't_price' => ($st_price != "")?$st_price:$post['al_price'],
									't_ownercountry' => ($st_country != "")?$st_country:$post['al_country'],
									't_year' => ($st_year != "")?$st_year:"",
									't_bio' => ($st_bio != "")?$st_bio:"",
									't_modified_date' => date('Y-m-d H:i:s'),
									't_uid' => (isset($post['al_uid']) && $post['al_uid'] != "")?$post['al_uid']:$this->user_session['u_id'],
									't_dimension'=>$vJson);
					$where = array('t_id'=>$stampId);
					$ret_stamp_id = $this->common_model->updateData(TICKET_COLLECTION, $data, $where);

					$link_id = $this->common_model->selectData(TICKET_COLLECTION,"t_mainphoto", $where);
					$data = array("link_url"=>$newStamp);
					$where = array('link_id'=>$link_id[0]->t_mainphoto);
					$old_img = $this->common_model->selectData(TICKET_LINKS,"link_url", $where);
					deleteImage($old_img);
					$ret = $this->common_model->updateData(TICKET_LINKS, $data, $where);
				}
				else
				{
					## Insert entries in link table
					$linkdata =  array("link_type"=>"stamp","link_url"=>$newStamp);
					$link_id = $this->common_model->insertData(TICKET_LINKS, $linkdata);

					## Insert entries in stamp(ticket_collection) table
					$data = array('t_name' => ($st_name != "")?$st_name:$post['al_name'],
									't_price' => ($st_price != "")?$st_price:$post['al_price'],
									't_ownercountry' => ($st_country != "")?$st_country:$post['al_country'],
									't_year' => ($st_year != "")?$st_year:"",
									't_bio' => ($st_bio != "")?$st_bio:"",
									't_uid' => (isset($post['al_uid']) && $post['al_uid'] != "")?$post['al_uid']:$this->user_session['u_id'],
									't_mainphoto'=> $link_id,
									't_albumid' => $post['al_id'],
									't_created_date' => date('Y-m-d H:i:s'),
									't_modified_date' => date('Y-m-d H:i:s'),
									't_dimension'=>$vJson);
					
					$ret_stamp_id = $this->common_model->insertData(TICKET_COLLECTION, $data);
					$stampIdsArr[] = $ret_stamp_id;

					$data = array("link_object_id"=>$ret_stamp_id);
					$where = 'link_id = '.$link_id;
					$ret = $this->common_model->updateData(TICKET_LINKS, $data, $where);
					
				}

				
			}

			return $stampIdsArr;
	}

	function getAutocompleteTag($term) {
		$this->db->select("tag_id,tag_name");
		$this->db->from(TICKET_TAG);
		$this->db->like('tag_name', $term, 'after'); 
		$query = $this->db->get();
		$tags = $query->result_array();
		$query->free_result();
		return ($tags);
	}
}