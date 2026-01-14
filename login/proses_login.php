<?php
session_start();
include '../config/database.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($koneksi,
    "SELECT * FROM users 
     WHERE username='$username' 
     AND password='$password'"
);

$data = mysqli_fetch_assoc($query);

if(mysqli_num_rows($query) > 0){

    $_SESSION['login'] = true;
    $_SESSION['id']    = $data['id'];
    $_SESSION['nama']  = $data['nama'];
    $_SESSION['role']  = $data['role'];

    header("Location: ../dashboard/".$data['role'].".php");

}else{
    echo "<script>
        alert('Username / Password salah!');
        window.location='index.php';
    </script>";
}
?>
