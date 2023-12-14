<?php
require_once("/home/rcasanova2/data/connect.php");
require_once("../private/prepared.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete_id = $_POST['delete_id'];


    delete_keyboard($delete_id);

    // Redirect back to the index page
    header("Location: index.php");
    exit;
}
?>