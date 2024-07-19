<?php
$atts = array_replace(["class" => "", "subject" =>  "", "email" => "", "message" => ""], (array) $args['atts']);

?>

<div class="<?php echo esc_attr($atts['class']) ?>" data-shortcode="<?php echo esc_attr($args['shortcode']) ?>">

	<form method="post" action="<?php echo esc_url(plugin_dir_url(__DIR__) . 'submit.php') ?>">
		<?php wp_nonce_field('submit_contact_form'); ?>

		<div class="user_feedback hidden">

		</div>
		<div class="form-group">
		    <input id="<?php echo  esc_attr($args['prefix'])?>_subject" name="subject" type="text" value="<?php echo esc_attr($atts['subject']) ?>" />
			<label for="<?php echo esc_attr($args['$prefix']) ?>_subject" class="control-label"><?php esc_html_e("Subject", "mycustomForm") ?></label>
		</div>
		<div class="form-group">
			<input id="<?php echo esc_attr($args['prefix']) ?>_email"  name="email" type="text" value="<?php echo esc_attr($atts['email']) ?>" />
			<label for="<?php echo  esc_attr($args['$prefix']) ?>_email" class="control-label"><?php esc_html_e("Email", "mycustomForm") ?></label>
		</div>
		<div class="form-group">
			<textarea id="<?php echo esc_attr($args['$prefix']) ?>_message" name="message"><php echo esc_attr($atts['message']) ?></textarea>
			<label for="<?php echo  esc_attr($args['$prefix']) ?>_message" class="control-label"><?php esc_html_e("Message", "mycustomForm") ?></label>
		</div>
		<div class="button-container">
			<button type="submit" class="button"><span><?php esc_html_e("Submit", "mycustomForm") ?></span></button>
		</div>

	</form>
</div>