<?php
    session_unset();
    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET' 
    && isset($_GET['id']) && !empty($_GET['id']) 
    && isset($_GET['ImageFileName']) && !empty($_GET['ImageFileName'])
    && isset($_GET['Title']) && !empty($_GET['Title'])) {
        
        
        // For delete all
        foreach ($_SESSION['paintings'] as $i => $value) {
            if ($value[0] == $_GET['id'] && $value[1] == $_GET['ImageFileName'] && $value[2] == $_GET['Title']) {
                //session_unset();
                unset($_SESSION['paintings'][$i]);
            }
        }

    }

    header("Location: view-favorites.php");
?>