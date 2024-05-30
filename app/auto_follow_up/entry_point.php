<?php

define("HOMEDIR", '/home/karkushauser/public_html/');
require_once(HOMEDIR."app/inc/func.php");
require_once(HOMEDIR."app/auto_follow_up/inc/db.php");

ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL | E_STRICT);
error_reporting(E_ALL | E_STRICT);


if(isset($_REQUEST) && !empty($_REQUEST)) {
    write_to_log($_POST, 'post hit', false);
}
