<?php
require_once("../../pdo_connect_jj.php");
$sqlMem="SELECT * FROM member";
$stmtMem=$db_host->prepare($sqlMem);
$stmtMem->execute();
$rowsMem=$stmtMem->fetchAll(PDO::FETCH_ASSOC);

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
    <?php require_once("../../css.php") ?>
    <title>Member Insert</title>

</head>
<body>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="member_do_insert.php" method="post">
                    <div class="mb-2">
                        <label for="">會員名稱</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-2">
                        <label for="">性別</label>
                        <select class="form-select" name="gender" id="">
                            <option value="male">男</option>
                            <option value="female">女</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="">年齡</label>
                        <input type="number" class="form-control" name="age" min="1" max="200" required>
                    </div>
                    <div class="mb-2">
                        <label for="">電子信箱</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-2">
                        <div class="mb-2">
                            <label for="">密碼</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-2">
                        <label for="">消費金額</label>
                        <input type="number" class="form-control" name="spending"  min="1"required>
                    </div>
                    <div class="mb-2">
                        <label for="">點數</label>
                        <input type="number" class="form-control" name="point" min="1" required>
                    </div>
                    <div class="mb-2">
                        <label for="">會員等級</label>
                        <select class="form-select" name="level_id" id="">
                            <?php foreach($rowsMemLV as $value):?>
                                <option value="<?= $value["id"] ?>>"><?= $value["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">送出</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>