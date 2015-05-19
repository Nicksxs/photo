<?php

/**
 * show the fhoto
 */
class PhotoAction extends Action {

	public function _initialize() {
		# code...
		header("Content-Type:text/html; charset=utf-8");
	}

	public function index() {
		$m = memcache_init();
		if (!empty($_FILES)) {
			import("@.ORG.UploadFile");
			$config = array(
				'allowExts' => array('jpg', 'gif', 'png'),
				'savePath' => './Public/upload/',
				'saveRule' => 'time',
			);
			$upload = new UploadFile($config);
			$upload->imageClassPath = "@.ORG.Image";
			$upload->thumb = true;
			$upload->thumbMaxHeight = 100;
			$upload->thumbMaxWidth = 100;
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
			$res = $Photo->add($data); //将图片信息存进数据库
			//print_r($res);
			//echo "<br>";
			//echo $_SESSION['uid'];
		}

		$uid = $_SESSION['uid'];
		//$m = memcache_init();
		//$uid = $m->get('uid');
		$User = M("user");
		$condition['uid'] = $uid;
		$username = $User->where($condition)->field("name")->limit(1)->select(); //找出当前用户
		$username = $username[0]['name'];
		$user_photo_arr = array();
		//echo $uid;
		$user_photo_arr[] = $uid; //把自己也放入用户数组
		//echo "<br />";
		$condition['uid'] = $uid;
		$rela = M("relationship");
		$ruid_arr = $rela->where($condition)->select();
		$following_num = count($ruid_arr);
		for ($i = 0; $i < $following_num; $i++) {
			$user_photo_arr[] = $ruid_arr[$i]['ruid'];
		}
		$map['uid'] = array('in', $user_photo_arr);
		$Photo = M("photo");
		$res_arr = $Photo->where($map)->field("pid, uid, time, pname, path, impression, comments, likes")->order('time desc')->select();
		// 找出自己以及关注的用户发布的图片信息
		$i = 0;
		$user_arr = $User->where($map)->field('uid, name')->select();
		$user_map = array();
		foreach ($user_arr as $value) {
			$user_map[$value['uid']] = $value['name'];
		}

        $now_time = time();
		if (IS_SAE) {
			foreach ($res_arr as &$value) {
				$value['name'] = $user_map[$value['uid']];
				$value['path'] = '__PUBLIC__/' . $value['path'];
                $elapse = strtotime($value['time']);
                $diff = $now_time - $elapse;
                $value['elapse'] = $this->time2Units($diff);
			}
		} else {
			foreach ($res_arr as &$value) {
				$value['name'] = $user_map[$value['uid']];
				$value['path'] = '__PUBLIC__/' . substr($value['path'], 9);
                $elapse = strtotime($value['time']);
                $diff = $now_time - $elapse;
                //echo $diff;
                $value['elapse'] = $this->time2Units($diff);
			}
		}
		//exit();

		//将图片id放进一个数组
		$pid_arr = array();
		foreach ($res_arr as $value_tmp) {
			$pid_arr[] = $value_tmp['pid'];
		}


		$map = array();
		$map['pid'] = array('in', $pid_arr);
		$cm = M("comment");
		$cm_arr = $cm->where($map)->field("uid, pid, comment")->order('time desc')->select();
		/*$comment_pid_arr = array();
		$comment_arr = array();*/
		$i = 0;
		$cm_uid_arr = array();
		foreach ($cm_arr as $value1) {
			$cm_uid_arr[] = $value1['uid'];
		}
		$map = array();
//		$user_arr = array();
		$map['uid'] = array('in', $cm_uid_arr);
		$user_arr = $User->where($map)->field("uid, name")->select();
		$user_map = array();
		foreach ($user_arr as $value2) {
			$user_map[$value2['uid']] = $value2['name'];
		}

		foreach ($cm_arr as &$value3) {
			$value3['name'] = $user_map[$value3['uid']];
			foreach ($res_arr as &$v) {
				# code...
				if ($v['pid'] == $value3['pid']) {
					$v['comment'][] = $value3;
				}
			}
			//$res_arr[$value['pid']]['comment'][] = $value;
		}



		$Like = M("like");
		$map = array();
		$map['pid'] = array('in', $pid_arr);
		$lk_arr = $Like->where($map)->field("uid, pid")->order("time desc")->select();
		$lk_uid_arr = array();
		foreach ($lk_arr as $value1) {
			$lk_uid_arr[] = $value1['uid'];
		}
		$map = array();
		$map['uid'] = array('in', $lk_uid_arr);
		$user_map = array();
		$user_arr = $User->where($map)->field("uid, name")->select();
		foreach ($user_arr as $value2) {
			$user_map[$value2['uid']] = $value2['name'];
		}

		//print_r($lk_arr);
		foreach ($lk_arr as &$value4) {
			$value4['name'] = $user_map[$value4['uid']];
			foreach ($res_arr as &$v1) {
				if ($v1['pid'] == $value4['pid']) {
					$v1['like'][] = $value4;
					if ($value4['uid'] == $uid) {
						$v1['islike'] = 100;
					}else{
                        $v1['islike'] = -1;
                    }
				}
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
			$config = array(
				'allowExts' => array('jpg', 'gif', 'png'),
				'savePath' => './Public/upload/',
				'saveRule' => 'time',
			);
			$upload = new UploadFile($config);
			$upload->imageClassPath = "@.ORG.Image";
			$upload->thumb = true;
			$upload->thumbMaxHeight = 100;
			$upload->thumbMaxWidth = 100;
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

	public function user($uid) {
		# code...
		//echo $uid;
		$ruid = $uid;
		$m = memcache_init();
		$photo = M("Photo");
		$condition['uid'] = $uid;
		$photo_arr = $photo->where($condition)->field("pid, uid, pname, time, path, impression, comments, likes")->order('time desc')->limit(0, 10)->select();
		$count = 0;
		$photo_thumb_arr = array();
		$i = 0;
		$j = 0;
        $IsNewMonth = '-1';
		if (IS_SAE) {
			foreach ($photo_arr as &$value) {
				$value['path'] = '__PUBLIC__/' . $value['path'];
				$value['thumb_pname'] = 'thumb_' . $value['pname'];
                $phptime = strtotime($value['time']);
                $value['day'] = date("d F Y", $phptime);
                $month = date("F", $phptime);
                if($IsNewMonth == '-1' || $month != $IsNewMonth){
                    $value['month'] = date("F Y", $phptime);
                }
                $IsNewMonth = $month;
				$count++;
				if ($j == 5) {
					$j = 0;
					$i++;
					$photo_thumb_arr[$i][$j++] = $value;
				} else {
					$photo_thumb_arr[$i][$j++] = $value;
				}
			}
		} else {
			foreach ($photo_arr as &$value) {
				$value['path'] = '__PUBLIC__/' . substr($value['path'], 9);
				$value['thumb_pname'] = 'thumb_' . $value['pname'];
                $phptime = strtotime($value['time']);
                $value['day'] = date("d F Y", $phptime);
                $month = date("F", $phptime);
                if($IsNewMonth == '-1' || $month != $IsNewMonth){
                    $value['month'] = date("F Y", $phptime);
                }
                $IsNewMonth = $month;
				$count++;
				if ($j == 5) {
					$j = 0;
					$i++;
					$photo_thumb_arr[$i][$j++] = $value;
				} else {
					$photo_thumb_arr[$i][$j++] = $value;
				}
			}
		}
		$uid = $_SESSION['uid'];
		//$uid = $m->get('uid');
		$condition['uid'] = $uid;
		$user = M('user');
		$username = $user->where($condition)->limit(1)->select();

		$re = M("relationship");
		$condition['ruid'] = $ruid;
		$condition['uid'] = $uid;
		$res = $re->where($condition)->select();
		if (isset($res[0])) {
			$f = 'y';
		} else {
			$f = 'n';
		}
		$fdcount = 0; //关注我的人数
		$condition = array();
		$condition['ruid'] = $ruid;
		$fdcount = $re->where($condition)->count();
		$fgcount = 0; // 我关注的人数
		$condition = array();
		$condition['uid'] = $ruid;
		$fgcount = $re->where($condition)->count();
		$this->assign('f', $f);
		$this->assign('followers', $fdcount);
		$this->assign('following', $fgcount);
		$this->assign('username', $username['0']['name']);
		$this->assign('posts', $count);
		$this->assign('ruid', $ruid);
		$this->assign('photo_array', $photo_arr);
		$this->assign('photo_thumb_array', $photo_thumb_arr);
//        print_r($photo_arr);
		$this->display();
	}

	public function submitComment($cm = '', $pid = '') {

		$Photo = M("photo");
		$condition['pid'] = $pid;
		$result = $Photo->where($condition)->field('comments')->limit(1)->select();
		$count = $result[0]['comments'];
		$data['comments'] = $count + 1;
		$Photo->where($condition)->save($data);

		$data = array();
		$data['pid'] = $pid;
		$data['uid'] = $_SESSION['uid'];
		$data['comment'] = $cm;
		$phptime = time();
		$mysqltime = date("Y-m-d H:i:s", $phptime);
		$data['time'] = $mysqltime;
		$Comment = M("comment");
		$Comment->add($data);
		$this->ajaxReturn("Yes");
	}

	public function submitLike($pid = '', $like = '') {
        if($like == 'n'){
            $photo = M("photo");
            $condition['pid'] = $pid;
            $result = $photo->where($condition)->field('likes')->limit(1)->select();
            $count = $result[0]['likes'];
            $data['likes'] = $count + 1;
            $photo->where($condition)->save($data);

            $data = array();
            $data['pid'] = $pid;
            $data['uid'] = $_SESSION['uid'];
            $phptime = time();
            $mysqltime = date("Y-m-d H:i:s", $phptime);
            $data['time'] = $mysqltime;
            $Likes = M("like");
            $Likes->add($data);
            $this->ajaxReturn("Yes");
        }else{
            $photo = M("photo");
            $condition['pid'] = $pid;
            $result = $photo->where($condition)->field('likes')->limit(1)->select();
            $count = $result[0]['likes'];
            $data['likes'] = $count - 1;
            $photo->where($condition)->save($data);

            $condition = array();
            $condition['pid'] = $pid;
            $condition['uid'] = $_SESSION['uid'];
            $Likes = M("like");
            $Likes->where($condition)->delete();
            $this->ajaxReturn("Yes");
        }

	}

	public function follow($ruid = '', $f = '') {
		# code...
		$re = M("relationship");
		if ($f == 'y') {
			# code...
			// $condition['ruid'] = $ruid;
			// $condition['uid'] = $_SESSION['uid'];
			// $res = $re->where($condition)->limit(1)->select();
			// if ($res) {
			//     $re->select();
			//     $this->ajaxReturn("Yes");
			// }else{
			// $data['ruid'] = $ruid;
			// $data['uid'] = $_SESSION['uid'];
			$data['ruid'] = $ruid;
			$data['uid'] = $_SESSION['uid'];
			//dump($condition);
			$re->add($data);
			$this->ajaxReturn("Yes");
			// }
		} else {
			$condition['ruid'] = $ruid;
			$condition['uid'] = $_SESSION['uid'];
			$res = $re->where($condition)->delete();
			if ($res) {
				//$this->ajaxReturn("Yes");
			}
			//$this->ajaxReturn("Yes");
		}
	}

    private function time2Units ($time)
    {
        $year   = floor($time / 60 / 60 / 24 / 365);
        $time  -= $year * 60 * 60 * 24 * 365;
        $month  = floor($time / 60 / 60 / 24 / 30);
        $time  -= $month * 60 * 60 * 24 * 30;
        $week   = floor($time / 60 / 60 / 24 / 7);
        $time  -= $week * 60 * 60 * 24 * 7;
        $day    = floor($time / 60 / 60 / 24);
        $time  -= $day * 60 * 60 * 24;
        $hour   = floor($time / 60 / 60);
        $time  -= $hour * 60 * 60;
        $minute = floor($time / 60);
        $time  -= $minute * 60;
        $second = $time;
        $elapse = '';

        $unitArr = array('年'  =>'year', '个月'=>'month',  '周'=>'week', '天'=>'day',
            '小时'=>'hour', '分钟'=>'minute', '秒'=>'second'
        );

        foreach ( $unitArr as $cn => $u )
        {
            if ( $$u > 1 )
            {
                $elapse = $$u . " " .$u . "s";
                break;
            }elseif ( $$u > 0 )
            {
                $elapse = $$u . " " . $u;
                break;
            }
            if($$u == 0 && $u == 'seond'){
                $elapse = '1 seond';
            }
        }

        /*foreach ( $unitArr as $cn => $u )
        {
            if ( $$u > 0 )
            {
                $elapse = $$u . $cn;
                break;
            }
        }*/

        return $elapse." ago";
    }
}