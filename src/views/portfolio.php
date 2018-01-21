<p>
<label for="<?php echo $meta_box_key; ?>[client_name]"><?php _e( 'Client', 'custom-meta-box-generator' ); ?></label>
<input class="large-text" type="text" name="<?php echo $meta_box_key; ?>[client_name]" value="<?php esc_attr_e( $custom_fields['client_name'] ); ?>">
<span class="description"><?php _e( 'Enter the client\'s name', 'custom-meta-box-generator' ); ?></span>
</p>

<p>
<label for="<?php echo $meta_box_key; ?>[client_url]"><?php _e( 'URL', 'custom-meta-box-generator' ); ?></label>
<input class="large-text" type="url" name="<?php echo $meta_box_key; ?>[client_url]" value="<?php echo esc_url( $custom_fields['client_url'] ); ?>">
<span class="description"><?php _e( 'Enter the client\'s URL', 'custom-meta-box-generator' ); ?></span>
</p>
