<?php 
  $atts = array_replace(["class" => "", "subject" =>  "", "email" => "", "message" => ""], $args['atts']); 
   $shortcode =  esc_attr($args['shortcode_tag']) 
?> 

<div class="<?php echo esc_attr($atts['class']) ?>" data-shortcode="<?php echo esc_attr($args['shortcode_tag']) ?>">
    <form action="#" method="post">
        <?php wp_nonce_field('submit_contact_form', 'contact_form_nonce'); ?>
        <div class="form-group">
            <input id="<?php echo $shortcode ?>_input" type="text" required value="<?php echo esc_attr($atts['subject']) ?> " />
            <label for="<?php echo $shortcode ?>_input"  class="control-label"><?php esc_html_e("Subject") ?></label>
        </div>
        <div class="form-group">
            <input id="<?php echo $shortcode ?>_email"type="text" required value="<?php echo esc_attr($atts['email']) ?> "/>
            <label for="<?php echo $shortcode ?>_email" class="control-label" ><?php esc_html_e("Email") ?></label>
        </div>
        <div class="form-group">
            <textarea id="<?php echo $shortcode ?>_message"required value="<?php echo esc_attr($atts['message']) ?>"> </textarea>
            <label for="<?php echo $shortcode ?>_message" class="control-label"><?php esc_html_e("Message") ?></label>
        </div>
        <div class="button-container">
            <button class="button"><span>Submit</span></button><?php esc_html_e("Subject") ?>
        </div>

    </form>
</div>