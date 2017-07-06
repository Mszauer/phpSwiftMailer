<?php
/*
 *$load needs to be a relative path to an autoloader script.
 *swift mailers autoload is swift_required.php in the lib directory
 *if you used composer to install swift mailer use vendor/autoload.php
 */

$loader = __DIR__ . '/../swiftmailer/lib/swift_required.php';

require_once $loader;

/*
 *Login details for mail server
 */
$smtp_server = '';
$username = '';
$password = '';

/*
 *email addresses for testing
 *the first two are associative arrays in the format ['email_address' => 'name']. The rest contain just an email address as a string
 */
$from = [];
$test1 = [];
$testing = '';
$test2 = [];
$test3 = '';
$secret = '';
$private = '';