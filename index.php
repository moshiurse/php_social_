<?php
require "includes/header.php";

?>

	<div class="user_details column">
		<a href="#"> <img src="<?php echo $user['profile_pic']; ?>"></a>

		<div class="user_details_left_right">
		<a href="#">
		<?php
			echo $user['first_name'] . " " . $user['last_name'];
		?> 
		</a>

		<?php
			echo "<br>Posts: ". $user['num_post'] . "<br>";
			echo "Likes: ". $user['num_likes'] . "<br>";
		?>
		</div>

	</div>

	<div class="main_column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Whats on your mind?"></textarea>
			<input type="submit" name="btn_post" id="btn_post" value="Post">
			<hr>
		</form>
	</div>

</div>
</body>
</html>