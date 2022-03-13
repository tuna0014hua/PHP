<?php
require_once("../../pdo_connect_jj.php");
$id = $_GET["id"];
$sql = "SELECT * FROM product WHERE valid=1 AND id=? ORDER BY id DESC";
$stmt = $db_host->prepare($sql);
$stmt->execute([$id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlImage = "SELECT * FROM product_image WHERE product_id=? ORDER BY id";
$stmtImage = $db_host->prepare($sqlImage);
$stmtImage->execute([$id]);
$images = $stmtImage->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $rows[0]["name"] ?></title>
    <?php require_once("../css.php") ?>
</head>
<body>
<div class="container">
    <div class="py-2">
        <div class="d-flex justify-content-between">
            <a href="j-product-list.php" class="btn btn-primary">回產品列表</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-3">
                <?php foreach ($rows as $value): ?>
                <div>
                    <img class="img-fluid" src="product_images/<?= $value["image"] ?>" alt="">
                </div>


                <div class="d-flex py-2">
                    <?php foreach ($images as $image): ?>
                        <div class="ratio ratio-1x1 product-picture">
                            <img class="cover-fit" src="product_images/<?= $image["image_name"] ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-2">
                        <b>產品名稱</b>
                    </div>
                    <div class="col-10">
                        <?= $value["name"] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <b>產品價格</b>
                    </div>
                    <div class="col-10">
                        <?= $value["price"] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <b>產品介紹</b>
                    </div>
                    <div class="col-10">
                        <?= $value["content"] ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
