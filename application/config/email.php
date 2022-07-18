<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.viscode.id',
    'smtp_port' => 465,
    'smtp_user' => 'developer@viscode.id',
    'smtp_pass' => 'Viscode0122',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '30', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);

// $config = array(
//     'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
//     'smtp_host' => 'smtp.googlemail.com',
//     'smtp_port' => 587,
//     'smtp_user' => 'oktaariaditya0@gmail.com',
//     'smtp_pass' => '',
//     'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
//     'smtp_timeout' => '30', //in seconds
//     'charset' => 'utf-8',
//     'wordwrap' => TRUE
// );
