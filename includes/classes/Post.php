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

	public function loadPostsFriends(){
	    $str = "";
	    $data = mysqli_query($this->con, "select * from posts where deleted='no' order by id desc");

	    while ($row = mysqli_fetch_array($data)){
	        $id = $row['id'];
	        $body = $row['body'];
	        $added_by = $row['added_by'];
	        $date_time = $row['date_added'];

//	        prepare user to string...
            if ($row['user_to'] == none){
                $user_to = "";
            }else{
                $user_to_obj = new User($this->con, $row['user_to']);
                $user_to_name = $user_to_obj->getFirstAndLastName();
                $user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
            }

//            check whether user is closed or not
            $added_by_obj = new User($this->con, $added_by);
            if ($added_by_obj->isClosed()){
                continue;
            }

            $user_detail_query = mysqli_query($this->con, "select first_name, last_name, profile_pic from
                users where username='$added_by'");
            $user_row = mysqli_fetch_array($user_detail_query);

            $first_name = $user_row['first_name'];
            $last_name = $user_row['last_name'];
            $profile_pic = $user_row['profile_pic'];

//            Time Management
            $date_time_now = date("Y-m-d H:i:s");
            $start_date = new DateTime($date_time);
            $end_date = new DateTime($date_time_now);
            $interval = $start_date->diff($end_date);

            if ($interval->y >= 1){
                if ($interval->y == 1)
                    $time_message = $interval->y . " Year Ago";
                else
                    $time_message = $interval->y . " Year Ago";
            }else if($interval->m >= 1){
                if ($interval->d == 0){
                    $days = " ago";
                }else if($interval->d == 1){
                    $days = $interval->d . " day ago";
                } else {
                    $days = $interval->d . " days ago";

                }

                if ($interval->m == 1){
                    $time_message = $interval->m . " month ". $days;
                }else {
                    $time_message = $interval->m . " months ". $days;
                }
            }else if ($interval->d >= 1){
                if($interval->d == 1){
                    $time_message = "Yesterday";
                } else {
                    $time_message = $interval->d . " days ago";

                }
            }else if ($interval->h >= 1){
                if($interval->h == 1){
                    $time_message = $interval->h . " hour ago";
                } else {
                    $time_message = $interval->h . " hours ago";
                }
            }else if ($interval->i >= 1){
                if($interval->i == 1){
                    $time_message = $interval->i . " minute ago";
                } else {
                    $time_message = $interval->i . " minute ago";
                }
            }else {
                if($interval->s < 30){
                    $time_message = "Just now";
                } else {
                    $time_message = $interval->s . " seconds ago";
                }
            }

                $str .= "<div class='status_post'>
                <div class='post_profile_pic'>
                    <img src='$profile_pic' width='50'>
                </div>
                <div class='posted_by' style='color: #ACACAC;'>
                    <a href='$added_by'>$first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
                    </div>
                <div id='post_body'>
                    $body
                    <br>
                    <br>
                    <hr>
                </div>
                </div>";

        }

        echo $str;


    }

}



?>