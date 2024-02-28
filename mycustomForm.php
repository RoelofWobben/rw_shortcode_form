<?php
/**
 * File handling form submission and email sending.
 * 
 * @package mycustomForm
 */

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . "wp-load.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = new WP_Error(400, "Bad request") ; 
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
$errors = new WP_Error();

if (mb_strlen($data['subject']) < 2) {
    $errors->add('Error', "subject has to be more than 2 characters");
}

if (!is_email($data['email'])) {
    $errors->add("Error", "Please provide a valid email");
}

if (mb_strlen($data['message']) < 2) {
    $errors->add('Error', "message has to be more than 2 characters");
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
    wp_send_json(new WP_Error("Error", "Mail cannot be sent")); 
}

wp_send_json(['success' => true]); 
