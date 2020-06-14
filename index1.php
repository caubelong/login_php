<?php
include_once "inc/db.inc.php";
$err=[];
function checkForm(){
    global  $err;
    return count($err)==0;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(empty($_POST['user'])){
        $err[]="ban chua nhap user name or email dang nhap";
    }
    if(empty($_POST['password'])){
        $err[]="ban chua nhap password dang nhap";
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
    <title>Index IU</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="home_index">
    <div class="wrap">
        <?php  if($_SERVER['REQUEST_METHOD']=="POST" && checkForm()):?>
            <?php
            $user_login=[];
            $nick=$user_login['user']=mysqli_real_escape_string($db,$_POST['user']);
            $pass=$user_login['password']=mysqli_real_escape_string($db,$_POST['password']);
            $sql="SELECT * FROM user ";
            $sql.="WHERE user_uid='".$nick."'";
            $sql.="AND user_pass='".$pass."'";
            $result=mysqli_query($db,$sql);
            $result_check=mysqli_num_rows($result);
            if($result_check<1){
                echo "<h3>"."tai khoan hoac mat khau khong chinh xac"."</h3>";
            }else{
                $_SESSION['user_login']="<div>"."User Name: ".$nick."<div>";
            }
            echo mysqli_error($db);
        endif;
        ?>
        <?php
            if(isset($_SESSION['user_login'])){
                echo $_SESSION['user_login'];
            }else{
                include_once "include/navbar.php";
            }
        ?>
        <a class="registration"href="singup.php">Registration</a>
        <a class="logout"href="logout.inc.php">Logout</a>
        <section>
            <h3>HOME</h3>
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

</body>
</html>
