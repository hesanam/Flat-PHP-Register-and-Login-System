<?php
require 'core/init.php';
protected_page();
require 'includes/overall/overall-header.php';

if (empty($_POST) == false){
	$req_fields = array('current_password','new_password','new_password_again');
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $req_fields)== true) {
			$errors[] = 'Please fill the * fields.';
			break 1;
		}
	}
	if (empty($errors)) {
		if (hash('md5', $_POST['current_password']) == $user_data['password']) {
			if (trim($_POST['new_password']) !== trim($_POST['new_password_again'])) {
				$errors[] = 'Passwords are not matched.';
			} else if (strlen($_POST['new_password']) < 6) {
				$errors[] = 'Password must be at least 6 characters.';
			}
		} else {
			$errors[] = 'Your password does not match with our database.';
		}
	}
}

?>

	<h1>Change your password</h1>
	<?php 
	if (isset($_GET['success']) == true && empty($_GET) == false) {
		echo "<br><p>Your password successfully updated.</p>";
	} else {
		if (empty($_POST) == false && empty($errors) == true) {
			$new_password = $_POST['new_password'];
			$user_id = $session_user_id;
			change_password($user_id ,$new_password);
			// Redirect user.
			redirect_user('changepassword.php?success');
		} else if (empty($errors) == false) {
			echo error_report($errors);
		}

	 ?>
	<form action="" method="post">
		<table>
			<tr>
				<td><label for="current_password">Current Password*:</label></td>
				<td><input type="password" name="current_password"></td>
			</tr>
			<tr>
				<td><label for="new_password">New Password*:</label></td>
				<td><input type="password" name="new_password"></td>
			</tr>
			<tr>
				<td><label for="new_password_again">Repeat New Password*:</label></td>
				<td><input type="password" name="new_password_again"></td>
			</tr>
			<tr>
				<td><input type="submit" value="Change password"></td>
			</tr>
		</table>
	</form>
<?php } require 'includes/overall/overall-footer.php'; ?>
