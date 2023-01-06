<?php
include "dbconn.php";
if (isset($_POST['adminusername']) && isset($_POST['adminpassword']) && isset($_POST['admincopypassword'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $user = validate($_POST['adminusername']);
    $pass = validate($_POST['adminpassword']);
    $copypass = validate($_POST['admincopypassword']);
    $grade = 'admin';
    if (empty($user)) {
        header("Location:admpanel.php?createadminmessage=Username-ul nu poate fi gol.");
        exit();
    }
    else if(empty($pass)){
        header("Location:admpanel.php?createadminmessage=Parola nu poate fi goală.");
        exit();
    }
    else if($pass != $copypass){
        header("Location:admpanel.php?createadminmessage=Parolele trebuie să coincidă.");
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
            $sql = "INSERT INTO credentials VALUES (?,?,?);";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $user, hash('sha256', $pass), $grade);
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($conn) > 0) {
                header("Location:admpanel.php?createadminmessage=Contul de admin a fost creat cu succes!");
            } 
            else {
                header("Location:admpanel.php?createadminmessage=Eroare la crearea contului de admin: " . mysqli_error($conn));
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }else{
            header("Location:admpanel.php?createadminmessage=Username deja existent.");
            exit();
        }
    }
}else{
    header("Location: admpanel.php");
    exit();
}
?>