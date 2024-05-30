<?php

# DEBUG change following was added to non-working commit
// ini_set('display_errors', '1');
// ini_set('error_reporting', E_ALL | E_STRICT);
// error_reporting(E_ALL | E_STRICT);
# DEBUG


/**
 * Requires the "PHP Email Form" library
 * The "PHP Email Form" library is available only in the pro version of the template
 * The library should be uploaded to: vendor/php-email-form/php-email-form.php
 * For more info and help: https://bootstrapmade.com/php-email-form/
 */

require_once('../app/inc/func.php');

// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'ildarius@gmail.com';

if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
  include( $php_email_form );
} else {
  die( 'Unable to load the "PHP Email Form" Library!');
}

// What form are we dealing with?
if(isset($_POST['form_type']) && !empty($_POST['form_type'])) {
    $form_type = $_POST['form_type'];
}

$contact = new PHP_Email_Form;

$contact->to = $receiving_email_address;
$contact->from_name  = $_POST['name'];
$contact->from_email = $_POST['email'];

//////////////
// SPAM CHECK
// https://docs.google.com/document/d/1h2hNPAn2BCu1RxGslYECPHmEsw_IgMxcrFgVWUTgThk
 if(isset($_POST['leadsLastName']) && !empty($_POST['leadsLastName'])) {
   header('Location: https://karkusha.org/thank_you.php');
   exit;
 }
// Fetch the recaptcha score. Shows how likely it is that the lead is spam
if(isset($_POST['token']) && !empty($_POST['token'])) {
    $captcha_score = get_captcha_score($_POST['token']);
}

// Main form (main contact form on the web-site)
if($form_type == 'main_form') {
    $contact->subject = 'Karkusha Lead From Site';
    $contact->add_message( $_POST['name'], 'From');
    $contact->add_message( $_POST['email'], 'Email');
    $contact->add_message( $_POST['phone'], 'Phone');
    $contact->add_message( $_POST['message'], 'Message', 10);
    $contact->add_message( $captcha_score, 'Captcha', 10);
}


// Newsletter form (Newsletter form. For when we get an email and send the checklist in exchange)
if($form_type == 'newsletter') {
    $contact->subject = 'Karkusha Newsletter signup from Site';
    $contact->add_message( $_POST['email'], 'Email');
    $contact->add_message( $captcha_score, 'Captcha', 10);
}

write_to_log([
    'Type'    => $form_type,
    'From'    => (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : 'NA',
    'Email'   => (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : 'NA',
    'Phone'   => (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : 'NA',
    'Message' => (isset($_POST['message']) && !empty($_POST['message'])) ? $_POST['message'] : 'NA',
    'Captcha_score' => $captcha_score
], 'New lead from site', $email = false);

$contact->send2($form_type);

?>
