<div class="widget">
	<h3>Hello <?php echo $user_data['first_name']; ?>!</h3>
	<div class="widget-content">
		<div class="profile-pic">
			<?php 
				if (isset($_FILES['profile']) == true) {    
					       
					if (empty($_FILES['profile']['name']) == true) {
						echo "Please choose a file.";
					} else {
						$allowed_formats	= ['jpg','jpeg','gif','png'];

						$file_name			= $_FILES['profile']['name'];
						$file_extn			= strtolower(end(explode('.', $file_name)));
						$file_temp			= $_FILES['profile']['tmp_name'];
						$file_size 			= floor(($_FILES['profile']['size']/1024)*100)/100 ; // To kilobytes.

						if (in_array($file_extn, $allowed_formats)) {
							if ($file_size > 20) {
								echo "Choose a file with the size of lower than 20kb.";
							} else if($file_size == 0) {
								echo "File size is equal to 0kb. Select a valid file.";
							} else {
								change_profile_image($session_user_id,$file_temp,$file_extn);
								redirect_user($current_file);
							}
						} else {
							echo "Allowed files are : " . implode(', ', $allowed_formats);
						}
					}
				}
				if (empty($user_data['profile']) == false) { ?>

					<img src='<?php echo $user_data['profile'] ?>' alt='<?php echo $user_data['first_name'] ?>'>
					
				<?php } else { ?>
					<p>There is no profile picture.</p>
					<form action="" method="post" enctype="multipart/form-data">
						<input type="file" name="profile">
						<input type="submit" value="Submit">
					</form>
				<?php } ?>
		</div>
		

		<ul>
			<?php if (is_admin($user_data['user_id']) == true) { ?>
				<li><a href='admin.php'>Administrative page</a></li>
			<?php } else {
				echo "";
			}?>
			<li><a href="<?php echo $user_data['username']; ?>">Profile</a></li>
			<li><a href="changepassword.php">Change password</a></li>
			<li><a href="user_setting.php">Setting</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>
</div>