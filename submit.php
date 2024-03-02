<?php
/**
 * Handles the backend validation of a form
 * 
 * @package mycustomForm
 */

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . "wp-load.php");

$errors = new WP_Error();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = $errors->add (400, "Bad request") ; 
    wp_send_json_error($error); 
}

/**
 * Data from the form submission.
 *
 * @var array
 */
$data = array_replace(["subject" =>  "", "email" => "", "message" => "", "_wpnonce" => ""], (array) $_POST);


/**
 * Holds validation errors.
 *
 * @var WP_Error
 */


if (mb_strlen($data['subject']) < 2) {
    $errors->add('Error', "subject has to be more then 10 characters");
}

if (!is_email($data['email'])) {
    $errors->add("Error", "Please provide a valid email");
}

if (mb_strlen($data['message']) < 2) {
    $errors->add('Error', "message has to be more then 2 characters");
}

if (!wp_verify_nonce($data['_wpnonce'], 'submit_contact_form')) {
    $errors->add('Error', 'Form is messed up');
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
$mail_send = wp_mail(get_option( 'admin_email' ), $data['subject'],$template, $headers, false); 
if (!$mail_send) {
    $errors->add('Error', "Mail cannot be send"); 
    wp_send_json_error($errors); 
}

wp_send_json(['success' => true]); 
