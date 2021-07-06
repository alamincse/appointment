<?php 

namespace Enzaime\Appointment\Admin;

use Enzaime\Appointment\Install\Installer;

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Doctor_List extends \WP_List_Table {

	function __construct() {
		parent::__construct( [ 
			'singular' => 'contact',
			'plural'   => 'contacts',
			'ajax'     => false,
		] );
	}

	public function get_columns() {
		return [
			'cb'         => '<input type="checkbox" />',
			'name'       => __( 'Name', 'Enzaime'),
			'degree'     => __( 'Degree', 'Enzaime'),
			'phone'      => __( 'Phone', 'Enzaime'),
			'email'      => __( 'Email', 'Enzaime'),
			'fee'        => __( 'Fee', 'Enzaime'),
			'created_at' => __( 'Created at', 'Enzaime'),
		];
	}

	public function get_sortable_columns() {
		$sortable_columns = [
			'name'       => [ 'name', true ],
			'degree'     => [ 'email', true ],
			'phone'      => [ 'phone', true ],
			'email'      => [ 'phone', true ],
			'fee'        => [ 'fee', true ],
			'created_at' => [ 'created_at', true ],
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


	public function column_name( $item ) {
		
		$actions = [];

		$actions['edit'] = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=doctor-menu&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'Enzaime' ) );

		$actions['delete'] = sprintf( 
			'<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure ?\');" title="%s">%s</a>', 
			wp_nonce_url( admin_url( 'admin-post.php?page=doctor-menu&action=doctor-delete&id=' . $item->id ), 'doctor-delete' ), $item->id, __( 'Delete', 'Enzaime' ), __( 'Delete', 'Enzaime' ) );

		$path = 'admin.php?page=doctor-menu&action=view&id=' . $item->id;

		return sprintf( 
				'<a href="%1$s"><strong>%2$s</strong></a> %3$s', 
				admin_url( $path ), $item->name, $this->row_actions( $actions )
			);
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
			$args['order'] = $_REQUEST['order'];
		}

		$this->items = $this->show_doctor_list( $args );

		$this->set_pagination_args( [
			'total_items' => $this->count_doctor(),
			'per_page'    => $per_page, 
		] );
	}


	public function show_doctor_list( $args = [] ) {
		
		global $wpdb;

		$defaults = [
			'number'  => 5,
			'offset'  => 0,
			'orderby' => 'id',
			'order'   => 'DESC',
		];


		$args = wp_parse_args( $args, $defaults );

		$table = Installer::get_doctor_table();

		$items = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$table}
				ORDER BY {$args['orderby']} {$args['order']}
				LIMIT %d, %d", $args['offset'], $args['number']
			) );
		return $items;
	}


	public function count_doctor() {
		
		global $wpdb;

		$table = Installer::get_doctor_table();

		return (int) $wpdb->get_var( "SELECT count(id) FROM {$table}");
	}


	public function get_doctor( $id ) {
		
		global $wpdb;

		$table = Installer::get_doctor_table();

		return $wpdb->get_row( 
			$wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) 
		);
	}


	public function delete_doctor( $id ) {

		global $wpdb;

		$table = Installer::get_doctor_table();

		return $wpdb->delete(
			"{$table}", 
			[ 'id' => $id ],
			[ '%d' ]
		);
	}
}