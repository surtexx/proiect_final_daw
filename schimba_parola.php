<?php
include "dbconn.php";
if (isset($_POST['new_password']) && isset($_POST['confirm_new_password']) && isset($_POST['old_password'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
    session_start();
    $old_password = validate($_POST['old_password']);
    $new_password = validate($_POST['new_password']);
    $confirm_new_password = validate($_POST['confirm_new_password']);
    $sql = "SELECT password FROM credentials WHERE name = '" . $_SESSION['name'] . "';";
    $result = mysqli_query($conn, $sql);
    $pass = mysqli_fetch_assoc($result)['password'];
    if($pass != hash('sha256', $old_password)){
        header("Location:profile.php?errorparola=Parola veche este greșită.");
        exit();
    }
    else if($new_password != $confirm_new_password){
        header("Location:profile.php?errorparola=Parolele trebuie să coincidă.");
        exit();
    }
    $sql = "UPDATE credentials SET password = ? where name = '" . $_SESSION['name'] . "';";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", hash('sha256', $new_password));
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_affected_rows($stmt);        
    if ($num_rows === 1) {
        header("Location:profile.php?errorparola=Parolă modificată cu succes!");
    }
    else 
    {
        header("Location:profile.php?errorparola=Eroare la modificarea parolei " . mysqli_connect_error());
    }
}
else
    header("Location:profile.php?errorparola=Completați ambele câmpuri.");
?>
