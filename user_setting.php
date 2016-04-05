<?php 
require 'core/init.php';
protected_page();
require 'includes/overall/overall-header.php';

if (empty($_POST) == false) {
	$req_fields = array('new_first_name','new_email');
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $req_fields)== true) {
			$errors[] = 'Please fill the * fields.';
			break 1;
		}
	}
	if (empty($errors)) {
		if (filter_var($_POST['new_email'] , FILTER_VALIDATE_EMAIL) == false) {
			$errors[] = 'A valid email address is required';
		}
		if (email_exists($_POST['new_email'])) {
			if ($_POST['new_email'] !== $user_data['email']) {
				$errors[] = 'Sorry the email \'' . $_POST['email'] . '\' is in use. ';
			}
		}
	}

	// print_r($errors);
} ?>
	<h1>Change Settings</h1>

	<?php 

		if (isset($_GET['changed_sucsses']) == true && empty($_GET) == false) {
			echo "<p>Your account changed successfuly.</p>";
		} else  {
			if (empty($_POST) == false && empty($errors) == true) {
				$change_setting_data = array (
				'first_name'	=> $_POST['new_first_name'],
				'last_name'		=> $_POST['new_last_name'],
				'email'			=> $_POST['new_email']
				);
				change_setting($session_user_id,$change_setting_data);
				redirect_user('user_setting.php?changed_sucsses');
			} else if (empty($errors) == false) {
				echo error_report($errors);
			} 
			
		?>

	<form action="" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td><label for="username">Username :</label></td>
				<td><input type="text" name="username" value="<?php echo $user_data['username'] ?>" disabled> You can not change your username.</td>
			</tr>
			<tr>
				<td><label for="new_first_name">First name :</label></td>
				<td><input type="text" name="new_first_name" value="<?php echo $user_data['first_name'] ?>"></td>
			</tr>
			<tr>
				<td><label for="new_last_name">Last name :</label></td>
				<td><input type="text" name="new_last_name" value="<?php echo $user_data['last_name'] ?>"></td>
			</tr>
			<tr>
				<td><label for="new_email">Email :</label></td>
				<td><input type="text" name="new_email" value="<?php echo $user_data['email'] ?>"></td>
			</tr>
			<tr>
				<td><input type="submit" value="Update"></td>
			</tr>
		</table>
	</form>
<?php } require 'includes/overall/overall-footer.php'; ?>