<?php 

namespace Enzaime\Appointment\Admin;

use Enzaime\Appointment\Install\Installer;

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Appointment_List extends \WP_List_Table {

	function __construct() {
		parent::__construct( [ 
			'singular' => 'contact',
			'plural'   => 'contacts',
			'ajax'     => false,
		] );
	}

	public function get_columns() {
		return [
			'cb'                => '<input type="checkbox" />',
			'patient_name'      => __( 'Patient Name', 'Enzaime'),
			'name'              => __( 'Doctor Name', 'Enzaime'),
			'fee'               => __( 'Doctor Fee', 'Enzaime'),
			'degree'            => __( 'Doctor Degree', 'Enzaime'),
			'consultation_type' => __( 'Consultation Type', 'Enzaime'),
			'appointment_date'  => __( 'Appointment Date', 'Enzaime'),
			'time_slot'         => __( 'Time Slot', 'Enzaime'),
			'patient_phone'     => __( 'Patient Phone', 'Enzaime'),
			'description'       => __( 'Description', 'Enzaime'),
			'created_at'        => __( 'Created at', 'Enzaime'),
		];
	}

	public function get_sortable_columns() {
		$sortable_columns = [
			'patient_name'      => [ 'patient_name', true ],
			'name'              => [ 'name', true ],
			'fee'               => [ 'fee', true ],
			'degree'            => [ 'degree', true ],
			'consultation_type' => [ 'consultation_type', true ],
			'patient_phone'     => [ 'patient_phone', true ],
			'appointment_date'  => [ 'appointment_date', true ],
			'time_slot'         => [ 'time_slot', true ],
			'description'       => [ 'description', true ],
			'created_at'        => [ 'created_at', true ],
		];

		return $sortable_columns;
	}

	protected function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'value':
				# code...
				break;
			
			default:
				return isset( $item->$column_name ) ? $item->$column_name : ''; 
		}
	}


	// public function column_name( $item ) {
		
	// 	$actions = [];

	// 	$actions['edit'] = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=doctor-menu&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'Enzaime' ) );

	// 	$actions['delete'] = sprintf( 
	// 		'<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure ?\');" title="%s">%s</a>', 
	// 		wp_nonce_url( admin_url( 'admin-post.php?page=doctor-menu&action=user-delete&id=' . $item->id ), 'user-delete' ), $item->id, __( 'Delete', 'Enzaime' ), __( 'Delete', 'Enzaime' ) );

	// 	$path = 'admin.php?page=doctor-menu&action=view&id=' . $item->id;

	// 	return sprintf( 
	// 			'<a href="%1$s"><strong>%2$s</strong></a> %3$s', 
	// 			admin_url( $path ), $item->name, $this->row_actions( $actions )
	// 		);
	// }


	public function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="user_id[]" value="%d">', $item->id );
	}

	public function prepare_items() {
		$column                = $this->get_columns();
		$hidden                = [];
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = [ $column, $hidden, $sortable ];


		$per_page     = 5;
		$current_page = $this->get_pagenum();
		$offset       = ( $current_page - 1 ) * $per_page;

		$args = [
			'number' => $per_page,
			'offset' => $offset,
		];

		if( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['orderby'] ) ) {
			$args['orderby'] = $_REQUEST['orderby'];
			$args['order'] = $_REQUEST['order'];
		}

		$this->items = $this->show_appointment_list( $args );

		$this->set_pagination_args( [
			'total_items' => $this->count_appointment(),
			'per_page'    => $per_page, 
		] );
	}


	public function show_appointment_list( $args = [] ) {
		
		global $wpdb;

		$defaults = [
			'number'  => 20,
			'offset'  => 0,
			'orderby' => 'id',
			'order'   => 'DESC',
		];


		$args = wp_parse_args( $args, $defaults );
		
		$appointment_table = Installer::get_appointment_table();
		$doctor_table      = Installer::get_doctor_table();
		$patient_table     = Installer::get_patient_table();

		$items = $wpdb->get_results( 
			"SELECT appointment.*, doctor.*, patient.* FROM {$appointment_table} AS appointment 

			JOIN {$doctor_table} AS doctor ON doctor.id = appointment.dr_id 
			JOIN {$patient_table} AS patient ON patient.id = appointment.patient_id 

			ORDER BY appointment.id DESC" 
		);

		return $items;
	}


	public function count_appointment() {
		
		global $wpdb;

		$table = Installer::get_appointment_table();

		return (int) $wpdb->get_var( "SELECT count(id) FROM {$table}");
	}

	public function get_data( $table ) {

		global $wpdb;

		$args = [
			'number'  => 50,
			'offset'  => 0,
			'orderby' => 'id',
			'order'   => 'DESC',
		];

		$items = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$table}
				ORDER BY {$args['orderby']} {$args['order']}
				LIMIT %d, %d", $args['offset'], $args['number']
			) );
		return $items;
	}
}