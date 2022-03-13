<?php
require_once("../../pdo_connect_jj.php");

$sql = "SELECT * FROM ordered WHERE valid=1 ORDER BY id DESC ";
$stmt = $db_host->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

//$id = 1;
//$sqlO = "SELECT * FROM ordered WHERE valid=1 AND id=? ORDER BY id DESC ";
//$stmtO = $db_host->prepare($sqlO);
//$stmtO->execute([$id]);
//$rowO = $stmtO->fetchAll();

$sqlO = "SELECT ordered.*, order_product.order_id AS order_id 
FROM ordered JOIN order_product ON ordered.id = order_product.order_id 
WHERE ordered.valid=1  ";
$stmtO = $db_host->prepare($sqlO);
$stmtO->execute();
$rowO = $stmtO->fetch(PDO::FETCH_ASSOC);
//可以單純用fetch抓一筆就好，然後下面不要用foreach as 因為這樣會把每一筆顯示出來
$dataCount = $stmt->rowCount();

$sqlM = "SELECT * FROM member";
$stmtM = $db_host->prepare($sqlM);
$stmtM->execute();
$rowM = $stmtM->fetchAll(PDO::FETCH_ASSOC);
$memberArr = [];
foreach ($rowM as $valueM) {
    $memberArr[$valueM["id"]] = $valueM["name"];
}


$sqlC = "SELECT * FROM course";
$stmtC = $db_host->prepare($sqlC);
$stmtC->execute();
$rowC = $stmtC->fetchAll(PDO::FETCH_ASSOC);
//var_dump($rowC);

$sqlP = "SELECT * FROM product";
$stmtP = $db_host->prepare($sqlP);
$stmtP->execute();
$rowP = $stmtP->fetchAll(PDO::FETCH_ASSOC);
$productArr = [];
foreach ($rowP as $valueP) {
    $productArr[$valueP["id"]] = $valueP["price"];
}

?>
<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <?php require_once("../../css.php") ?>
    <?php require_once ("../../css-arrow.php")?>
    <style>
        .order_id {
            /*display: none;*/
        }

        .minus {
            position: absolute;
            right: 0;
            transform: translateY(-20px);
        }
    </style>
</head>

<body>
<?php require_once("../../main.php") ?>

<div class="right">
    <div class="container">
        <div class="row d-flex justify-content-center my-5">
            <!--                <div class="col-lg-6 position-relative search">-->
            <!--                    <i class="fas fa-search"></i>-->
            <!--                    <input type="text" class="searchInput" placeholder="Search for names..">-->
            <!--                </div>-->
            <div class="text-end col-lg-12 mb-2">
                <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addOrderModal" href="#">新增</a>
            </div>
            <div class="text-end col-lg-12 ">
                <a class="btn btn-danger" id="lotDel" data-bs-toggle="modal" data-bs-target="#deleteModal"
                   href="#">批量刪除</a>
            </div>
        </div>
        <table id="table" class="table table-borderd" data-toggle="table">
            <thead class="thead">
            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>#</th>
                <th>會員名稱</th>
                <th>消費金額</th>
                <th>訂購時間</th>
                <th class="bg-info text-center">
                    <div class="text-white"><i class="fas fa-eye"></i></div>
                </th>
                <!--                        <th  class="bg-primary text-center">-->
                <!--                            <div class="text-white"><i class="far fa-edit"></i></div>-->
                <!--                        </th>-->
                <th class="bg-danger text-center">
                    <div class="text-white"><i class="fas fa-trash-alt"></i></div>
                </th>
            </tr>
            </thead>
            <tbody id="target">
            <?php foreach ($row as $value): ?>
                <tr>
                    <td><input data-id="<?= $value["id"] ?>" type="checkbox"></td>
                    <td><?= $value["id"] ?></td>
                    <td><?= $memberArr[$value["member_id"]] ?></td>
                    <td><?= $value["consumption"] ?></td>
                    <td><?= $value["created_at"] ?></td>
                    <td class="text-center tdBTnEye">
                        <a class="btn" href="order-view.php?id=<?= $value["id"] ?>">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    <!--                        <td class="text-center tdBTnEdit">-->
                    <!--                            <a class="btn" data-bs-toggle="modal" data-bs-target="#editOrderModal" href="#">-->
                    <!--                                <i class="far fa-edit"></i>-->
                    <!--                            </a>-->
                    <!--                        </td>-->
                    <td class="text-center tdBTnDetele">
                        <a data-id="<?= $value["id"] ?>" id="delete1" class="btn" data-bs-toggle="modal"
                           data-bs-target="#deleteModal" href="#">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!--addOrder Modal--->
        <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title fw-bold" id="addOrderModalLabel">新增</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="targetP">
                        <form action="j-doOrder.php" method="post">
                            <!--                                <div class="row mb-3 h-100 d-flex">-->
                            <!--                                    <label for="inputEmail3" class="col-sm-3 col-form-label">訂單編號:&nbsp;</label>-->
                            <!--                                    <div class="col-sm-9 justify-content-center align-self-center">-->
                            <!--                                        2-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--member需帶當前登入者帳號-->
                            <div class="row mb-3 order_id">
                                <label for="id" class="col-sm-3 col-form-label">訂單編號:&nbsp;</label>
                                <div class="col-sm-9 py-2" id="">
                                <input type="id" class="form-control-plaintext" name="id" value="<?= $dataCount+1 ?>" readonly>
                                </div>


