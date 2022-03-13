<?php
require_once("../../pdo_connect_jj.php");

$id=$_GET["id"];


$sql="SELECT * FROM member WHERE valid=1 AND id=?";
$stmt=$db_host->prepare($sql);
$stmt->execute([$id]);
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlMemLV="SELECT * FROM member_level";
$stmtMemLV=$db_host->prepare($sqlMemLV);
$stmtMemLV->execute();
$rowsMemLV=$stmtMemLV->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once("../../css.php") ?>
    <title>Member Edit</title>
</head>
<body>
<div class="container">
    <div class="container">
        <div class="py-2">
            <div class="d-flex justify-content-between">
                <a href="member.php" class="btn btn-primary">回會員列表</a>
            </div>
        </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form action="member_do_edit.php" method="POST">
                <?php foreach ($rows as $value): ?>
                <div class="mb-2">
                    <label for="id">ID:</label>
                    <input type="text" class="form-control"  name="id" value="<?=$value["id"]?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="">會員名稱</label>
                    <input type="text" class="form-control" name="name" value="<?= $value["name"] ?>">
                </div>
                <div class="mb-2">
                    <label for="gender">性別</label>
                    <select  class="form-select" name="gender"  required>
                        <option
                            <?php if ($value["gender"] == "male") echo "selected" ?>
                                value="男">男
                        </option>
                        <option
                            <?php if ($value["gender"] == "female") echo "selected" ?>
                                value="女">女
                        </option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="age">年齡</label>
                    <input type="text" class="form-control"  name="age" value="<?= $value["age"] ?>" required>
                </div>
                <div class="mb-2">
                    <label for="email">電子信箱</label>
                    <input type="text" class="form-control" name="email" value="<?= $value["email"] ?>" required>
                </div>
                <div class="mb-2">
<!--                    <div class="mb-2">-->
<!--                        <label for="password">密碼</label>-->
<!--                        <input type="text" class="form-control"  name="password" value="--><?//= $value["password"] ?><!--" required>-->
<!--                    </div>-->
                    <div class="mb-2">
                        <label for="spending">消費金額</label>
                        <input type="text" class="form-control"  name="spending" value="<?= $value["spending"] ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="point">點數</label>
                        <input type="text" class="form-control"  name="point" value="<?= $value["point"] ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="level_id">會員等級</label>
                        <select  class="form-select" name="level_id" id="editLevel_id" required>
                            <option value="會員等級"></option>
                            <?php foreach($rowsMemLV as $memberLevel):?>
                                <option value="<?= $memberLevel["id"] ?>" <?php if ($value["level_id"] === $memberLevel["id"]) echo "selected"; ?>><?= $memberLevel["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                     <?php endforeach ?>
                    <button class="btn btn-primary" type="submit">送出</button>
                    <button type="button" class="btn btn-danger">關閉</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
