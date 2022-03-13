<?php
require_once ("pdo_connect_jj.php");
//if (isset($_SESSION["user"])){
//    session_destroy();
//}
session_destroy();
header("location:login.php");