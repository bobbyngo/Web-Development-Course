<?php
    
    session_start();


    if ($_SERVER['REQUEST_METHOD'] == 'GET' 
    && isset($_GET['id']) && !empty($_GET['id']) 
    && isset($_GET['ImageFileName']) && !empty($_GET['ImageFileName'])
    && isset($_GET['Title']) && !empty($_GET['Title'])) {
        
        $painting_array = array($_GET['id'], $_GET['ImageFileName'], $_GET['Title']);
        //print_r($painting_array);

    }

    //adding elem to array
    $_SESSION['paintings'][] = $painting_array;

    header("Location: view-favorites.php");

?>