<?php
require_once("../../pdo_connect_jj.php");
$sql = "SELECT * FROM category_product";
$stmt = $db_host->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$categoryArr = [];
foreach ($rows as $values) {
    $categoryArr[$values["id"]] = $values["name"];
}

$sql = "SELECT * FROM product WHERE valid=1 ORDER BY id DESC ";
$stmt = $db_host->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
$dataCount = $stmt-> rowCount();

//$sql = "SELECT * FROM product_image ORDER BY id ";
//$stmt = $db_host->prepare($sql);
//$stmt->execute();
//$row_img = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$imageArr=[];
//foreach ($row_img as $value1){
//    $imageArr[$value1["product_id"]]= $value1["image_name"];
//}
?>
<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <?php require_once("../../css.php") ?>
    <?php require_once("../../css-arrow.php") ?>
</head>

<body>
<?php require_once("../../main.php") ?>

<div class="right">
    <div class="container">
        <div class="row d-flex justify-content-center my-3">
<!--            <div class="col-lg-6 position-relative search">-->
<!--                <i class="fas fa-search"></i>-->
<!--                <input type="text" class="searchInput" placeholder="Search for names..">-->
<!--            </div>-->
            <div class="text-end ">
                <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addProductModal" href="#">新增</a>
            </div>
        </div>

        <table id="table" class="table table-borderd" data-toggle="table">
            <thead class="thead">
            <tr>
                <th ><input type="checkbox"></th>
                <th >#</th>
                <th >種類</th>
                <th >商品名稱</th>
                <th >商品圖片</th>
                <th >總數</th>
                <th >價格</th>
                <th style="width: 20%;">商品評論</th>
                <th >新增時間</th>
                <th  class="bg-info text-center">
                    <div class="text-white"><i class="fas fa-eye"></i></div>
                </th>
                <th  class="bg-primary text-center">
                    <div class="text-white"><i class="far fa-edit"></i></div>
                </th>
                <th  class="bg-danger text-center">
                    <div class="text-white"><i class="fas fa-trash-alt"></i></div>
                </th>
            </tr>
            </thead>
            <tbody id="target">
            <?php foreach ($row as $value): ?>

                <tr>
                    <td><input type="checkbox"></td>
                    <td><?= $value["id"] ?></td>
                    <td><?= $categoryArr[$value["category_id"]] ?></td>
                    <td><?= $value["name"] ?></td>
                    <td style="width: 10%;">
                        <div class="ratio ratio-4x3">
                            <img src="product_images/<?= $value["image"] ?>" alt="" class="cover-fit">
                        </div>
                    </td>
                    <td><?= $value["amount"] ?></td>
                    <td>$<?= $value["price"] ?></td>
                    <td>
                        <?= $value["content"] ?>
                    </td>
                    <td><?= $value["created_at"] ?></td>
                    <td class="text-center tdBTnEye">
                        <a data-id="<?= $value["id"] ?>" class="btn" id="view" data-bs-toggle="modal"
                           data-bs-target="#viewProductModal" href="#">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    <td class="text-center tdBTnEdit">
                        <a data-id="<?=$value["id"]?>" class="btn" id="edit" data-bs-toggle="modal" data-bs-target="#editProductModal" href="#">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center tdBTnDetele">
                        <a data-id="<?=$value["id"]?>" class="btn" id="delete1" data-bs-toggle="modal" data-bs-target="#deleteModal" href="#">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!--addProduct Modal--->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title fw-bold" id="addProductModalLabel">新增</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="j-doInsert.php" method="post" enctype="multipart/form-data">
                                                            <div class="row mb-3 h-100 d-flex">
                                                                <label for="inputEmail3" class="col-sm-3 col-form-label">產品編號:&nbsp;</label>
                                                                <div class="col-sm-9 justify-content-center align-self-center">
                                                                    <?= $dataCount+1 ?>
                                                                </div>
                                                            </div>
                            <div class="row mb-3">
                                <label for="category" class="col-sm-3 col-form-label">商品種類:&nbsp;</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="category_id" id="category_id">
                                        <option value="">請選擇種類</option>
                                        <?php foreach ($rows as $values): ?>
                                            <option value="<?= $values["id"] ?>">
                                                <?= $values["name"] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">商品名稱:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="image" class="col-sm-3 col-form-label">商品圖片:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="file" name="file" id="image" multiple>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="amount" class="col-sm-3 col-form-label">商品總數:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="amount" name="amount">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="price" class="col-sm-3 col-form-label">商品價格:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="price" name="price">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="content" class="col-sm-3 col-form-label">商品評論:&nbsp;</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" id="content" name="content"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">確認</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--addProduct Modal end--->

        <!--viewProduct Modal--->
        <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title fw-bold" id="viewProductModalLabel">檢視</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row mb-3 h-100 d-flex">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">商品序號:&nbsp;</label>
                                <div class="col-sm-9 justify-content-center align-self-center" id="viewId">

                                </div>
                            </div>
                            <div class="row mb-3 h-100 d-flex">
                                <label for="category" class="col-sm-3 col-form-label">商品種類:&nbsp;</label>
                                <div class="col-sm-9 justify-content-center align-self-center"
                                     id="viewCategory">
                                </div>
                            </div>
                            <div class="row mb-3 h-100 d-flex">
                                <label for="name" class="col-sm-3 col-form-label">商品名稱:&nbsp;</label>
                                <div class="col-sm-9 justify-content-center align-self-center" id="viewName">

                                </div>
                            </div>
                            <div class="row mb-3 h-100 d-flex">
                                <label for="image" class="col-sm-3 col-form-label">商品圖片:&nbsp;</label>
                                <div class="col-sm-9 justify-content-center align-self-center" >
                                    <!--slider img -->
                                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner" id="images">
