<?php 

namespace Enzaime\Appointment\Install;

class Plugin_variables {

	$plugin_prefixs = 'enzaime_';
	
	public function __construct( $plugin_prefixs ) {
		$plugin_prefixs = $this->plugin_prefixs;
	}
}