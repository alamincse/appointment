<?php 

namespace Enzaime\Appointment;

class Form {
	public static function form_handle() {

		global $wpdb;
		
		if( isset( $_POST['submit_doctor'] ) ) {
			echo 'ok';
		}
		// if( ! isset( $_POST['submit_doctor'] ) ) {
		// 	return;
		// }

		if( isset($_POST['_wpnonce']) &&  ! wp_verify_nonce($_POST['_wpnonce'], 'new-doctor') ) {
			wp_die( 'Oops, Something is wrong');
		}

		// return 'ok';
	}
}