<!--                                            <div class="carousel-item active">-->
<!--                                                <img id="viewImage1" src="" class="d-block w-100" alt="">-->
<!--                                            </div>-->
<!--                                            <div class="carousel-item">-->
<!--                                                <img id="viewImage2" src="" class="d-block w-100" alt="">-->
<!--                                            </div>-->
<!--                                            <div class="carousel-item">-->
<!--                                                <img id="viewImage3" src="" class="d-block w-100" alt="">-->
<!--                                            </div>-->
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                            <span id="viewImages" class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
                                <!--slider img end-->
                            </div>
                            <div class="row mb-3 h-100 d-flex">
                                <label for="amount" class="col-sm-3 col-form-label">商品總數:&nbsp;</label>
                                <div class="col-sm-9 justify-content-center align-self-center" id="viewAmount">

                                </div>
                            </div>
                            <div class="row mb-3 h-100 d-flex">
                                <label for="price" class="col-sm-3 col-form-label">商品價格:&nbsp;</label>
                                <div class="col-sm-9 justify-content-center align-self-center" id="viewPrice">

                                </div>
                            </div>
                            <div class="row mb-3 h-100 d-flex">
                                <label for="content" class="col-sm-3 col-form-label">商品評論:&nbsp;</label>
                                <div class="col-sm-9 justify-content-center align-self-center" id="viewContent">

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                    </div>
                </div>
            </div>
        </div>
        <!--viewProduct Modal end--->


        <!--editProduct Modal--->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title fw-bold  text-white" id="editProductModalLabel">編輯</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="j-updateProduct.php" method="post" enctype="multipart/form-data">
                            <div class="row mb-3 h-100 d-flex">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">商品序號:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="id" id="editId" readonly>
                                </div>


                            </div>
                            <div class="row mb-3">
                                <label for="category" class="col-sm-3 col-form-label">商品類別:&nbsp;</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="category_id" id="editCategory" >
                                        <?php foreach ($rows as $values): ?>
                                        <option value="<?=$values["id"]?>"><?=$values["name"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">商品名稱:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="name"  id="editName">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="image" class="col-sm-3 col-form-label">商品圖片:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="file" id="editImage" name="file">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="amount" class="col-sm-3 col-form-label">商品總數:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount" id="editAmount">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="price" class="col-sm-3 col-form-label">商品價格:&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="price" id="editPrice">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="content" class="col-sm-3 col-form-label">商品評論:&nbsp;</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"
                                              id="editContent" name="content"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">確認</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">關閉</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--editProduct Modal end--->


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
                        <button type="button" class="btn btn-primary px-3" data-bs-confirm="modal" id="delete2">確認</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Delete Modal end-->

    </div> <!-- Container end -->
</div>
<?php require_once("../../js.php") ?>
<script>
    //add
    var addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'), {
        keyboard: false
    })
    //view
    var viewProductModal = new bootstrap.Modal(document.getElementById('viewProductModal'), {
        keyboard: false
    })
    //edit
    var editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'), {
        keyboard: false
    })
    //delete
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        keyboard: false
    })
</script>

</body>
<script>
    //檢視api:
    $("#target").on("click", "#view", function (e) {
        e.stopPropagation();
        let id = $(this).data("id");
        let formdata = new FormData();
        formdata.append("id", id);
        axios.post("api/api-view.php", formdata)
            .then(function (response) {
                // console.log(response);
                let data = response.data;
                if (data.status == 0) {
                    console.log("資料讀取錯誤");
                } else {
                    //先用empty讓所有圖片變成空的，再用下面的foreach去跑把他們append進去
                    $("#images").empty();
                    let path="product_images/"+(data.data["image"]);
                    $("#viewId").text(data.data["id"]);
                    $("#viewCategory").text(data.category);
                    $("#viewName").text(data.data["name"]);
                    // $("#viewImage1").attr("src",path);
                    // $("#viewImage2").attr("src",`product_images/${data.img[0]}`);
                    // $("#viewImage3").attr("src",`product_images/${data.img[1]}`);
                    $("#viewAmount").text(data.data["amount"]);
                    $("#viewPrice").text(data.data["price"]);
                    $("#viewContent").text(data.data["content"]);
                    let content=`<div class="carousel-item active">
                                                <img id="viewImage1" src="${path}" class="d-block w-100" alt="">
                                            </div>`;
                    data.img.forEach(function(images){
                        content+=`<div class="carousel-item">
                                                <img  src="product_images/${images}" class="d-block w-100" alt="">
                                            </div>`
                    })
                    console.log(data.img)
                    $("#images").append(content);
                }
            })
    });

    //修改api:
    $("#target").on("click", "#edit", function (e) {
        e.stopPropagation();
        let id = $(this).data("id");
        let formdata = new FormData();
        formdata.append("id", id);
        axios.post("api/api-view.php", formdata)
            .then(function (response) {
                console.log(response);
                let data = response.data;
                if (data.status == 0) {
                    console.log("資料讀取錯誤");
                } else {
                    $("#editId").val(data.data["id"]);
                    $("#editCategory").val(data.data["category_id"]);
                    $("#editName").val(data.data["name"]);
                    // image檔案不可以設預設值:
                    // $("#editImage").val(data.data["image"]);
                    $("#editAmount").val(data.data["amount"]);
                    $("#editPrice").val(data.data["price"]);
                    $("#editContent").val(data.data["content"]);
                }
            })
    });

    //刪除:
    $("#target").on("click", "#delete1", function(e){
        e.stopPropagation();
        let id = $(this).data("id");
        $("#delete2").click ( function(){
            let formdata = new FormData();
            formdata.append("id", id);
            axios.post("api/api-delete.php", formdata)
                .then(function (response) {
                    window.location.reload();
                })

        })

    })


</script>
</html>