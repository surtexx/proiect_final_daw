<?php
    session_destroy();
    setcookie(session_name(), '', 0, '/');
    header('Location:index.php?success=Te-ai delogat cu succes!');
?>