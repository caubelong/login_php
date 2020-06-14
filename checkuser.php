<?php
include_once "inc/db.inc.php";
$err=[];
function checkForm(){
    global  $err;
    return count($err)==0;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(empty($_POST['user'])){
        $err[]="ban chua nhap user name or email ";
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
    <section>
        <h3>HOME</h3>
        <h3>Nhap tai khoan hoac email de tim lai mat khau</h3>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
            <input type="text" placeholder="USERNAME-EMAIL" name="user" style="margin-left: 500px;margin-top: 100px">
            <input type="submit" value="Kiem tra" name="submit"style="margin: auto">
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
        $user=[];
        $nick= $user['user']=mysqli_escape_string($db,$_POST['user']);
        $sql="SELECT * FROM user ";
        $sql.="WHERE user_uid='".$nick."'";
        $result=mysqli_query($db,$sql);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck<1){
            echo "<h3>"."khong tim duoc tai khoan hoac email, vui long kiem tra lai"."</h3>";
        }else{
            echo "thanh cong";
            $_SESSION['check_user']=$nick;
            dedirec_to("change_password.php");
        }
        echo mysqli_error($db);
    endif;?>
</body>
</html>
</body>
</html>
