<?php
session_start();
include "dbconn.php";
if (isset($_POST['usertodelete'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $user = validate($_POST['usertodelete']);
    if (empty($user)) {
        header("Location:admpanel.php?deletemessage=Username-ul nu poate fi gol.");
        exit();
    }
    else if($user == $_SESSION['name'])
    {
        header("Location:admpanel.php?deletemessage=Nu te poți șterge singur.");
        exit();
    }
    else{
        $sql = "SELECT name FROM credentials WHERE name=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_rows = mysqli_stmt_num_rows($stmt);
        if ($num_rows === 1) {
            $sql = "DELETE from credentials where name = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($conn) > 0) {
                header("Location:admpanel.php?deletemessage=Contul a fost șters cu succes!");
            } 
            else {
                header("Location:admpanel.php?deletemessage=Eroare la ștergerea contului: " . mysqli_error($conn));
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }else{
            header("Location:admpanel.php?deletemessage=Username invalid.");
            exit();
        }
    }
}else{
    header("Location: admpanel.php");
    exit();
}
?>