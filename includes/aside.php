<div class="col col-sm-4 sidebar">
	<aside>
		<?php 
			if(is_logged()){
				require 'includes/widgets/logged_in.php'; 
			} else {
				require 'includes/widgets/login.php'; 
			}
			require 'includes/widgets/user_count.php';
		?>
	</aside>
</div>



		