<!--                                <div class="col-sm-9">-->
<!--                                    <select class="form-select" name="id" id="">-->
<!--                                        <option value="--><?//= $rowO["order_id"] ?><!--">-->
<!--                                            --><?//= $dataCount + 1 ?>
<!--                                        </option>-->
<!--                                    </select>-->
<!--                                </div>-->

                            </div>

                            <div class="row mb-3 h-100 d-flex">
                                <label for="member" class="col-sm-3 col-form-label">會員名稱:&nbsp;</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="member" id="">
                                        <?php foreach ($rowM as $valueM): ?>
                                            <option value="<?= $valueM["id"] ?>">
                                                <?= $valueM["name"] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
<!--                                    <input type="text" class="form-control" id="member" name="member" value="Eddie" readonly>-->
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="course" class="col-sm-3 col-form-label">課程名稱:&nbsp;</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="course_id" id="course">
                                        <option value="">請選擇課程</option>
                                        <?php foreach ($rowC as $valueC): ?>
                                            <option value="<?= $valueC["id"] ?>">
                                                <?= $valueC["name"] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="consumptionC" class="col-sm-3 col-form-label">課程金額:&nbsp;</label>
                                <div class="col-sm-9 py-2" id="coursePrice">
                                    <div type="text" class="" id="consumptionC"></div>
                                </div>
                            </div>
                            <!--                                <div class="row mb-3">-->
                            <!--                                    <label for="amount" class="col-sm-3 col-form-label">課程數量:&nbsp;</label>-->
                            <!--                                    <div class="col-sm-9">-->
                            <!--                                        <input type="text" class="form-control" id="amount" name="amount">-->
                            <!--                                    </div>-->
                            <!--                                </div>-->

                            <div class="row mb-3">
                                <div><i class="fas fa-plus-circle plus" id="plus"
                                        style="color: blue; font-size: 24px; cursor:pointer;"></i></div>
                            </div>
                            <div class="del">
                                <div class="row mb-3 position-relative " id="">
                                    <label for="" class="col-sm-3 col-form-label">商品名稱:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <select class="form-select product" name="product_id" id="product">
                                            <option value="">請選擇商品</option>
                                            <?php foreach ($rowP as $valueP): ?>
                                                <option data-price="<?= $valueP["price"] ?>"
                                                        value="<?= $valueP["id"] ?>">
                                                    <?= $valueP["name"] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="row mb-3 minus">
                                    <div id="minus"><i class="fas fa-minus-circle plus"
                                                       style="color: red; font-size: 16px; cursor:pointer;"></i></div>
                                </div>


                                <div class="row mb-3 ">
                                    <label for="amount" class="col-sm-3 col-form-label">商品數量:&nbsp;</label>
                                    <div class="col-sm-9 amount">
                                        <input type="number" class="form-control number" id="amount" name="amount"
                                               placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3" id="productPriceTop">
                                <label for="consumptionP" class="col-sm-3 col-form-label">商品金額:&nbsp;</label>
                                <div class="col-sm-9 py-2" id="productPrice">
                                    <div type="text" class="" id="consumptionP"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="consumption" class="col-sm-3 col-form-label">總消費金額:&nbsp;</label>
                                <div class="col-sm-9" id="targetPrice">
                                    <input type="text" class="form-control-plaintext" id="consumption"
                                           name="consumption" readonly>
                                </div>
                            </div>
                            <!--                                <div class="row mb-3">-->
                            <!--                                    <label for="content" class="col-sm-3 col-form-label">Content:&nbsp;</label>-->
                            <!--                                    <div class="col-sm-9">-->
                            <!--                                        <textarea type="text" class="form-control" id="content"></textarea>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">確認</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--addOrder Modal end--->

        <!--            viewOrder Modal--->
        <!--            <div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">-->
        <!--                <div class="modal-dialog modal-dialog-centered">-->
        <!--                    <div class="modal-content">-->
        <!--                        <div class="modal-header bg-info">-->
        <!--                            <h5 class="modal-title fw-bold" id="viewOrderModalLabel">檢視</h5>-->
        <!--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
        <!--                        </div>-->
        <!--                        <div class="modal-body">-->
        <!--                            <form>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        1-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="category" class="col-sm-2 col-form-label">Category:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        board-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="name" class="col-sm-2 col-form-label">Name:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        snowboard-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="image" class="col-sm-2 col-form-label">Image:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        silder img -->
        <!--                                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">-->
        <!--                                            <div class="carousel-inner">-->
        <!--                                                <div class="carousel-item active">                                                -->
        <!--                                                    <img src="images/Order.jpg" class="d-block w-100" alt="">-->
        <!--                                                </div>-->
        <!--                                                <div class="carousel-item">-->
        <!--                                                    <img src="images/Order.jpg" class="d-block w-100" alt="">-->
        <!--                                                </div>-->
        <!--                                                <div class="carousel-item">-->
        <!--                                                    <img src="images/Order.jpg" class="d-block w-100" alt="">-->
        <!--                                                </div>-->
        <!--                                            </div>-->
        <!--                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">-->
        <!--                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
        <!--                                                <span class="visually-hidden">Previous</span>-->
        <!--                                            </button>-->
        <!--                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">-->
        <!--                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
        <!--                                                <span class="visually-hidden">Next</span>-->
        <!--                                            </button>-->
        <!--                                        </div>-->
        <!--                                    </div> silder img end-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="amout" class="col-sm-2 col-form-label">Amount:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        15-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="price" class="col-sm-2 col-form-label">Price:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        $1200-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="content" class="col-sm-2 col-form-label">Content:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        多款酷炫滑雪板多款酷炫滑雪板多款酷炫滑雪板多款酷炫滑雪板-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                            </form>-->
        <!--                        </div>-->
        <!--                        <div class="modal-footer">-->
        <!--                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            viewOrder Modal end--->


        <!--editOrder Modal--->
        <!--            <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">-->
        <!--                <div class="modal-dialog modal-dialog-centered">-->
        <!--                    <div class="modal-content">-->
        <!--                        <div class="modal-header bg-primary">-->
        <!--                            <h5 class="modal-title fw-bold  text-white" id="editOrderModalLabel">編輯</h5>-->
        <!--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
        <!--                        </div>-->
        <!--                        <div class="modal-body">-->
        <!--                            <form>-->
        <!--                                <div class="row mb-3 h-100 d-flex">-->
        <!--                                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10 justify-content-center align-self-center">-->
        <!--                                        1-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3">-->
        <!--                                    <label for="category" class="col-sm-2 col-form-label">Category:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10">-->
        <!--                                        <input type="text" class="form-control" id="category" name="category" value="board">-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3">-->
        <!--                                    <label for="name" class="col-sm-2 col-form-label">Name:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10">-->
        <!--                                        <input type="text" class="form-control" id="name" name="name" value="snowboard">-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3">-->
        <!--                                    <label for="image" class="col-sm-2 col-form-label">Image:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10">-->
        <!--                                        <input class="form-control" type="file" id="image">-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3">-->
        <!--                                    <label for="amout" class="col-sm-2 col-form-label">Amount:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10">-->
        <!--                                        <input type="text" class="form-control" id="amout" name="amout" value="15">-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3">-->
        <!--                                    <label for="price" class="col-sm-2 col-form-label">Price:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10">-->
        <!--                                        <input type="text" class="form-control" id="price" name="Price" value="$1200">-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div class="row mb-3">-->
        <!--                                    <label for="content" class="col-sm-2 col-form-label">Content:&nbsp;</label>-->
        <!--                                    <div class="col-sm-10">-->
        <!--                                        <textarea type="text" class="form-control" id="content">多款酷炫滑雪板多款酷炫滑雪板多款酷炫滑雪板多款酷炫滑雪板</textarea>-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                            </form>-->
        <!--                        </div>-->
        <!--                        <div class="modal-footer">-->
        <!--                            <button type="button" class="btn btn-primary">確認</button>-->
        <!--                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--editOrder Modal end--->


        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center fw-bold fs-5">
                        你確定要刪除你辛苦建立的資料嗎?!?!
                    </div>
                    <div class="modal-footer">
                        <!-- data-bs-confirm 需確認用法-->
                        <button id="delete2" type="submit" class="btn btn-primary px-3" data-bs-confirm="modal">確認
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Delete Modal end-->

    </div> <!-- Container end -->
