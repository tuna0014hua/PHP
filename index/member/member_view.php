<?php
require_once("../../pdo_connect_jj.php");
$id = $_GET["id"];

$sql = "SELECT * FROM member WHERE valid = 1 AND id=?";
$stmt = $db_host->prepare($sql);
$stmt->execute([$id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlMemLV="SELECT * FROM member_level";
$stmtMemLV=$db_host->prepare($sqlMemLV);
$stmtMemLV->execute();
$rowsMemLV=$stmtMemLV->fetchAll(PDO::FETCH_ASSOC);
$memLVArr=[];
foreach($rowsMemLV as $valueMemLV){
    $memLVArr[$valueMemLV["id"]]=$valueMemLV["name"];
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
    <?php require_once("../../css.php") ?>
</head>
<body>
    <div class="container">
        <div class="py-2">
            <div class="d-flex justify-content-between">
                <a href="member.php" class="btn btn-primary">回會員列表</a>
            </div>
        </div>

        <div class="row justify-content-center">

            <div class="col-lg-6">
                <?php foreach ($rows as $value): ?>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th  class="py-2 d-flex">ID</th>
                                <th><div class="col-10">
                                        <?= $value["id"] ?>
                                    </div></th>

                            </tr>
                                <th>會員名稱</th>
                                <th><div class="col-10">
                                        <?= $value["name"] ?>
                                    </div></th>
                            <tr>
                                <th>性別</th>
                                <th><div class="col-10">
                                        <?= $value["gender"] ?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>年齡</th>
                                <th> <div class="col-10">
                                        <?= $value["age"] ?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>電子信箱</th>
                                <th>  <div class="col-10">
                                        <?= $value["email"] ?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>密碼</th>
                                <th> <div class="col-10">
                                        <?= $value["password"] ?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>消費金額</th>
                                <th><div class="col-10">
                                        <?= $value["spending"] ?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>點數</th>
                                <th><div class="col-10">
                                        <?= $value["point"] ?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>會員等級</th>
                                <th>  <div class="col-10">
                                        <?= $memLVArr[$value["level_id"]]?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>建立日期</th>
                                <th><div class="col-10">
                                        <?= $value["created_at"] ?>
                                    </div></th>
                            </tr>
                            <tr>
                                <th>效力</th>
                                <th><div class="col-10">
                                        <?= $value["valid"] ?>
                                    </div></th>
                            </tr>
                            </thead>
                            <tbody>
                    </div>

                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</body>
</html>