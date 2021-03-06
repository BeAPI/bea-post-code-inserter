<?php
/*
 Plugin Name: BEA Post Code Inserter
 Version: 0.1
 Plugin URI: https://github.com/herewithme/bea-post-code-inserter
 Description: Allow to insert HTML code for each post into header, after body and footer
 Author: Amaury Balmer
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Network: false
 Text Domain: bea-post-code-inserter

 TODO:
	* To complete

 ----

 Copyright 2013 Amaury Balmer (amaury@beapi.fr)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

// Plugin constants
define('BEA_PCI_VERSION', '0.1');

// Plugin URL and PATH
define('BEA_PCI_URL', plugin_dir_url ( __FILE__ ));
define('BEA_PCI_DIR', plugin_dir_path( __FILE__ ));

// Function for easy load files
function _bea_pci_load_files($dir, $files, $prefix = '') {
	foreach ($files as $file) {
		if ( is_file($dir . $prefix . $file . ".php") ) {
			require_once($dir . $prefix . $file . ".php");
		}
	}	
}

// Plugin functions
_bea_pci_load_files(BEA_PCI_DIR . 'functions/', array('api', 'template'));

// Plugin client classes
_bea_pci_load_files(BEA_PCI_DIR . 'classes/', array('main', 'plugin', 'widget'));

// Plugin admin classes
if (is_admin()) {
	_bea_pci_load_files(BEA_PCI_DIR . 'classes/admin/', array('main'));
}

// Plugin activate/desactive hooks
register_activation_hook(__FILE__, array('BEA_PCI_Plugin', 'activate'));
register_deactivation_hook(__FILE__, array('BEA_PCI_Plugin', 'deactivate'));

add_action('plugins_loaded', 'init_BEA_PCI_plugin');
function init_BEA_PCI_plugin() {
	// Client
	new BEA_PCI_Main();

	// Admin
	if (is_admin()) {
		new BEA_PCI_Admin_Main();
	}
}