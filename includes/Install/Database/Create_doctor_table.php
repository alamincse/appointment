<?php 

namespace Enzaime\Appointment\Install\Database;

use Enzaime\Appointment\Install\Plugin_variables;

class Create_doctor_table {
	
	public static $doctor_table = 'doctors';

	public static function table() {
		
		global $wpdb;

		$table = $wpdb->prefix . $plugin_prefix . self::doctor_table();

		$chasrset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
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

		dbDelta( $schema );

		return $table;
	}
}