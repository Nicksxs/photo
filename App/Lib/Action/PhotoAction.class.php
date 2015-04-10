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
		$m = memcache_init();
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
            //var_dump($info[0]);
            $Photo = M("Photo");
            //$data['uid'] = $m->get('uid');
            $data['uid'] = $_SESSION['uid'];
            $phptime = time();
            $mysqltime = date("Y-m-d H:i:s", $phptime);
            //$phptime = strtotime($mysqltime);
            $data['time'] = $mysqltime;
            $data['pname'] = $info[0]['savename'];
            $data['path'] = $info[0]['savepath'];
            $data['hash'] = $info[0]['hash'];
            $data['impression'] = $_POST['feelings'];
            //print_r($data);
            $res = $Photo->add($data);       //将图片信息存进数据库
            //print_r($res);
            //echo "<br>";
            //echo $_SESSION['uid'];
        }

		$uid = $_SESSION['uid'];
        //$m = memcache_init();
        //$uid = $m->get('uid');
        $User = M("user");
		$condition['uid'] = $uid;
		$username = $User->where($condition)->field("name")->limit(1)->select();    //找出当前用户
		$username = $username[0]['name'];
		$user_photo_arr = array();
		//echo $uid;
		$user_photo_arr[] = $uid;     //把自己也放入用户数组
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
		$res_arr = $Photo->where($map)->field("uid, pname, path, impression")->order('time desc')->select();
		// 找出自己以及关注的用户发布的图片信息
		$i = 0;
		$user_arr = $User->where($map)->field('uid, name')->select();
		$user_map = array();
		foreach ($user_arr as $value) {
			$user_map[$value['uid']] = $value['name'];
		}
        if (IS_SAE) {
            foreach ($res_arr as &$value) {
                $value['name'] = $user_map[$value['uid']];
                $value['path'] = '__PUBLIC__/'.$value['path'];
            }
        } else {
            foreach ($res_arr as &$value) {
                $value['name'] = $user_map[$value['uid']];
                $value['path'] = '__PUBLIC__/'.substr($value['path'], 9);
            }
        }
        
		//echo "hello<br />";
		//print_r($res_arr);
		//$this->display();
		$this->assign('photo_array', $res_arr);
		$this->assign('username', $username);
		$this->display();
	}

	public function upload() {
        $m = memcache_init();
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
            //var_dump($info[0]);
            $Photo = M("Photo");
            $data['uid'] = $_SESSION['uid'];
            //$data['uid'] = $m->get('uid');
            $phptime = time();
            $mysqltime = date("Y-m-d H:i:s", $phptime);
            //$phptime = strtotime($mysqltime);
            $data['time'] = $mysqltime;
            $data['pname'] = $info[0]['savename'];
            $data['path'] = $info[0]['savepath'];
            $data['hash'] = $info[0]['hash'];
            $data['impression'] = $_POST['feelings'];
            //print_r($data);
            $res = $Photo->add($data);
            //print_r($res);
            //echo "<br>";
            //echo $_SESSION['uid'];
        }
        $this->display('index');
    }

    public function user($uid)
    {
        # code...
        //echo $uid;
        $m = memcache_init();
        $photo = M("Photo");
        $condition['uid'] = $uid;
        $photo_arr = $photo->where($condition)->field("uid, pname, path, impression")->order('time desc')->limit(5)->select();
        if (IS_SAE) {
            foreach ($photo_arr as &$value) {
                $value['path'] = '__PUBLIC__/'.$value['path'];
            }
        } else {
            foreach ($photo_arr as &$value) {
                $value['path'] = '__PUBLIC__/'.substr($value['path'], 9);
            }
        }
        $uid = $_SESSION['uid'];
        //$uid = $m->get('uid');
        $condition['uid'] = $uid;
        $user = M('user');
        $username = $user->where($condition)->limit(1)->select();
        $this->assign('username', $username['0']['name']);
        $this->assign('photo_array',$photo_arr);
        $this->display();
    }

    public function submitComment($cm = '')
    {
        echo "Yes";
        $data['comment'] = $cm;
        $Comment = M("comment");
        $Comment->add($data);
        $this->ajaxReturn("Yes");
    }
}