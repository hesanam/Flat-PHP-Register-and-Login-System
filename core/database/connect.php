<?php 
	
require 'db_errors.php';

$connection= mysql_connect('localhost','root','') or die($db_errors['connection_err']);
mysql_select_db('lr') or die($db_errors['db_find_err']);


 ?>