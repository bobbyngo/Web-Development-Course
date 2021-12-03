<?php
    session_start();
    if (isset($_SESSION['question'])){
        
        $question = $_SESSION['question'];

    }else {
        $question = "Question are not available";
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>QuickPoll</title>
    </head>
    <body>
        <h1>QuickPoll Vote</h1>
        <?php
            echo "<label for=\"vote\">" .$question ."?</label>";
        //echo "<form action=\"showVotes.php?q=\"" . $question . "\" method=\"POST\">"
        echo "<form action=\"showVotes.php\" method=\"POST\">"
        
        ?>

            <br />

                <input type="radio" id="yes" name="radio" value="yes">
                <label for="yes">Yes</label>

            <br />

                <input type="radio" id="no" name="radio" value="no">
                <label for="no">No</label>
            <br />
            <button type="submit">Register my vote</button>
        </form>
    </body>
</html>