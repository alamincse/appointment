<div class="wrap">
	<h1 class="wp-heading-inline">Register User List</h1>
	<?php if( isset( $_GET[ 'user-update' ] ) && $_GET[ 'user-update' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( 'User has been updated successfully.', 'Enzaime' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if( isset( $_GET[ 'user-delete' ] ) && $_GET[ 'user-delete' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( 'User has been deleted successfully.', 'Enzaime' ); ?></p>
		</div>
	<?php endif; ?>
	
	<form action="" method="post">
		<?php 
			$table = new Parbona\Admin\User_List();
			$table->prepare_items();
			$table->display();
		?>
	</form>
</div>