<?php
require_once('security.php');

if(isset($_POST['login_btn'])){
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $sql = "SELECT * FROM admin WHERE email='$email' AND password = '$password' ";
    $result = mysqli_query($conn, $sql);
    $row  = mysqli_fetch_array($result);
    if(is_array($row))
    {
        $_SESSION["id"] = $row['id'];
        $_SESSION["email"]=$row['email']; 
        $_SESSION["username"]=$row['username']; 
        header("Location: home.php");
        echo "Đăng nhập thành công"; 
    }
    else
    {
        echo "Invalid Email ID/Password";
    }
}
?>