<div class="wrap">
	<h1 class="wp-heading-inline">Doctors</h1>
	<a href="<?php echo admin_url( 'admin.php?page=doctor-menu&action=new'); ?>" class="page-title-action"><?php _e( 'Add new', 'Enzaime' ); ?></a>
	
	<?php if( isset( $_GET[ 'doctor-inserted' ] ) && $_GET[ 'doctor-inserted' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( 'Doctor has been inserted successfully.', 'Enzaime' ); ?></p>
		</div>
	<?php endif; ?>	

	<?php if( isset( $_GET[ 'doctor-update' ] ) && $_GET[ 'doctor-update' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( 'Doctor has been updated successfully.', 'Enzaime' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if( isset( $_GET[ 'doctor-delete' ] ) && $_GET[ 'doctor-delete' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( 'Doctor has been deleted successfully.', 'Enzaime' ); ?></p>
		</div>
	<?php endif; ?>
	
	<form action="" method="post">
		<?php 
			$table = new Enzaime\Appointment\Admin\Doctor_List();
			$table->prepare_items();
			$table->display();
		?>
	</form>
</div>