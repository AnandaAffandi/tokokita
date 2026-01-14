<?php
session_start();
if(isset($_SESSION['login'])){
    header("Location: ../dashboard/".$_SESSION['role'].".php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-body">

<div class="login-box">
    <h3><i class="fa-solid fa-store"></i> LOGIN TOKO KITA</h3>

    <form method="POST" action="proses_login.php">
        <div style="position:relative;">
            <input type="text" name="username" placeholder="Username" required style="padding-left: 15px;">
        </div>
        <div style="position:relative;">
            <input type="password" name="password" placeholder="Password" required style="padding-left: 15px;">
        </div>
        <button class="btn btn-primary" style="width:100%; margin-top:10px;">MASUK <i class="fa-solid fa-arrow-right"></i></button>
    </form>
</div>

</body>
</html>