<?php
require_once("../../pdo_connect_jj.php");

$id = $_GET["id"];
$sql = "SELECT * FROM ordered WHERE id=?";
$stmt = $db_host->prepare($sql);
$stmt->execute([$id]);
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($row);

$sqlM = "SELECT * FROM member";
$stmtM = $db_host->prepare($sqlM);
$stmtM->execute();
$rowM = $stmtM->fetchAll(PDO::FETCH_ASSOC);
$memberArr = [];
foreach ($rowM as $valueM) {
    $memberArr[$valueM["id"]] = $valueM["name"];
}

$sqlC = "SELECT * FROM course ";
$stmtC = $db_host->prepare($sqlC);
$stmtC->execute();
$rowC = $stmtC->fetchAll(PDO::FETCH_ASSOC);
$courseArr = [];
foreach ($rowC as $valueC) {
    $courseArr[$valueC["id"]] = $valueC["name"];
}

$sqlP = "SELECT * FROM product ";
$stmtP = $db_host->prepare($sqlP);
$stmtP->execute();
$rowP = $stmtP->fetchAll(PDO::FETCH_ASSOC);
$productArr = [];
foreach ($rowP as $valueP) {
    $productArr[$valueP["id"]] = $valueP["name"];
}
//print_r($productArr);

$sqlOP = "SELECT * FROM order_product WHERE id=?";
$stmtOP = $db_host->prepare($sqlOP);
$stmtOP->execute([$id]);
$rowOP = $stmtOP->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order View</title>
    <?php require_once("../../css.php") ?>
    <style>
        .table-bordered {
            border: 3px solid navy;
        }

        table {
            width: 100%;
        }
    </style>
</head>
<body>
<?php require_once("../../main.php") ?>
<div class="container">
    <div class="py-2">
        <div class="mt-5">
            <a href="order.php" class="btn btn-primary">回訂單列表</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 d-flex justify-content-center">
                <h3>以下為您的訂購資訊</h3>
            </div>
            <div class="col-lg-6 mb-3 p-3">
                <?php foreach ($row as $value): ?>
                    <table class="table table-bordered">
                        <tbody class="">
                        <tr class="text-center">
                            <td class="col-4">訂單編號:</td>
                            <td class="col-8"><?= $value["id"] ?></td>
                        </tr>
                        <tr class="text-center">
                            <td class="col-4">購買人:</td>
                            <td class="col-8"><?= $memberArr[$value["member_id"]] ?></td>
                        </tr>
                        <tr class="text-center">
                            <td class="col-4">購買課程:</td>
                            <td class="col-8">
                                <?php
                                if ($value["course_id"] == 0) {
                                    echo "未購買課程";
                                } else {
                                    echo $courseArr[$value["course_id"]];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <?php foreach ($rowOP

                            as $valueOP): ?>
                            <td class="col-4">租選商品:</td>
                            <td class="col-8"><?= $productArr[$valueOP["product_id"]] ?></td>

                        </tr>
                        <tr class="text-center">
                            <td class="col-4">購買數量:</td>
                            <td class="col-8"><?= $valueOP["amount"] ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="text-center">
                            <td class="col-4">總消費金額:</td>
                            <td class="col-8">$ <?= $value["consumption"] ?></td>
                        </tr>
                        <tr class="text-center">
                            <td class="col-4">訂購時間</td>
                            <td class="col-8"><?= $value["created_at"] ?></td>
                        </tr>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<?php require_once("../../js.php") ?>
</body>
<script>

</script>
</html>
