<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");



	if (isset($_POST['btn_post'])) {
		$post = new Post($con, $userLogged);
		$post->submitPost($_POST['post_text'], "none");
	}

?>

	<div class="user_details column">
		<a href="<?php echo $userLogged; ?>"> <img src="<?php echo $user['profile_pic']; ?>"></a>

		<div class="user_details_left_right">
		<a href="<?php echo $userLogged; ?>">
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

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Whats on your mind?"></textarea>
			<input type="submit" name="btn_post" id="btn_post" value="Post">
			<hr>
		</form>




	<?php

    $post = new Post($con, $userLogged);
    $post->loadPostsFriends();

	?>

	</div>
 



</div>
</body>
</html>