<?php
include_once "inc/db.inc.php";
$err=[];
function checkForm(){
    global  $err;
    return count($err)==0;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(empty($_POST['pass'])){
        $err[]="ban chua nhap user name or email ";
    }
    if(empty($_POST['pass_2'])){
        $err[]="ban chua nhap user name or email ";
    }
    if($_POST['pass']!==$_POST['pass_2']){
        $err[]="2 mat khau k trung khop";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quen mat khau</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<body class="home_index">
<div class="wrap">

    <a class="registration"href="singup.php">Registration</a>
    <a class="Index"href="index1.php">Index</a>
    <section>
        <h3>HOME</h3>
        <?php
        if(isset($_SESSION['change_pass'])){
            echo $_SESSION['change_pass'];
        }else{
            echo  "<h3>"."Nhap tai khoan hoac email de tim lai mat khau"."</h3>";
        }
        ?>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
            <input type="password" placeholder="PASSWORD_NEW" name="pass" style="margin-left: 500px;margin-top: 100px">
            <input type="password" placeholder="NHAP LAI PASS" name="pass_2" style="margin-left: 500px;margin-top: 100px">
            <input type="submit" value="CHANGE_PASSWORD" name="submit"style="margin: auto">
        </form>
        <?php if($_SERVER['REQUEST_METHOD']=="POST" && !checkForm()):?>
            <div class="err"><span>fix loi sau de tiep tuc</span>
            <ul class="ul-err">
                <?php
                foreach ($err as $key => $value) {
                    if (!empty($value)) {
                        echo "<li>" . $value . "</li>";
                    }
                }
                ?>
            </ul>
            </div><?php endif; ?>

    </section>
    <?php
    include_once "include/footer.php";
    ?>
</div>
<?php if($_SERVER['REQUEST_METHOD']=="POST" && checkForm()) :?>
    <?php
    $nick=null;
    if(isset($_SESSION['check_user'])){
        $nick=$_SESSION['check_user'];
    }
    $pass=[];
    $reques_pass= $pass['pass']=mysqli_escape_string($db,$_POST['pass']);
    $sql="UPDATE user SET user_pass='".$reques_pass."'";
    $sql.="WHERE user_uid='".$nick."'";
    $result=mysqli_query($db,$sql);
    $_SESSION['change_pass']="<h3>"."mat khau cua ban da duoc thay doi"."</h3>";
    echo mysqli_error($db);
endif;?>
</body>
</html>
</body>
</html>
