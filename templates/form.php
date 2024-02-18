<?php
$atts = array_replace(["class" => "", "subject" =>  "", "email" => "", "message" => ""], $args['atts']);
$shortcode =  esc_attr($args['shortcode_tag']);
wp_enqueue_style( 'get-style' );
?>

<div class="<?= esc_attr($atts['class']) ?>" data-shortcode="<?= esc_attr($args['shortcode_tag']) ?>">
	<form action="#" method="post">
		<?php wp_nonce_field('submit_contact_form', 'contact_form_nonce'); ?>
		<div class="form-group">
			<input id="<?= $shortcode ?>_input" type="text" required value="<?= esc_attr($atts['subject']) ?> " />
			<label for="<?= $shortcode ?>_input" class="control-label"><?php esc_html_e("Subject", "mycustomForm") ?></label>
		</div>
		<div class="form-group">
			<input id="<?= $shortcode ?>_email" type="text" required value="<?= esc_attr($atts['email']) ?> " />
			<label for="<?= $shortcode ?>_email" class="control-label"><?php esc_html_e("Email", "mycustomForm") ?></label>
		</div>
		<div class="form-group">
			<textarea id="<?= $shortcode ?>_message" required value="<?= esc_attr($atts['message']) ?>"> </textarea>
			<label for="<?= $shortcode ?>_message" class="control-label"><?php esc_html_e("Message", "mycustomForm") ?></label>
		</div>
		<div class="button-container">
			<button class="button"><span><?php esc_html_e("Submit", "mycustomForm") ?></span></button>
		</div>

	</form>
</div>