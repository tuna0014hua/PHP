<?php
require_once ("pdo_connect_jj.php");
//var_dump($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <?php require_once("css.php") ?>
</head>

<body>
    <header class="main_header">

        <div class="header_txt d-flex">
            <div class="logo">
                <h3 class="p-3"><i class="fas fa-snowboarding"></i>SKILOGO</h3>
            </div>
            <div class="txt">
                <div class="p-3 text-end  d-flex justify-content-end">
                    <h4><i class="fas fa-user"></i></h4>
                    <h4 class="text-white px-3" > <?= ($_SESSION["user"]["name"]); ?></h4>
                </div>

            </div>
        </div>
    </header>


    <div class="left">
        <ul class="sidebtn list-unstyled">
            <li id="Home"><a data-toggle="tab" role="button" href="../home/home.php"><i class="fas fa-home"></i>首頁</a></li>
            <li id="Route"><a data-toggle="tab" role="button" href="../route/route.php"><i class="fas fa-map-marker-alt"></i>地圖管理</a></li>
            <li id="Course"><a data-toggle="tab" role="button" href="../course/course.php"><i class="fas fa-star-half-alt"></i>課程管理</a></li>
            <li id="Product"><a data-toggle="tab" role="button" href="../product/product.php"><i class="fab fa-product-hunt"></i>商品管理</a></li>
            <li id="Post"><a data-toggle="tab" role="button" href="../post/post.php"><i class="far fa-comment-alt"></i>論壇管理</a></li>
            <li id="Order"><a data-toggle="tab" role="button" href="../order/order.php"><i class="fas fa-shopping-cart"></i>訂單管理</a></li>
            <li id="Member"><a data-toggle="tab" role="button" href="../member/member.php"><i class="fas fa-user"></i>會員管理</a></li>
        </ul>
        <a data-toggle="tab" role="button" href="../../logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>登出</a>
    </div>
    <!--left end-->   



</body>

</html>