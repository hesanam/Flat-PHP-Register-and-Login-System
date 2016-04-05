<?php

	function change_profile_image($user_id,$file_temp,$file_extn){
		$user_id = (int)$user_id;
		$file_path = 'images/profile/' . substr(sha1(time()), 0 , 13) . '.' . $file_extn;
		move_uploaded_file($file_temp, $file_path);

		mysql_query("UPDATE `users` SET `profile` = '" . $file_path . "' WHERE `user_id` = $user_id");
	}

	function is_admin($user_id){
		$user_id = (int)$user_id;
		return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `type` = 1"), 0) == 1) ? true : false;
	}

	function user_gender($gender){

		if ($gender == 1) {
			return "Male";
		} else if ($gender == 2){
			return "Female";
		} else {
			return "Not Defined";
		}

	}

	function change_setting($user_id, $setting_data){
		array_walk($setting_data, 'array_sanitize');
		$user_id = (int)$user_id;
		$update_data = array();

		foreach ($setting_data as $field => $data) {
			$update_data[] = '`' . $field . "` = '" . $data . "'";
		}
		$update = implode(',', $update_data);

		mysql_query("UPDATE `users` SET $update WHERE `user_id` = $user_id ");
	}

	function change_password($user_id,$new_password){
		sanitize($new_password);
		$user_id = (int)$user_id;
		$new_password = hash('md5', $new_password);

		mysql_query("UPDATE `users` SET `password` = '$new_password' WHERE `user_id` =  $user_id ");

	}

	function register_user($register_data){
		// Saniteize the whole array using array_walk.
		array_walk($register_data, 'array_sanitize');

		// Hash the password.
		$register_data['password'] = hash('md5', $register_data['password']);

		// Fetch the data out of the register_data array.
		$data = '\'' . implode('\',\'', $register_data) . '\'';
		// Getting the keys of the register_data array in order to make the query more flexible.
		$fields = '`'. implode('`,`', array_keys($register_data)) . '`';
		
		// BAAANG ! User registered.
		mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	}

	function user_count(){
		return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), 0);
	}

	function user_data($user_id){
		$data = array();
		$user_id = (int)$user_id;

		$func_num_args = func_num_args();
		$func_get_args = func_get_args();
		
		if($func_num_args > 1){
			unset($func_get_args[0]);

			$fields = '`' . implode('`,`', $func_get_args) . '`';
			$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id"));

			return $data;
		}
	}

	function user_exists($username){
		$username = sanitize($username);
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");

		return (mysql_result($query, 0 ) == 1) ? true : false;
	}

	function email_exists($email){
		$email = sanitize($email); 
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");

		return (mysql_result($query, 0 ) == 1) ? true : false;
	}

	function user_active($username){
		$username = sanitize($username);
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `active` = 1 ");

		return (mysql_result($query, 0 ) == 1) ? true : false;
	}

	function user_id_from_username($username){
		$username = sanitize($username);

		return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"), 0,'user_id');
	}

	function login($username, $password){
		$user_id = user_id_from_username($username);

		$username = sanitize($username);
		$password = md5($password);

		return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'"),0) == 1) ? $user_id : false;
	}

	function is_logged(){
		return (isset($_SESSION['user_id'])) ? true : false;
	}