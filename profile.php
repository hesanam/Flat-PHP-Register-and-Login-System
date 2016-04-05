<?php 
	require 'core/init.php';
	require 'includes/overall/overall-header.php'; 
	
	if (isset($_GET['username']) == true && empty($_GET['username']) == false) {
		$username = $_GET['username'];
		if (user_exists($username)) {
			$user_id = user_id_from_username($username);
			$profile_data = user_data($user_id,'first_name','last_name','email','profile');
			// var_dump($profile_data['profile']);
		?>
		<h2>Welcome</h2>
		<div class="profile-data">
			<?php if (empty($profile_data['profile']) == false): ?>
				<div class="profile-page-pic">
					<img src='<?php echo $profile_data['profile'] ?>' alt='<?php echo $profile_data['first_name']?>'>
				</div>
			<?php endif ?>
			<p>This is <h1><?php echo $profile_data['first_name']; ?></h1>'s Profile.
			You can call [H] by [H] last name <h3><?php echo $profile_data['last_name']; ?></h3> if you like to.
			And you can have contact with [H] with this email address <h4><a href="mailto:<?php echo $profile_data['email']; ?>"><?php echo $profile_data['email']; ?></a></h4></p>
		</div>
		<?php
		} else {
			echo "<br><h4>Sorry the username '" .$username."' Doesn't exist.</h4>" ;
		}
	} else {
		redirect_user('index.php');
	}

    require 'includes/overall/overall-footer.php'; ?>