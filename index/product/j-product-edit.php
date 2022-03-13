<?php
require_once("../../pdo_connect_jj.php");
$id=$_GET["id"];

$sql="SELECT * FROM product WHERE valid=1 AND id=? ORDER BY id DESC";
$stmt = $db_host->prepare($sql);
$stmt->execute([$id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlCate= "SELECT * FROM category_product ";
$stmtCate = $db_host->prepare($sqlCate);
$stmtCate->execute();
$categories = $stmtCate->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>j-product-edit</title>
    <?php require_once ("../css.php")?>
</head>
<body>
<div class="container">
    <div class="py-2">
        <div class="d-flex justify-content-between">
            <a href="j-product-list.php" class="btn btn-primary">回列表</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="j-updateProduct.php" method="post">
                    <?php foreach ($rows as $value) : ?>
                        <input type="hidden" name="id" value="<?=$value["id"]?>">
                        <div class="mb-2">
                            <img class="img-fluid" src="product_images/<?= $value["image"] ?>" alt="">
                        </div>
                        <div class="mb-2">
                            <label for="">分類</label>
                            <select class="form-select" name="category_id" id="">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?=$category["id"]?>"
                                        <?php
                                        if($category["id"] == $value["category_id"]) echo "selected";
                                        ?>
                                    >
                                        <?=$category["name"]?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="">產品名稱</label>
                            <input type="text" class="form-control" name="name" value="<?=$value["name"]?>" >
                        </div>
                        <div class="mb-2">
                            <label for="">數量</label>
                            <input type="text" class="form-control" name="amount" value="<?=$value["amount"]?>" >
                        </div>
                        <div class="mb-2">
                            <label for="">價錢</label>
                            <input type="text" class="form-control" name="price" value="<?=$value["price"]?>" >
                        </div>
                        <div class="mb-2">
                            <label for="">介紹</label>
                            <textarea rows="5" class="form-control" name="content"><?=$value["content"]?> </textarea>
                        </div>
                    <?php endforeach;?>
                    <button class="btn btn-primary" type="submit">送出</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
