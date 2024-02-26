<?php
$atts = array_replace(["class" => "", "subject" =>  "", "email" => "", "message" => ""], $args['atts']);
$prefix =  esc_attr($args['prefix']);
$shortcode = esc_attr($args['shortcode'])
?>

<div class="<?= esc_attr($atts['class']) ?>" data-shortcode="<?= esc_attr($args['shortcode']) ?>">
   
	<form method="post" action="<?php echo plugin_dir_url(__DIR__) . 'submit.php' ?>">
	<?php wp_nonce_field('submit_contact_form'); ?>
	<div class="user_feedback">

       </div>
		<div class="form-group">
			<input id="<?= $prefix ?>_subject" name="subject" type="text" required value="<?= esc_attr($atts['subject']) ?>" />
			<label for="<?= $prefix ?>_subject" class="control-label"><?php esc_html_e("Subject", "mycustomForm") ?></label>
		</div>
		<div class="form-group">
			<input id="<?= $prefix ?>_email" name="email" type="text" required value="<?= esc_attr($atts['email']) ?>" />
			<label for="<?= $prefix ?>_email" class="control-label"><?php esc_html_e("Email", "mycustomForm") ?></label>
		</div>
		<div class="form-group">
			<textarea id="<?= $prefix ?>_message" name ="message" required value="<?= esc_attr($atts['message']) ?>"> </textarea>
			<label for="<?= $prefix ?>_message" class="control-label"><?php esc_html_e("Message", "mycustomForm") ?></label>
		</div>
		<div class="button-container">
			<button type="submit" class="button"><span><?php esc_html_e("Submit", "mycustomForm") ?></span></button>
		</div>

	</form>
</div>