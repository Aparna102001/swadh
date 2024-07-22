<?php

$connect = new mysqli('localhost', 'root', '', 'swadh');

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

?>
