<?php 

namespace Enzaime\Appointment\Admin;

use Enzaime\Appointment\Install\Installer;

class Menu {
	function __construct() {
		add_action( 'admin_menu', [ $this, 'doctor_menu' ] );
		add_action( 'admin_menu', [ $this, 'appointment_menu' ] );
		add_action( 'admin_menu', [ $this, 'patient_menu' ] );
	}

	public function doctor_menu() {
		// 1st page title, 
		// 2nd menu title, 
		// 3rd who manage it, 
		// 4th slug url, 
		// 5th callback method, 
		// 6th menu icon.
		add_menu_page( __( 'Doctors', 'Enzaime'), __( 'Doctors', 'Enzaime'), 'manage_options', 'doctor-menu', [ $this, 'admin_doctor_page' ], 'dashicons-buddicons-buddypress-logo' );
	}


	public function appointment_menu() {
		add_menu_page( __( 'Appointments', 'Enzaime'), __( 'Appointments', 'Enzaime'), 'manage_options', 'appointment-menu', [ $this, 'admin_appointment_page' ], 'dashicons-buddicons-buddypress-logo' );	
	}	

	public function patient_menu() {
		add_menu_page( __( 'Patients', 'Enzaime'), __( 'Patients', 'Enzaime'), 'manage_options', 'patient-menu', [ $this, 'admin_patient_page' ], 'dashicons-buddicons-buddypress-logo' );	
	}

	public function admin_doctor_page() {
		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
		$path   = plugin_dir_path( __FILE__ );

		switch ( $action ) {
			case 'edit':
				$list     = new Doctor_List();
				$doctor   = $list->get_doctor( $id );
				$template = $path . 'view/doctor/edit.php';
				break;

			case 'new':
				$template = $path . 'view/doctor/new.php';
				break;
			
			default:
				$template = $path . 'view/doctor/list.php';
				break;
		}

		if( file_exists( $template ) ) {
			require_once $template;
		}
	}


	public function admin_appointment_page() {
		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$path   = plugin_dir_path( __FILE__ );

		switch ( $action ) {
			case 'new':
				$list     = new Appointment_List();
				$doctors  = $list->get_data( Installer::get_doctor_table() );
				$patients = $list->get_data( Installer::get_patient_table() );
				$template = $path . 'view/appointment/new.php';
				break;

			default:
				$template = $path . 'view/appointment/list.php';
				break;
		}

		if( file_exists( $template ) ) {
			require_once $template;
		}
	}

	public function admin_patient_page() {
		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$path   = plugin_dir_path( __FILE__ );

		switch ( $action ) {
			case 'new':
				$template     = $path . 'view/patient/new.php';
				break;

			default:
				$template = $path . 'view/patient/list.php';
				break;
		}

		if( file_exists( $template ) ) {
			require_once $template;
		}
	}
}