<?php



$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . "wp-load.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = new WP_Error(400, "Bad request") ; 
    wp_send_json_error($error); 
}

$data = array_replace(["subject" =>  "", "email" => "", "message" => "", "_wpnonce" => ""], (array) $_POST);

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

if (!wp_verify_nonce($data['_wpnonce'], 'submit_contact_form')) {
    $errors->add('Error', 'Form is messed up');
}

if ($errors->has_errors()) {
    wp_send_json_error($errors);
}

$headers = array('Content-Type: text/html; charset=UTF-8');
$mail_send = wp_mail(get_option( 'admin_email' ), $data['email'],load_template(__DIR__ . '/templates/email.php', false, [
    'data' => $data
 ]), $headers);


if (!$mail_send) {
    wp_send_json(["Error", "Mail cannot be send"]); 
}

