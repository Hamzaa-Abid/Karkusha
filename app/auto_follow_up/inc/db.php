<?php

$db = new mysqli('23.111.151.230', 'karkushauser_karkushauser', 'j*n{^pA)P)uG', 'karkushauser_main');
if ($db->connect_errno) {
    throw new RuntimeException('mysqli connection error: ' . $db->connect_error);
}