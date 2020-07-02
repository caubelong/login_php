<?php
include_once "inc/db.inc.php";
$err = [];
function checkForm()
{
    global  $err;
    return count($err)==0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['user_firstName'])) {
        $err[] = "first name khong duoc de trong";
    }
    if (empty($_POST['user_lastName'])) {
        $err[] = "last name khong duoc de trong";
    }
    if (empty($_POST['user_email'])) {
        $err[] = "email khong duoc de trong";
    }
    if (empty($_POST['user_userName'])) {
        $err[] = "userId name khong duoc de trong";
    }
    if (empty($_POST['user_password'])) {
        $err[] = "password khong duoc de trong";
    }
    if (is_numeric($_POST['user_firstName'])) {
        $err[] = "first name khong the la so";
    }
    if (is_numeric($_POST['user_lastName'])) {
        $err[] = "last name khong the la so";
    }
    if(!filter_var($_POST['user_email'],FILTER_VALIDATE_EMAIL)){
        $err[]="email khong hop le";
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
    <h1>Sign Up</h1>
    <a href="index1.php">Login</a>
    <section>
        <h3>Registration</h3>
        <form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
            <input type="text" placeholder="First Name" name="user_firstName" style="margin-left: 10px"
                   value="<?php echo checkForm() ?"" : $_POST['user_firstName']?>">
            <input type="text" placeholder="Last Name" name="user_lastName"
                   value="<?php echo checkForm() ?"" : $_POST['user_lastName']?>">
            <input type="email" placeholder="Email" name="user_email" style=" height: 35px;
            border: none;
            background: #f5f5dc6b;
            border-radius: 5px;
            padding-left: 55px;
            margin-right: 16px;"
                   value="<?php echo checkForm() ?"" : $_POST['user_email']?>">
            <input type="text" placeholder="User Name" name="user_userName"
                   value="<?php echo checkForm() ? "" : $_POST['user_userName']?>">
            <input type="password" placeholder="Password" name="user_password"
                   value="<?php echo checkForm()?"" : $_POST['user_password']?>">
            <input type="submit" value="Registration">
        </form>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && checkForm()): ?>
            <?php
            $user = [];
            $fist=$user['user_first'] = mysqli_real_escape_string($db, $_POST['user_firstName']);
            $last=$user['user_last'] = mysqli_real_escape_string($db, $_POST['user_lastName']);
            $nick=$user['user_uid'] = mysqli_real_escape_string($db, $_POST['user_userName']);
            $pass=$user['user_pass'] = mysqli_real_escape_string($db, $_POST['user_password']);
            $mail=$user['user_email'] = mysqli_real_escape_string($db, $_POST['user_email']);
//check xem account co ton tai k
            $sql="SELECT * FROM user WHERE user_uid = '$nick' or user_email = '$mail' ";
            $resul=mysqli_query($db,$sql);
            $result_check=mysqli_num_rows($resul);
            if($result_check >0){
                $err[]= "user Name hoac email da ton tai";
            }else{
                $sql="INSERT INTO user(user_first,user_last,user_uid,user_pass,user_email) value(?,?,?,?,?); ";
                $stmt=mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    echo "insert false";
                }else{
                    mysqli_stmt_bind_param($stmt,"sssss",$fist,$last,$nick,$pass,$mail);
                    mysqli_stmt_execute($stmt);
                    // get data
                   $sql="SELECT * FROM user WHERE user_uid='$nick'";
                   $result=mysqli_query($db,$sql);
                   if(mysqli_num_rows($result)>0){
                       while ($row=mysqli_fetch_assoc($result)){
                           $idImg=$row['user_id'];
                           $sql="INSERT INTO profileimg(user_id,status) VALUES ('$idImg',1)";
                           mysqli_query($db,$sql);
                           echo "<h3>"."Registration user with user name = ".$nick." Email khoi phuc tai khoan la " .$mail."</h3>";
                       }
                   }else{
                       echo mysqli_error($db);
                       echo "error!";
                   }
                }
                echo mysqli_error($db);
            }
        endif;?>
<!--        ////////////////////////////////////////////-->
        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && !checkForm()): ?>
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

