<?php  $atts = array_replace(["subject" =>  "", "email" => "" , "message" => ""], $args['atts']); ?>

<div class="<?php echo $atts['class'] ?>" data-shortcode="<?php echo $args['shortcode_tag'] ?>">
            <form action="#" method="post">
                <h1>Contact Form</h1>
                <?php wp_nonce_field( 'submit_contact_form', 'contact_form_nonce' ); ?>
                <div class="form-group">
                    <input type="text" required />
                    <label for="input" class="control-label">Subject</label>
                </div>
                <div class="form-group">
                    <input type="text" required />
                    <label for="input" class="control-label">Email</label>
                </div>
                <div class="form-group">
                    <textarea required></textarea>
                    <label for="textarea" class="control-label">Message</label>
                </div>
                <div class="button-container">
                    <button class="button"><span>Submit</span></button>
                </div>
 
            </form>
        </div>