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
		$User = M("user");
		$condition['uid'] = $uid;
		$username = $User->where($condition)->field("name")->select();
		$username = $username[0]['name'];
		$user_photo_arr = array();
		//echo $uid;
		$user_photo_arr[] = $uid;
		//echo "<br />";
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

		$this->assign('username', $username);
		$this->display();
	}

	public function upload() {
        if (!empty($_FILES)) {
            import("@.ORG.UploadFile");
            $config=array(
                'allowExts'=>array('jpg','gif','png'),
                'savePath'=>'./Public/upload/',
                'saveRule'=>'time',
            );
            $upload = new UploadFile($config);
            $upload->imageClassPath="@.ORG.Image";
            $upload->thumb=true;
            $upload->thumbMaxHeight=100;
            $upload->thumbMaxWidth=100;
            if (!$upload->upload()) {
                $this->error($upload->getErrorMsg());
            } else {
                $info = $upload->getUploadFileInfo();
                $this->assign('filename', $info[0]['savename']);
            }
            //print_r($upload);
            $info = $upload->getUploadFileInfo();
            var_dump($info[0]);
            $Photo = M("Photo");
            $data['uid'] = $_SESSION['uid'];
            $phptime = time();
            $mysqltime = date("Y-m-d H:i:s", $phptime);
            //$phptime = strtotime($mysqltime);
            $data['time'] = $mysqltime;
            $data['pname'] = $info[0]['savename'];
            $data['path'] = $info[0]['savepath'];
            $data['hash'] = $info[0]['hash'];
            print_r($data);
            $res = $Photo->add($data);
            print_r($res);
            echo "<br>";
            echo $_SESSION['uid'];
        }
        $this->display(index);
    }
}