<?php
session_start();
if(isset($_SESSION['login'])){
header("Location: dashboard/".$_SESSION['role'].".php");
}else{
header("Location: login/index.php");
}
?>
