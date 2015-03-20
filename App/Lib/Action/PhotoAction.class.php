<?php 

/**
* show the fhoto
*/
class PhotoAction extends Action
{
	
	public function _initialize()
	{
		# code...
		header("Content-Type:text/html; charset=utf-8");
	}

	public function index()
	{
		$uid = $_SESSION['uid'];
		$user_photo_arr = array();
		echo $uid;
		$user_photo_arr[] = $uid;
		echo "<br />";
		$condition['uid'] = $uid;
		$rela = M("relationship");
		$ruid_arr = $rela->where($condition)->select();
		$following_num = count($ruid_arr);
		for ($i=0; $i < $following_num; $i++) { 
			$user_photo_arr[] = $ruid_arr[$i]['ruid'];
		}
		$map['uid'] = array('in', $user_photo_arr);
		$Photo = M("photo");
		$res_arr = $Photo->where($map)->select();
		print_r($res_arr);
		//$this->display();

		
		$this->display();
	}
}