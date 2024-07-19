<?php

/**
 * Handles the backend validation of a form
 * 
 * @package mycustomForm
 */

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . "wp-load.php");


/**
 * Holds validation errors.
 *
 * @var WP_Error
 */

$errors = new WP_Error();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = $errors->add(400, "Bad request");
    wp_send_json_error($error);
}

/**
 * Data from the form submission.
 *
 * @var array
 */

 if (!wp_verify_nonce($data['_wpnonce'], 'submit_contact_form')) {
    $errors->add('validation', __('Form is messed up'), "mycustomForm");
}

$data = array_replace(["subject" =>  "", "email" => "", "message" => "", "_wpnonce" => ""], (array) $_POST);

foreach (array_keys($data) as $key) {
    if(empty($_POST[$key]) || !is_string($_POST[$key])) {
        continue;
    }
    
    $data[$key] = trim($_POST[$key]);
}

if (mb_strlen($data['subject']) < 2) {
    $errors->add("validation", __('Subject has to be more then 10 characters', 'mycustomForm')); 
}

if (!is_email($data['email'])) {
    $errors->add("validation", __("Please provide a valid email"), 'mycustomForm');
}

if (mb_strlen($data['message']) < 2) {
    $errors->add('validation', __("message has to be more then 2 characters",'mycustomForm'));
}



if ($errors->has_errors()) {
    wp_send_json_error($errors);
}

ob_start();
load_template(__DIR__ . '/templates/email.php', false, [
    'data' => $data
]);
$template = ob_get_clean();

$headers = array('Content-Type: text/html; charset=UTF-8');
$mail_send = wp_mail(get_option('admin_email'), $data['subject'], $template, $headers, false);
if (!$mail_send) {
    $errors->add('validation', __("Mail cannot be send", "mycustomForm"));
    wp_send_json_error($errors);
}

wp_send_json(['success' => true]);
