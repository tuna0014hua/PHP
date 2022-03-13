<?php
require_once ("../../pdo_connect_jj.php");
if(!isset($_SESSION["user"])){
    header("location:../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php require_once("../../css.php") ?>
</head>

<body>
    <?php require_once("../../main.php") ?>

    <div class="right">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-3 py-3">
                    <div class="card">
                        <div class="ratio ratio-4x3">
                            <div>
                                <img class="cover-fit card-img-top" src="../../images/map.jpg">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">地圖管理</h5>
                            <p class="card-text">多災多難 | 希望今天沒人...</p>
                            <a role="button" class="btn btn-primary" href="../route/route.php">前往</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 py-3">
                    <div class="card">
                        <div class="ratio ratio-4x3">
                            <div>
                                <img class="cover-fit card-img-top" src="../../images/course.jpg">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">課程管理</h5>
                            <p class="card-text">課程多元 | 教練一對一</p>
                            <a role="button" class="btn btn-primary" href="../course/course.php">前往</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 py-3">
                    <div class="card">
                        <div class="ratio ratio-4x3">
                            <div>
                                <img class="cover-fit card-img-top" src="../../images/product.jpg">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">商品管理</h5>
                            <p class="card-text">所有你想得到的商品我們都可租</p>
                            <a role="button" class="btn btn-primary" href="../product/product.php">前往</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--row end-->
            <div class="row  d-flex justify-content-center text-center">
                <div class="col-lg-3 py-3">
                    <div class="card">
                        <div class="ratio ratio-4x3">
                            <div>
                                <img class="cover-fit card-img-top" src="../../images/post.jpg">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">論壇管理</h5>
                            <p class="card-text">來看看別人怎麼說</p>
                            <a role="button" class="btn btn-primary" href="../post/post.php">前往</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 py-3">
                    <div class="card">
                        <div class="ratio ratio-4x3">
                            <div>
                                <img class="cover-fit card-img-top" src="../../images/order.jpg">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">訂單管理</h5>
                            <p class="card-text">課程 | 商品 | 教練(?)</p>
                            <a role="button" class="btn btn-primary" href="../order/order.php">前往</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 py-3">
                    <div class="card">
                        <div class="ratio ratio-4x3">
                            <div>
                                <img class="cover-fit card-img-top" src="../../images/member.jpg">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">會員管理</h5>
                            <p class="card-text">努力撒$$成為強者</p>
                            <a role="button" class="btn btn-primary" href="../member/member.php">前往</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--row end-->
        </div>
    </div>
    <!--right end-->

    <?php require_once("../../js.php") ?>

</body>

</html>