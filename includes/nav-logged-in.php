<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $user_data['first_name']; ?><span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="<?php echo $user_data['username']; ?>">Profile</a></li>
			<li><a href="changepassword.php">Change password</a></li>
			<li><a href="user_setting.php">Setting</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</li>
</ul>