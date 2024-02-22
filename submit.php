<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . "wp-load.php");

$data = array_replace(["subject" =>  "", "email" => "", "message" => "", "nonce" => ""], $_POST);

$errors = new WP_Error();

if (mb_strlen($data['subject']) < 2) {
    $errors->add('Error', "subject has to be more then 2 characters");
}

if (!is_email($data['email'])) {
    $errors->add("Error", "Please provide a valid email");
}

if (mb_strlen($data['message']) < 2) {
    $errors->add('Error', "message has to be more then 2 characters");
}

if (!wp_verify_nonce($data['nonce'], 'submit_contact_form')) {
    $errors->add('Error', 'Form is messed up');
}

if ($errors->has_errors()) {
    wp_send_json_error($errors);
}

