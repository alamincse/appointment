<?php 

namespace Enzaime\Appointment\Admin;

use Enzaime\Appointment\Install\Installer;

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Patient_List extends \WP_List_Table {

	function __construct() {
		parent::__construct( [ 
			'singular' => 'contact',
			'plural'   => 'contacts',
			'ajax'     => false,
		] );
	}

	public function get_columns() {
		return [
			'cb'              => '<input type="checkbox" />',
			'patient_name'    => __( 'Name', 'Enzaime'),
			'patient_phone'   => __( 'Phone', 'Enzaime'),
			'patient_email'   => __( 'Email', 'Enzaime'),
			'patient_address' => __( 'Address', 'Enzaime'),
			'created_at'      => __( 'Created at', 'Enzaime'),
		];
	}

	public function get_sortable_columns() {
		$sortable_columns = [
			'patient_name'  => [ 'patient_name', true ],
			'patient_phone' => [ 'patient_phone', true ],
			'patient_email' => [ 'patient_email', true ],
			'created_at'    => [ 'created_at', true ],
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
			$args['order']   = $_REQUEST['order'];
		}

		$this->items = $this->show_patient_list( $args );

		$this->set_pagination_args( [
			'total_items' => $this->count_patient(),
			'per_page'    => $per_page, 
		] );
	}


	public function show_patient_list( $args = [] ) {
		
		global $wpdb;

		$defaults = [
			'number'  => 5,
			'offset'  => 0,
			'orderby' => 'id',
			'order'   => 'DESC',
		];


		$args = wp_parse_args( $args, $defaults );

		$table = Installer::get_patient_table();

		$items = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$table}
				ORDER BY {$args['orderby']} {$args['order']}
				LIMIT %d, %d", $args['offset'], $args['number']
			) );
		return $items;
	}


	public function count_patient() {
		
		global $wpdb;

		$table = Installer::get_patient_table();

		return (int) $wpdb->get_var( "SELECT count(id) FROM {$table}");
	}
}