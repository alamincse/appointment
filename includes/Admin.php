<?php 

namespace Enzaime\Appointment;

use Enzaime\Appointment\Admin\Doctor_List;
use Enzaime\Appointment\Admin\Appointment_List;
use Enzaime\Appointment\Install\Installer;

class Admin {
	function __construct() {
		
		new Admin\Menu();
		
		add_action( 'admin_init', [ $this, 'save_doctor' ] );

		add_action( 'admin_init', [ $this, 'update_doctor' ] );

		add_action( 'admin_init', [ $this, 'save_appointment' ] );

		add_action( 'admin_init', [ $this, 'save_patient' ] );

		// admin_post_action-name
		add_action( 'admin_post_doctor-delete', [ $this, 'delete_register_doctor' ] );
	}

	public function save_doctor() {
		if( ! isset( $_POST['submit_doctor'] ) ) {
			return;
		}

		if( isset($_POST['_wpnonce']) &&  ! wp_verify_nonce($_POST['_wpnonce'], 'new-doctor') ) {
			wp_die( 'Oops, Something is wrong');
		}

		$name   = isset( $_POST['dr_name'] ) ? sanitize_text_field( $_POST['dr_name'] ) : '';
		$degree = isset( $_POST['dr_degree'] ) ? sanitize_text_field( $_POST['dr_degree'] ) : '';
		$email  = isset( $_POST['dr_email'] ) ? sanitize_text_field( $_POST['dr_email'] ) : '';
		$phone  = isset( $_POST['dr_phone'] ) ? sanitize_text_field( $_POST['dr_phone'] ) : '';
		$fee    = isset( $_POST['dr_fee'] ) ? sanitize_text_field( $_POST['dr_fee'] ) : '';

		if( empty( $name ) ) {
			$this->errors['name'] = __( 'Name field is empty.', 'Enzaime' );
		}

		if( empty( $degree ) ) {
			$this->errors['degree'] = __( 'Degree field is empty.', 'Enzaime' );
		}

		if( empty( $email ) ) {
			$this->errors['email'] = __( 'Email field is empty.', 'Enzaime' );
		}

		if( empty( $phone ) ) {
			$this->errors['phone'] = __( 'Phone field is empty.', 'Enzaime' );
		}

		if( empty( $fee ) ) {
			$this->errors['fee'] = __( 'Dr. Fee field is empty.', 'Enzaime' );
		}

		// If error is not empty.
		if( ! empty( $this->errors ) ) {
			return;
		}

		$data = [
			'name'       => $name,
			'degree'     => $degree,
			'email'      => $email,
			'phone'      => $phone,
			'fee'        => $fee,
			'created_at' => current_time( 'mysql' ),
		];

		$insert_id = $this->insert_doctor( $data );

		if( is_wp_error( $insert_id ) ) {
			wp_die( $insert_id->get_error_message() );
		} else {
			$redirect_to = admin_url( 'admin.php?page=doctor-menu&doctor-inserted=true' );

			wp_redirect( $redirect_to );
		}
	}

	public function insert_doctor( $data ) {
		
		global $wpdb;

		$table = Installer::get_doctor_table();

		$inserted = $wpdb->insert( "{$table}", $data, [
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		] );

		if( ! $inserted ) {
			return new \WP_Error( 'failed-to-insert', __( 'Data not inserted', 'Enzaime' ) );
		} 

		return $wpdb->insert_id;
	}

	public function update_doctor() {
		
		global $wpdb;
		
		if( ! isset( $_POST['update_doctor'] ) ) {
			return;
		}

		if( isset($_POST['_wpnonce']) &&  ! wp_verify_nonce($_POST['_wpnonce'], 'update-doctor') ) {
			wp_die( 'Oops, Something is wrongssss');
		}

		$name   = isset( $_POST['dr_name'] ) ? sanitize_text_field( $_POST['dr_name'] ) : '';
		$degree = isset( $_POST['dr_degree'] ) ? sanitize_text_field( $_POST['dr_degree'] ) : '';
		$email  = isset( $_POST['dr_email'] ) ? sanitize_text_field( $_POST['dr_email'] ) : '';
		$phone  = isset( $_POST['dr_phone'] ) ? sanitize_text_field( $_POST['dr_phone'] ) : '';
		$fee    = isset( $_POST['dr_fee'] ) ? sanitize_text_field( $_POST['dr_fee'] ) : '';

		if( empty( $name ) ) {
			$this->errors['name'] = __( 'Name field is empty.', 'Enzaime' );
		}

		if( empty( $degree ) ) {
			$this->errors['degree'] = __( 'Degree field is empty.', 'Enzaime' );
		}

		if( empty( $email ) ) {
			$this->errors['email'] = __( 'Email field is empty.', 'Enzaime' );
		}

		if( empty( $phone ) ) {
			$this->errors['phone'] = __( 'Phone field is empty.', 'Enzaime' );
		}

		if( empty( $fee ) ) {
			$this->errors['fee'] = __( 'Dr. Fee field is empty.', 'Enzaime' );
		}

		// If error is not empty.
		if( ! empty( $this->errors ) ) {
			return;
		}

		$data = [
			'name'       => $name,
			'degree'     => $degree,
			'email'      => $email,
			'phone'      => $phone,
			'fee'        => $fee,
			'updated_at' => current_time( 'mysql' ),
		];

		$id = $_POST['id'];

		$table = Installer::get_doctor_table();

		$updated = $wpdb->update(
			"{$table}",
			$data, 
			[ 'id' => $id ],
			[
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			],
			[ '%d' ]
		);

		if( $updated ) {
			wp_redirect( admin_url( 'admin.php?page=doctor-menu&doctor-update=true') );
		}
	}

