<?php 
	
	function redirect_user($header){
		header('Location:' . $header);
		exit();
	}

	function admin_protected(){
		global $user_data;
		if (is_admin($user_data['user_id']) == false) {
			redirect_user('index.php');
		}
	}

	// Protect the login page from access directly from the URL bar.
	function logged_in_protected(){
		if (is_logged()) {
			redirect_user('index.php');
		}
	}

	// Protect any page from who ever s not logged in.
	function protected_page(){
		if (is_logged() == false) {
			redirect_user('protected.php');
		}
	}

	// Array sanitize function.
	function array_sanitize(&$item){
		$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
	}

	// General sanitize function.
	function sanitize($data){
		return htmlentities(strip_tags(mysql_real_escape_string($data)));
	}

	// Error reporting with a ul > li output.
	function error_report($errors){
		// Wrap errors with ul and li for each error.
		return '<ul><li>' . implode('</li><li>', $errors) .'</li></ul>';
	}
	
