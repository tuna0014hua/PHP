<?php require_once ("pdo_connect_jj.php");
if (isset($_SESSION["user"])){

    header("location:index/home/home.php");
}
?>
<!DOCTYPE html>
<html lang="zh-HANT-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <?php require_once("login_css.php") ?>

</head>

<body>

    <div class="logBg position-relative" id="snow-fall">
        <div class="logBg-mask position-absolute">
            <div class="container formBg">
                <div class="center">
                    <h1 class="fw-bold text-center">S&nbsp;K&nbsp;I</h1>
                    <?php if (isset($_SESSION["login_error"]) && $_SESSION["login_error"]>2):  ?>
                    <h4 class="text-center"><br>你已經超過錯誤次數了<br>請稍後再做嘗試。</h4>
                        <img class="bear" src="images/snowbear.png" alt="">
                    <?php else: ?>
                    <form action="doLoginJJ.php" method="post">
                        <div class="mb-2">
                            <label for=""><i class="fas fa-user"></i></label>
                            <input  type="email" class="form-control" name="email" placeholder="請輸入電子信箱" required>
                        </div>
                        <div class="mb-2">
                            <label for=""><i class="fas fa-lock"></i></label>
                            <input type="password" class="form-control" name="password" placeholder="請輸入密碼" required>
                        </div>
                        <?php if(isset( $_SESSION["login_error"])):  ?>
                        <div class="text-danger text-center">使用者帳號或密碼錯誤</div>
                         <div class="text-center text-danger">您已經錯誤<?php  echo $_SESSION["login_error"] ?>次，3次將會鎖定。</div>
                        <?php endif;?>
                        <div class="d-grid py-3">
                            <button class="btn btn-primary" type="submit">登入</button>
                        </div>
                        <p class="text-center" style="font-size: 14px;">SKI.後台管理系統</p>
                        <h2>&nbsp;</h2>
                    </form>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"
            src="particles.js"></script>
    <script type="text/javascript" src="app.js"></script>
</body>

</html>