	public function delete_register_doctor() {

		global $wpdb;
		
		if( isset($_REQUEST['_wpnonce']) && ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'doctor-delete' ) ) {
			wp_die( 'Oops, somethig is wrong.' );
		}

		if( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Oops, Something is wrong');
		}

		$id  = isset( $_REQUEST['id']) ? intval( $_REQUEST['id'] ) : 0;

		$doctor_list = new Doctor_List();

		$deleted = $doctor_list->delete_doctor( $id );

		if( $deleted ) {
			$redirect_to = admin_url( 'admin.php?page=doctor-menu&doctor-delete=true' );
		} else {
			$redirect_to = admin_url( 'admin.php?page=doctor-menu&doctor-delete=false' );
		}

		wp_redirect( $redirect_to );
	}


	public function save_appointment() {
		if( ! isset( $_POST['submit_appointment'] ) ) {
			return;
		}

		if( isset($_POST['_wpnonce']) &&  ! wp_verify_nonce($_POST['_wpnonce'], 'new-appointment') ) {
			wp_die( 'Oops, Something is wrong');
		}

		$patient_name = isset( $_POST['patient_name'] ) ? sanitize_text_field( $_POST['patient_name'] ) : '';
		$dr_name = isset( $_POST['dr_name'] ) ? sanitize_text_field( $_POST['dr_name'] ) : '';
		$type    = isset( $_POST['cons_type'] ) ? sanitize_text_field( $_POST['cons_type'] ) : '';
		$date    = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
		$time    = isset( $_POST['time'] ) ? sanitize_text_field( $_POST['time'] ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
		$desc    = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';

		if( empty( $dr_name ) ) {
			$this->errors['dr_name'] = __( 'Dr. Name field is empty.', 'Enzaime' );
		}

		if( empty( $patient_name ) ) {
			$this->errors['patient_name'] = __( 'Patient Name field is empty.', 'Enzaime' );
		}
		
		if( empty( $type ) ) {
			$this->errors['type'] = __( 'Consultation type field is empty.', 'Enzaime' );
		}

		if( empty( $date ) ) {
			$this->errors['date'] = __( 'Date field is empty.', 'Enzaime' );
		}

		if( empty( $time ) ) {
			$this->errors['time'] = __( 'Time field is empty.', 'Enzaime' );
		}

		if( empty( $phone ) ) {
			$this->errors['phone'] = __( 'Phone field is empty.', 'Enzaime' );
		}

		if( empty( $desc ) ) {
			$this->errors['desc'] = __( 'Description field is empty.', 'Enzaime' );
		}

		// If error is not empty.
		if( ! empty( $this->errors ) ) {
			return;
		}

		$data = [
			'dr_id'             => $dr_name,
			'patient_id'        => $patient_name,
			'consultation_type' => $type,
			'appointment_date'  => $date,
			'time_slot'         => $time,
			'patient_phone'     => $phone,
			'description'       => $desc,
			'created_at'        => current_time( 'mysql' ),
		];

		$insert_id = $this->insert_appointment( $data );

		if( is_wp_error( $insert_id ) ) {
			wp_die( $insert_id->get_error_message() );
		} else {
			$redirect_to = admin_url( 'admin.php?page=appointment-menu&appointment-inserted=true' );

			wp_redirect( $redirect_to );
		}
	}


	public function insert_appointment( $data ) {
		
		global $wpdb;

		$table = Installer::get_appointment_table();

		$inserted = $wpdb->insert( "{$table}", $data, [
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		] );

		if( ! $inserted ) {
			return new \WP_Error( 'failed-to-insert', __( 'Data not inserted', 'Enzaime' ) );
		} 

		return $wpdb->insert_id;
	}

	public function save_patient() {
		if( ! isset( $_POST['submit_patient'] ) ) {
			return;
		}

		if( isset($_POST['_wpnonce']) &&  ! wp_verify_nonce($_POST['_wpnonce'], 'new-patient') ) {
			wp_die( 'Oops, Something is wrong');
		}

		$name    = isset( $_POST['patient_name'] ) ? sanitize_text_field( $_POST['patient_name'] ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
		$email   = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
		$address = isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'] ) : '';

		$data = [
			'patient_name'    => $name,
			'patient_phone'   => $phone,
			'patient_email'   => $email,
			'patient_address' => $address,
			'created_at'      => current_time( 'mysql' ),
		];

		$insert_id = $this->insert_patient( $data );

		if( is_wp_error( $insert_id ) ) {
			wp_die( $insert_id->get_error_message() );
		} else {
			$redirect_to = admin_url( 'admin.php?page=patient-menu&patient-inserted=true' );

			wp_redirect( $redirect_to );
		}
	}

	public function insert_patient( $data ) {
		global $wpdb;

		$table = Installer::get_patient_table();

		$inserted = $wpdb->insert( "{$table}", $data, [
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		] );

		if( ! $inserted ) {
			return new \WP_Error( 'failed-to-insert', __( 'Data not inserted', 'Enzaime' ) );
		} 

		return $wpdb->insert_id;
	}
}