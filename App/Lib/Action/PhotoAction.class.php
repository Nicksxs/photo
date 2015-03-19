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
		$username = $_SESSION['username'];
		echo $username;
		//$this->display();
		$this->display();
	}
}