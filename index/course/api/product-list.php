<?php
require_once ("../../../pdo_connect_jj.php");
$selCategory=$_POST["selCategory"];

$sql="SELECT * FROM product WHERE category_id=? AND valid=1";
$stmt=$db_host->prepare($sql);
$stmt->execute([$selCategory]);
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);



echo json_encode($rows);

