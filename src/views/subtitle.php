<p>
	<label for="<?php echo $meta_box_key; ?>[subtitle]"><?php _e( 'Subtitle', 'custom-meta-box-generator' ); ?></label>
	<input class="large-text" type="text" name="<?php echo $meta_box_key; ?>[subtitle]" value="<?php esc_attr_e( $custom_fields['subtitle'] ); ?>">
	<span class="description"><?php _e( 'Enter the subtitle for this piece of content.', 'custom-meta-box-generator' ); ?></span>
</p>
<p>
	<label for="<?php echo $meta_box_key; ?>[show_subtitle]"><?php _e( 'Show Subtitle?', 'custom-meta-box-generator' ); ?></label>
	<input type="checkbox" value="1" name="<?php echo $meta_box_key; ?>[show_subtitle]" <?php checked( $custom_fields['show_subtitle'], 1 ); ?> >
	<span class="description"><?php _e( 'Check if you want to show the subtitle for this article.', 'custom-meta-box-generator' ); ?></span>
</p>
