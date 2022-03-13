<?php
if (!isset($_SESSION["email"])) {
    header("location: /ski_resort/login.php");
    exit;
}
