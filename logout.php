<?php
    session_start();
    if(isset($_SESSION['name'])){
        session_destroy();
        setcookie(session_name(), '', 0, '/');
        header('Location:index.php?success=Te-ai delogat cu succes!');
    }
    else
        header('Location:index.php');
?>