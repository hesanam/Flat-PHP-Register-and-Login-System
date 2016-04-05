<?php
	require 'core/init.php';
	
	require 'includes/overall/overall-header.php'; 

	if(empty($_POST) == false){
		$req_fields = array('username','password','password_again','first_name','gender','email');
		foreach ($_POST as $key => $value) {
			if (empty($value) && in_array($key, $req_fields)== true) {
				$errors[] = 'Please fill the * fields.';
				break 1;
			}
		}

		if (empty($errors)) {
			if(user_exists($_POST['username']) == true){
				$errors[] = 'Sorry the username \'' . $_POST['username'] . '\' has been taken. ';
			}
			if (preg_match("/\\s/", $_POST['username']) == true) {
				$errors[] = 'Username must not contain any spaces.';
			}
			if ($_POST['password'] != $_POST['password_again']) {
				$errors[] = 'Passwords are not matched.';
			}
			if (strlen($_POST['password']) < 6) {
				$errors[] = 'Password must be at least 6 characters';
			} 
			if (filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) == false) {
				$errors[] = 'A valid email address is required.';
			}
			if (email_exists($_POST['email'])) {
				$errors[] = 'Sorry the email \'' . $_POST['email'] . '\' is in use. ';
			}
		}
	}
	// print_r($errors);
	?>
	<?php 

	if (isset($_GET['success']) == true && empty($_GET) == false) {
		echo "<br><p>Thank you for registering. A confirmation email has been sent to your email address.</p>";
	} else { ?>
		<h1>Register page</h1>
		<br>
	<?php 
		if (empty($_POST) == false && empty($errors) == true) {
			$register_data = array(
				'username'		 => $_POST['username'],
				'password'  	 => $_POST['password'],
				'first_name'	 => $_POST['first_name'],
				'last_name'	   	 => $_POST['last_name'],
				'email'			 => $_POST['email'],
				'gender'		 => $_POST['gender']
			);

			// Register user with the data.
			register_user($register_data);
			// Redirect user.
			redirect_user('register.php?success');

		} else if (empty($errors)==false) {
			echo error_report($errors) . '<br>';
		}
	
	?>
	<form action="" method="post">
		<table class="register">
			<tr>
				<td><label for="username">Username*:</label></td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td><label for="password">Password*:</label></td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td><label for="password">Repeat password*:</label></td>
				<td><input type="password" name="password_again"></td>
			</tr>
			<tr>
				<td><label for="first_name">First name*:</label></td>
				<td><input type="text" name="first_name"></td>
			</tr>
			<tr>
				<td><label for="last_name">Last name:</label></td>
				<td><input type="text" name="last_name"></td>
			</tr>
			<tr>
				<td><label for="gender">Gender*:</label></td>
				<td><input type="radio" name="gender" value="1"> Male
					<input type="radio" name="gender" value="2"> Female
				</td>
			</tr>
			<tr>
				<td><label for="email">Email*:</label></td>
				<td><input type="text" name="email"></td>
			</tr>
			<tr>
				<td><input type="submit" value="Register"></td>
				<td><input type="reset" value="Reset"></td>
			</tr>
		</table>
	</form>
<?php } require 'includes/overall/overall-footer.php'; ?>