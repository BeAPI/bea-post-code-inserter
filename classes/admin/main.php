<?php
class BEA_PCI_Admin_Main {

	/**
	 * Constructor, register hooks !
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post', array( __CLASS__, 'save_post' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public static function add_meta_boxes( $post_type ) {
		add_meta_box(
			'bea_pci_custom_box'
			, __( 'BEA Post Code Inserter', 'bea-post-code-inserter' )
			, array( __CLASS__, 'render_meta_box_content' )
			, $post_type
			, 'advanced'
			, 'high'
		);
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param boolean
	 */
	public static function save_post( $post_id ) {
		// Check if our nonce is set.
		if ( !isset( $_POST['bea_pci_custom_box_nonce'] ) ) {
			return false;
		}

		// Verify that the nonce is valid.
		if ( !wp_verify_nonce( $_POST['bea_pci_custom_box_nonce'], 'bea_pci_custom_box' ) ) {
			return false;
		}

		// If this is an autosave, our form has not been submitted,
		//     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		/* OK, its safe for us to save the data now. */
		if ( !isset( $_POST['bea_pci_data'] ) ) {
			delete_post_meta( $post_id, '_bea_pci_data' );
		} else {
			if ( empty( $_POST['bea_pci_data']['header'] ) && empty( $_POST['bea_pci_data']['body'] ) && empty( $_POST['bea_pci_data']['footer'] ) ) {
				delete_post_meta( $post_id, '_bea_pci_data' );
			} else {
				// Sanitize the user textarea, keep all code HTML,.
				$_POST['bea_pci_data'] = stripslashes_deep( $_POST['bea_pci_data'] );

				// Update the meta field.
				update_post_meta( $post_id, '_bea_pci_data', $_POST['bea_pci_data'] );
			}
		}

		return true;
	}

	/**
	 * Render Meta Box content.ce	
 *
	 * @param WP_Post $post The post object.
	 */
	public static function render_meta_box_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'bea_pci_custom_box', 'bea_pci_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$current_values = get_post_meta( $post->ID, '_bea_pci_data', true );

		// Parse vs default
		$current_values = wp_parse_args( $current_values, array( 'header' => '', 'body' => '', 'footer' => '' ) );

		// Display the form, using the current value.
		include( BEA_PCI_DIR . '/views/admin/metabox.php' );
	}

}
