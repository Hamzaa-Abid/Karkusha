<?php

$db = new mysqli('localhost', 'moilogoped_notifications', 'GI*1{UeO4QL_', 'moilogoped_notifications');
if ($db->connect_errno) {
    throw new RuntimeException('mysqli connection error: ' . $db->connect_error);
}