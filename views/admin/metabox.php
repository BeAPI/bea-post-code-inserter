<p>
	<label for="bea_pci_header"><?php _e('Code for header', 'bea-post-code-inserter'); ?></label>
	<textarea name="bea_pci_data[header]" id="bea_pci_header" cols="50" rows="3" class="widefat"><?php echo esc_textarea($current_values['header']); ?></textarea>
</p>

<p>
	<label for="bea_pci_body"><?php esc_html_e('Code for after <body> tag', 'bea-post-code-inserter'); ?></label>
	<textarea name="bea_pci_data[body]" id="bea_pci_body" cols="50" rows="3" class="widefat"><?php echo esc_textarea($current_values['body']); ?></textarea>
</p>

<p>
	<label for="bea_pci_footer"><?php _e('Code for footer', 'bea-post-code-inserter'); ?></label>
	<textarea name="bea_pci_data[footer]" id="bea_pci_footer" cols="50" rows="3" class="widefat"><?php echo esc_textarea($current_values['footer']); ?></textarea>
</p>