<?php
include "dbconn.php";
if (isset($_POST['echipe']) && $_POST['echipe'] != '-') {
    session_start();
    $echipa = $_POST['echipe'];
    if($echipa == $_SESSION['echipa']){
        header("Location:profile.php?errorechipa=Echipa selectată este deja preferata dumneavoastră.");
        exit();
    }
    $sql = "UPDATE credentials SET echipa = ? where name = '" . $_SESSION['name'] . "';";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $echipa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_affected_rows($stmt);        
    if ($num_rows === 1) {
        $_SESSION['echipa'] = $echipa;
        header("Location:profile.php?errorechipa=Echipa preferată modificată cu succes!");
    }
    else 
    {
        header("Location:profile.php?errorechipa=Eroare la modificarea echipei " . mysqli_connect_error());
    }
}
else
    header("Location:profile.php?errorechipa=Selectați o echipă.");
?>
