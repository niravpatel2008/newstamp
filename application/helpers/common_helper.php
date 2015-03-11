<?php

	function pr($arr, $option="")
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		if ($option != "") {
			exit();
		}
	}

	function public_path($type="www")
	{
		return base_url()."public/";
	}

	function admin_path($type="www")
	{
		return base_url()."admin/";
	}

    function profile_img_path($type="www")
    {
        return base_url()."uploads/profile_images/";
    }

	function is_login()
	{

		$CI =& get_instance();
		$session = $CI->session->userdata('user_session');

		if (!isset($session['u_id'])) {
			redirect(base_url());
		}
	}

    function is_front_login()
    {

        $CI =& get_instance();
        $session = $CI->session->userdata('front_session');

        if (!isset($session['id'])) {
            redirect(base_url());
        }
    }

	function success_msg_box($msg)
	{
		$html = '<div class="alert alert-success alert-dismissable">
                    <i class="fa fa-check"></i>
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    '.$msg.'
                </div>';
        return $html;
	}

	function error_msg_box($msg)
	{
		$html = '<div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    '.$msg.'
                </div>';
        return $html;
	}

	function get_active_tab($tab)
    {
    	$CI =& get_instance();
        if ($CI->router->fetch_class() == $tab) {
            return 'active';
        }
    }


    function sendEmail($to, $subject, $emailTpl, $from, $from_name, $cc='', $bcc=''){
        $CI =& get_instance();

        $CI->load->library('email');
	
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $CI->email->initialize($config);

        $CI->email->from($from, $from_name);
        $CI->email->to($to);

        if($cc != ''){
            $CI->email->cc($cc);
        }

        if($bcc != ''){
            $CI->email->bcc($bcc);
        }

        $CI->email->subject($subject);
        $CI->email->message($emailTpl);

        $email_Sent = $CI->email->send();
        return $email_Sent;
    }

	function replace_char($str)
	{
		return str_replace(array("/","(",")","&",),"-",$str);
	}

	function createStamp($mainimg,$v,$k=1)
	{
		$err_flg = 0;
		$file_extension = pathinfo($mainimg, PATHINFO_EXTENSION);
		$file_name = "stamp_".$k.'_'.time().".".$file_extension;
		$stamppath = UPLOADPATH.$file_name;

		$new = imagecreatetruecolor($v['w'], $v['h']);
				
		switch(strtolower($file_extension))
		{
			case 'jpg':
			case 'jpeg':
				$srcImg = imagecreatefromjpeg($mainimg);
			break;
			case 'png':
				$srcImg = imagecreatefrompng($mainimg);
			break;
			case 'gif':
				$srcImg = imagecreatefromgif($mainimg);
			break;
		}

		if(!isset($srcImg))
			$err_flg = 1;
		
		$jpeg_quality = 90;
		
		imagecopyresampled($new,$srcImg, 0, 0, intval($v['x']), intval($v['y']),  $v['w'], $v['h'], $v['w'], $v['h']);
		imagejpeg($new,$stamppath,$jpeg_quality);

		if($err_flg)
			return 0;
		else
			return $file_name;
	}

	## unlink images
	function deleteImage($urlArr = '')
	{
		$uploadPath = UPLOADPATH;

		foreach($urlArr as $k=>$v)
		{
			$urlStr = $v->link_url;
			$file = $uploadPath.$urlStr;
			if (file_exists($file))
				unlink($file);
		}		
	}

?>
