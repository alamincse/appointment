<?php 
/**
 * Plugin Name:       Enzaime Appointment
 * Plugin URI:        http://example.com
 * Description:       A WordPress plugin
 * Version:           0.1
 * Author:            Al-Amin Sarker
 * Author URI:        http://alamin.test
 */

// don't call the file directly
if( ! defined( 'ABSPATH' ) ) exit;

use Enzaime\Appointment\Install\Defined;

final class Appointment
{
	const version = "0.1";

	private static $instance;

	private function __construct() {
		require_once __DIR__ . '/vendor/autoload.php';
		
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		// register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

		$installer = new Enzaime\Appointment\Install\Installer;
		$installer->do_installer();

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	public static function init() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		} 

		return self::$instance; 
	}


	public function init_plugin() {
		if( is_admin() ) {
			new Enzaime\Appointment\Admin();
		}
	}

	public function define_constants() {
		define( 'WD_APPOINTMENT_VERSION', self::version );
		define( 'WD_APPOINTMENT_FILE', __FILE__ );
		define( 'WD_APPOINTMENT_PATH', __DIR__ );
		define( 'WD_APPOINTMENT_URL', plugins_url( '', 'WD_APPOINTMENT_FILE' ) );
		define( 'WD_APPOINTMENT_ASSETS', WD_APPOINTMENT_URL . '/assets' );
	}

	public function activate() {
		$installed = get_option( 'wd_appointment_installed' );

		// store installation time
		if( ! $installed ) {
			update_option( 'wd_appointment_installed', time() );
		}

		// store plugin version
		update_option( 'wd_appointment_version', WD_APPOINTMENT_VERSION );
	}
}

/**
 * Initialize the main plugin
 * @return \Appointment
 */
function appointment() {
	return Appointment::init();
}

appointment();