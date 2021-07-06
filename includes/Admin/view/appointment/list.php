<div class="wrap">
	<h1 class="wp-heading-inline"><?php _e( 'Appointment List', 'Enzaime' ); ?></h1>
	<a href="<?php echo admin_url( 'admin.php?page=appointment-menu&action=new' ); ?>" class="page-title-action"><?php _e( 'Add new', 'Enzaime' ); ?></a>
	
	<?php if( isset( $_GET[ 'appointment-inserted' ] ) && $_GET[ 'appointment-inserted' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( 'Appointment has been inserted successfully.', 'Enzaime' ); ?></p>
		</div>
	<?php endif; ?>	
	
	<form action="" method="post">
		<?php 
			$table = new Enzaime\Appointment\Admin\Appointment_List();
			$table->prepare_items();
			$table->display();
		?>
	</form>
</div>