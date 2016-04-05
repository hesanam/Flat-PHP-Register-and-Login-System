<?php 
require 'core/init.php';
logged_in_protected();
	if(empty($_POST) == false){
		$username= $_POST['username'];
		$password= $_POST['password'];

	if(empty($username)== true || empty($password) == true){
		$errors[] = 'Cant let those username and password empty. Please fill them.';
	} else if(user_exists($username) == false){
		$errors[] = 'This username doesn\'t exist. Did you registered ?';
	} else if(user_active($username) == false){
		$errors[] = 'Seems like you haven\'t activate your account yet.';
	} else {

		if(strlen($password > 32)){
			$errors[]="Password is too long.";
		}

		$login = login($username, $password);
		if($login == false){
			$errors[] = 'The username or password might be false. Please review it.';
		}else{
			//set the user session
			$_SESSION['user_id'] = $login;
			//redirect user to home
			redirect_user('index.php');

		}
	}
} else {
	redirect_user('index.php');
}

require 'includes/overall/overall-header.php';
?>
<h2>Whoops, I tried but ...</h2>
<?php echo error_report($errors); ?>
<?php
	// var_dump($errors);
require 'includes/overall/overall-footer.php';
 ?>