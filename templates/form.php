<?php  $atts = array_replace(["class" => "" , "subject" =>  "", "email" => "" , "message" => ""], $args['atts']); ?>

<div class="<?php echo esc_attr($atts['class']) ?>" data-shortcode="<?php echo esc_attr($args['shortcode_tag']) ?>">
            <form action="#" method="post">
                <?php wp_nonce_field( 'submit_contact_form', 'contact_form_nonce' ); ?>
                <div class="form-group">
                    <input type="text" required value="<?php echo esc_attr($atts['subject']) ?> " />
                    <label for="input" class="control-label">Subject</label>
                </div>
                <div class="form-group">
                    <input type="text" required />
                    <label for="input" class="control-label" value="<?php echo esc_attr($atts['email']) ?> " >Email</label>
                </div>
                <div class="form-group">
                    <textarea required value="<?php echo esc_attr($atts['message']) ?>"> </textarea>
                    <label for="textarea" class="control-label">Message</label>
                </div>
                <div class="button-container">
                    <button class="button"><span>Submit</span></button>
                </div>
 
            </form>
        </div>