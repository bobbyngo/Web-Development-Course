<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>QuickPoll</title>
    </head>
    <body>
        <h1>QuickPoll Tally</h1>
        <?php
            //echo $_POST['radio'] . "\n";

            if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //if ($_SERVER['REQUEST_METHOD'] == "GET"){
                session_start(); // Create session

                if (!isset($_SESSION['yes']) && !isset($_SESSION['no'])) {
                    $_SESSION['yes'] = 0;
                    $_SESSION['no'] = 0;
                }
                
                if ($_POST['radio'] == 'yes') {
                    //if ($_GET['radio'] == 'yes') {
                    $_SESSION['yes']++;
                } 
                else if ($_POST['radio'] == 'no') {
                    //else if ($_GET['radio'] == 'no') {
                    $_SESSION['no']++;
                }
            }
            // echo $_SESSION['question'];
            // echo "\n";
            // print_r($_SESSION['yes']. "\n");
            // print_r($_SESSION['no']);
        ?>

        <p>Your answer has been registered. The current totals are: </p>

        <?php
        echo "<p>Yes: " . $_SESSION['yes'] ."</p>";

        echo "<p>No:  " . $_SESSION['no'] ."</p>";
              
        echo "<a href=\"registerVote.php?question=".$_SESSION['question'] ."\">Vote again</a>";
        ?>
        <br>
        <a href="register.html">Register a new question</a>
    </body>
</html>