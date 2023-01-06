<?php
session_start();
include "dbconn.php";
if (isset($_POST['nametomodify']) && isset($_POST['gradetomodify'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $user = validate($_POST['nametomodify']);
    $grade = validate($_POST['gradetomodify']);
    if (empty($user)) {
        header("Location:admpanel.php?modifymessage=Username-ul nu poate fi gol.");
        exit();
    }
    else if(empty($grade) || (strtolower($grade) != 'admin' && strtolower($grade) != 'user')){
        header("Location:admpanel.php?modifymessage=Gradul poate fi doar admin sau user.");
        exit();
    }
    else if($user == $_SESSION['name']){
        header("Location:admpanel.php?modifymessage=Nu îți poți modifica singur gradul.");
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
            $sql = "UPDATE credentials SET grad = ? WHERE name = ?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", strtolower($grade), $user);
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($conn) > 0) {
                header("Location:admpanel.php?modifymessage=User modificat cu succes!");
            } 
            else {
                header("Location:admpanel.php?modifymessage=Eroare la modificarea user-ului " . mysqli_error($conn));
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }else{
            header("Location:admpanel.php?modifymessage=Username inexistent.");
            exit();
        }
    }
}else{
    header("Location: admpanel.php");
    exit();
}
?>