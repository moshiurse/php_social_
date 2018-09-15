<?php

class Post {

	private $user_obj;
	private $con;

	public function __construct($con, $user){
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}

	public function submitPost($body, $user_to){

	$body = strip_tags($body);
	$body = mysqli_real_escape_string($this->con, $body);
	$check_empty = preg_replace('/\s+/', '', $body);

	if ($check_empty != "") {
		
		$date_added = date("Y-m-d H:i:s");

		$added_by = $this->user_obj->getUserName();

		if ($user_to == $added_by) {
			$user_to = "none";
		}

		$query = mysqli_query($this->con, "insert into posts values ('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");

		$returned_id = mysqli_insert_id($this->con);

		//update count post

		$num_post = $this->user_obj->getNumPost();
		$num_post++;

		$update_query = mysqli_query($this->con, "update users set num_post='$num_post' where username='$added_by'");

	}

	}

}



?>