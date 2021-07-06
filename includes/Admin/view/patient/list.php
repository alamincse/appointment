<div class="wrap">
	<h1 class="wp-heading-inline"><?php _e( 'Patient List', 'Enzaime' ); ?></h1>
	<a href="<?php echo admin_url( 'admin.php?page=patient-menu&action=new' ); ?>" class="page-title-action"><?php _e( 'Add patient', 'Enzaime' ); ?></a>
	
	<?php if( isset( $_GET[ 'patient-inserted' ] ) && $_GET[ 'patient-inserted' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( 'Patient has been inserted successfully.', 'Enzaime' ); ?></p>
		</div>
	<?php endif; ?>	
	
	<form action="" method="post">
		<?php 
			$table = new Enzaime\Appointment\Admin\Patient_List();
			$table->prepare_items();
			$table->display();
		?>
	</form>
</div>