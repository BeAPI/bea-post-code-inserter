<?php
class BEA_PCI_Main {

	public function __construct() {
		add_action('init', array(__CLASS__, 'init'));
		
		add_action('wp_head', array(__CLASS__, 'wp_head'));
		add_action('after_body', array(__CLASS__, 'after_body'));
		add_action('wp_footer', array(__CLASS__, 'wp_footer'));
	}
	
	public static function init() {
		// Load translations
		load_plugin_textdomain('bea-post-code-inserter', false, basename(BEA_PCI_DIR) . '/languages');
	} 
	
	public static function wp_head() {
		if ( is_singular() ) {
			$current_values = get_post_meta( get_queried_object_id(), '_bea_pci_data', true );
			if( $current_values != false && isset($current_values['header']) ) {
				echo $current_values['header'];
			}
		}
	}
	
	public static function after_body() {
		if ( is_singular() ) {
			$current_values = get_post_meta( get_queried_object_id(), '_bea_pci_data', true );
			if( $current_values != false && isset($current_values['body']) ) {
				echo $current_values['body'];
			}
		}
	}
	
	public static function wp_footer() {
		if ( is_singular() ) {
			$current_values = get_post_meta( get_queried_object_id(), '_bea_pci_data', true );
			if( $current_values != false && isset($current_values['footer']) ) {
				echo $current_values['footer'];
			}
		}
	}
}