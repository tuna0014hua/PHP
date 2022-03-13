<?php
require_once ("pdo_connect_jj.php");
//if (!isset($_POST["email"])) {
//    echo "請輸入電子信箱唷";
//    header("location: login.php");
//    exit;
//}
$email=$_POST["email"];
$password = md5($_POST["password"]);

//
$sql="SELECT * from member where email=? and password=? AND level_id=4 and valid=1";
$stmt=$db_host->prepare($sql);
$stmt->execute([$email,$password]);
$rows=$stmt->fetchall(PDO::FETCH_ASSOC);
$loginStatus=$stmt->rowCount();

if($loginStatus>0){
   $userData=[
       "id"=>$rows[0]["id"],
       "name"=>$rows[0]["name"],
       "email"=>$rows[0]["email"],
       "spending"=>$rows[0]["spending"],
       "point"=>$rows[0]["point"],
       "level_id"=>$rows[0]["level_id"]

   ];
   $_SESSION["user"]=$userData;
   unset($_SESSION["login_error"]);
   header("location:index/home/home.php");
}else{
    if(isset($_SESSION["login_error"])){
        $_SESSION["login_error"]++;
    }else{
        $_SESSION["login_error"]=1;
    }
    echo"登入失敗......";
    header("refresh:1;url=login.php");
}
