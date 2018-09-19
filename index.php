<?php 
    session_start();    
    if (!(isset($_SESSION['userinfo']))) {
        header('Location: login.php');
    }
    header('Location: main.php');
?>