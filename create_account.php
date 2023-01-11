<?php
include "dbconn.php";
require "captcha.php";
if (isset($_POST['create_user']) && isset($_POST['create_password']) && isset($_POST['copy_password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $user = validate($_POST['create_user']);
    $pass = validate($_POST['create_password']);
    $copypass = validate($_POST['copy_password']);
    $echipa = validate($_POST['echipe']);
    $grade = 'user';
    if (empty($user)) {
        header("Location: loginpage.php?errorcreatecreate=Username-ul nu poate fi gol.");
        exit();
    }
    else if(empty($pass)){
        header("Location: loginpage.php?errorcreate=Parola nu poate fi goală.");
        exit();
    }
    else if($pass != $copypass){
        header("Location: loginpage.php?errorcreate=Parolele trebuie să coincidă.");
        exit();
    }
    else if($echipa == '-'){
        header("Location: loginpage.php?errorcreate=Trebuie să vă alegeți echipa favorită.");
    }
    else if (!$PHPCAP->verify($_POST["captcha"])){
        header("Location:loginpage.php?errorcreate=Captcha incorect.");
        exit();
    }
    else{
        $sql = "SELECT name FROM credentials WHERE name=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_rows = mysqli_stmt_num_rows($stmt);        
        if ($num_rows === 0) {
            $query = "INSERT INTO credentials VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssss", $user, hash('sha256',$pass), $grade, $echipa);
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($conn) > 0) {
                header("Location:index.php?success=Contul a fost creat cu succes!");
            } 
            else {
                header("Location:loginpage.php?errorcreate=Eroare la crearea contului: " . mysqli_error($conn));
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
        else {
            header("Location:loginpage.php?errorcreate=Eroare la conectarea la baza de date: " . mysqli_connect_error());
        }
    }
}
else
    header("Location:index.php");
?>
