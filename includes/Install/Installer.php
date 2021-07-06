<?php 

namespace Enzaime\Appointment\Install;

class Installer {

	public static $plugin_prefix     = 'enzaime_';
	public static $doctor_table      = 'doctors';
	public static $patient_table     = 'patients';
	public static $appointment_table = 'appointments';

	public function do_installer() {
		$this->create_doctors_table();
		$this->create_patients_table();
		$this->create_appointments_table();
	}

	private function create_doctors_table() {
		
		global $wpdb;

		$table = self::get_doctor_table();

		$chasrset_collate = $wpdb->get_charset_collate();

		$schema = "CREATE TABLE IF NOT EXISTS `{$table}` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL DEFAULT '',
			`degree` varchar(255) NOT NULL DEFAULT '',
			`fee` varchar(255) NOT NULL DEFAULT '',
			`phone` varchar(255) NOT NULL DEFAULT '',
			`email` varchar(255) NOT NULL DEFAULT '',
			`created_at` datetime NOT NULL,
			`updated_at` datetime NOT NULL,
			PRIMARY KEY (`id`)
		) $chasrset_collate";

		$this->create_schema( $schema );
	}

	public function create_appointments_table() {

		global $wpdb;

		$table = self::get_appointment_table();

		$chasrset_collate = $wpdb->get_charset_collate();

		$schema = "CREATE TABLE IF NOT EXISTS `{$table}` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`dr_id` int(11) NOT NULL,
			`patient_id` int(11) NOT NULL,
			`consultation_type` varchar(255) NOT NULL,
			`appointment_date` varchar(255) NOT NULL,
			`time_slot` varchar(255) NOT NULL,
			`patient_phone` varchar(255) NOT NULL DEFAULT '',
			`description` text NOT NULL DEFAULT '',
			`created_at` datetime NOT NULL,
			`updated_at` datetime NOT NULL,
			PRIMARY KEY (`id`)
		) $chasrset_collate";

		$this->create_schema( $schema );
	}

	public function create_patients_table() {

		global $wpdb;

		$table = self::get_patient_table();

		$chasrset_collate = $wpdb->get_charset_collate();

		$schema = "CREATE TABLE IF NOT EXISTS `{$table}` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`patient_name` varchar(255) NOT NULL,
			`patient_phone` varchar(255) NOT NULL DEFAULT '',
			`patient_email` varchar(255) NOT NULL DEFAULT '',
			`patient_address` text NOT NULL DEFAULT '',
			`created_at` datetime NOT NULL,
			`updated_at` datetime NOT NULL,
			PRIMARY KEY (`id`)
		) $chasrset_collate";

		$this->create_schema( $schema );
	}

	private function create_schema( $schema ) {

		if( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
		}

		dbDelta( $schema );
	}

	public static function get_doctor_table() {

		global $wpdb;

		$table = $wpdb->prefix . self::$plugin_prefix . self::$doctor_table;

		return $table;
	}

	public static function get_appointment_table() {

		global $wpdb;

		$table = $wpdb->prefix . self::$plugin_prefix . self::$appointment_table;

		return $table;
	}

	public static function get_patient_table() {
		
		global $wpdb;

		$table = $wpdb->prefix . self::$plugin_prefix . self::$patient_table;

		return $table;
	}
}