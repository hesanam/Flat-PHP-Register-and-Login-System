<?php 
	require 'core/init.php';
	protected_page();
	admin_protected();
	require 'includes/overall/overall-header.php'; ?>
	<h1>Admin Page</h1>
	<p>This is the admin control panel</p>
	<?php 
		if (is_admin($user_data['user_id'])) {
			echo "admin";
		}
	 ?>
<?php require 'includes/overall/overall-footer.php'; ?>
	