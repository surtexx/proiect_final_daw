<?php
include "dbconn.php";
if (isset($_POST['login_user']) && isset($_POST['login_password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $user = validate($_POST['login_user']);
    $pass = validate($_POST['login_password']);
    if (empty($user)) {
        header("Location: loginpage.php?errorlogin=Username-ul nu poate fi gol.");
        exit();
    }else if(empty($pass)){
        header("Location: loginpage.php?errorlogin=Parola nu poate fi goală.");
        exit();
    }else{
        $sql = "SELECT * FROM credentials WHERE name = ? and password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $user, hash('sha256', $pass));
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_rows = mysqli_stmt_num_rows($stmt); 
        if ($num_rows === 1) {
            mysqli_stmt_bind_result($stmt, $name, $pass, $grad, $echipa);
            mysqli_stmt_fetch($stmt);
            $result_grad = $grad;
            $result_echipa = $echipa;
            session_start();
            $_SESSION['name'] = $user;
            $_SESSION['grad'] = $result_grad;
            $_SESSION['echipa'] = $result_echipa;
            header("Location: index.php");
            exit();
        }
        else
        {
            header("Location: loginpage.php?errorlogin=Username sau parolă invalidă.");
            exit();
        }
    }
}
else{
    header("Location: loginpage.php");
    exit();
}
?>