</div>
<?php require_once("../../js.php") ?>
<!--    <script src="https://code.jquery.com/jquery-3.3.1.min.js"-->
<!--            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
<script>

    //新增頁面，點選課程會跳出那個課程多少錢
    $("#targetP").on("change", "#course", function () {
        let idC = $("#course").val();
        let idP = $("#product").val();
        let formdata = new FormData();
        formdata.append("idC", idC);
        formdata.append("idP", idP);
        axios.post("api/api-orderPrice.php", formdata)
            .then(function (response) {
                // console.log(response);
                let data = response.data;
                if (data.status == 0) {
                    console.log("資料讀取錯誤");
                } else {
                    $("#consumptionC").text(data.dataC["price"]);
                    let total = Number($("#consumptionP").text()) + Number(data.dataC["price"]);
                    $("#consumption").val(total);
                    // console.log(($("#consumption").val()))
                }
            })
    });
    //新增頁面，點選商品會跳出那個商品多少錢
    // $("#targetP").on("change", ".product", function () {
    //     let idC = $("#course").val();
    //     let idP = $("#product").val();
    //     let formdata = new FormData();
    //     formdata.append("idC", idC);
    //     formdata.append("idP", idP);
    //     axios.post("api/api-orderPrice.php", formdata)
    //         .then(function (response) {
    //             // console.log(response);
    //             let data = response.data;
    //             if (data.status == 0) {
    //                 console.log("資料讀取錯誤");
    //             } else {
    //                 $("#consumptionP").text(data.dataP["price"]);
    //                 let total= Number(data.dataP["price"]) + Number(data.dataC["price"]);
    //                 $("#consumption").val(total);
    //             }
    //
    //         })
    // });

    //改完數量後即時顯示金額:
    $("#targetP").on("change", ".number", function () {
        let idC = $("#course").val();
        let formdata = new FormData();
        formdata.append("idC", idC);
        // axios.post("api/api-orderPrice.php", formdata)
        for (let i = 0; i < $(".product").length; i++) {
            // subtotal=0;
            let idP = $(".product").eq(i).val();
            // console.log(idP)  //有幾個產品就有抓到幾樣 ok
            formdata.append("idP", idP);
            axios.post("api/api-orderPrice.php", formdata)
                .then(function (response) {
                    let data = response.data;
                    // console.log(data)
                    if (data.status == 0) {
                        console.log("資料讀取錯誤");
                    } else {
                        // $(".amount input").each(function(){})
                        // let row=$(this).eq(i);
                        let price = Number(data.dataP["price"]);
                        // console.log(price)
                        // let amount= Number(row.val());
                        let amount = Number($(".amount input").eq(i).val());
                        // console.log(amount)
                        let subtotal = price * amount;
                        console.log(subtotal)
                        $("#consumptionC").text(data.dataC["price"]);
                        $("#consumptionP").text(subtotal);
                        let total = Number(data.dataC["price"]) + subtotal;
                        $("#consumption").val(total);
                    }
                })
        }

    })

    //想買多個商品的話:
    $("#targetP").on("click", "#plus", function () {
        $("#productPriceTop").before(`
        <div class="del">
            <div class="row mb-3 position-relative" >
                                    <label for="" class="col-sm-3 col-form-label">商品名稱:&nbsp;</label>
                                    <div class="col-sm-9">
                                        <select  class="form-select product" name="product_id" id="product">
                                            <option value="">請選擇商品</option>
                                            <?php foreach ($rowP as $valueP): ?>
                                                <option value="<?=$valueP["id"]?>">
                                                    <?=$valueP["name"]?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 minus">
                                <div id="minus"><i class="fas fa-minus-circle plus"
                                        style="color: red; font-size: 16px; cursor:pointer;"></i></div>
                            </div>
                                <div class="row mb-3">
                                    <label for="amount" class="col-sm-3 col-form-label">商品數量:&nbsp;</label>
                                    <div class="col-sm-9 amount">
                                        <input type="number" class="form-control number" id="amount" name="amount" placeholder="0">
                                    </div>
                                </div>
                                </div>
            `)
    })

    // 在新增的視窗刪減一個指定欄位:
    $("#targetP").on("click", "#minus", function () {
        console.log($(this)) // (#minus)
        $(this).closest(".del").remove();

    })

    //刪除:
    $("#target").on("click", "#delete1", function () {
        let id = $(this).data("id");
        $("#delete2").click(function () {
            let formdata = new FormData();
            formdata.append("id", id);
            axios.post("api/api-orderDelete.php", formdata)
            window.location.reload();
        })
    })
    //批量刪除:
    $("tbody :checkbox").click(function () {
        let checked = $(this).prop("checked")
        let dataCount = $("tbody tr").length;
        let checkedCount = $("tbody :checked").length
        if (checked) {
            $(this).closest("tr").addClass("active")
        } else {
            $(this).closest("tr").removeClass("active")
        }
        if (dataCount == checkedCount) {
            $("#checkAll").prop("checked", true)
        } else {
            $("#checkAll").prop("checked", false)
        }
    })
    $("#checkAll").click(function () {
        let status = $(this).prop("checked")
        $("tbody :checkbox").prop("checked", status)
        //讓tbody的checkbox跟checkAll同步
        if (status) {
            $("tbody tr").addClass("active")
        } else {
            $("tbody tr").removeClass("active")
        }
    })
    //delete the selected items
    $("#lotDel").click(function () {
        let checkedCount = $("tbody :checkbox").length
        let ids = [];
        //取得所有被選取的id並存成陣列
        for (let i = 0; i < checkedCount; i++) {
            let id = $("tbody :checkbox").eq(i).data("id")
            if ($("tbody :checkbox").eq(i).prop("checked")) {
                ids.push(id)
            }
        }
        console.log(checkedCount)
        //call delete api 分別將被選取id刪除
        ids.forEach(function (id) {
            //點選確認刪除後
            $("#delete2").click(function () {
                let formdata = new FormData();
                formdata.append("id", id);
                console.log(id);
                //call API的位置&檔案因人而異
                axios.post("api/api-orderDelete.php", formdata)
                window.location.reload();
            })
        })
    })


    //add
    var addOrderModal = new bootstrap.Modal(document.getElementById('addOrderModal'), {
        keyboard: false
    })
    //view
    // var viewOrderModal = new bootstrap.Modal(document.getElementById('viewOrderModal'), {
    //     keyboard: false
    // })
    //edit
    // var editOrderModal = new bootstrap.Modal(document.getElementById('editOrderModal'), {
    //     keyboard: false
    // })
    //delete
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        keyboard: false
    })
</script>

</body>

</html>