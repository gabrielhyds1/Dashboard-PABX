<?php
require_once("dblib.php");
require_once("misc.php");

// Credentials for MYSQL database
$dbhost = 'localhost';
$dbname = 'qstatslite';
$dbuser = 'qstatsliteuser';
$dbpass = 'qpalzm395Admin';

// Credentials for AMI (for the realtime tab to work)
// See /etc/asterisk/manager.conf

$manager_host   = "127.0.0.1";
$manager_user   = "admin";
$manager_secret = "qpalzm395Admin";

// Available languages "es", "en", "ru", "de", "fr"
$language = "pt_BR";

require_once("lang/$language.php");

$midb = new dbcon($dbhost, $dbuser, $dbpass, $dbname, true);

$self = $_SERVER['PHP_SELF'];

$DB_DEBUG = false; 

session_start();
//session_register("QSTATS");
header('content-type: text/html; charset: utf-8'); 

?>
