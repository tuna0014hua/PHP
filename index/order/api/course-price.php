<?php
require_once ("../../../pdo_connect_jj.php");
$selectCourse=$_POST["selectCourse"];

$sql="SELECT * FROM course WHERE id=? AND valid=1";
$stmt=$db_host->prepare($sql);
$stmt->execute([$selectCourse]);
$row=$stmt->fetch();



echo json_encode($row);
