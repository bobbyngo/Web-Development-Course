<?php

    require_once('art-config.php');
    require_once('browse-paintings.php');
    
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));

    session_start();
    
    if ( isset($_SESSION['paintings'])){

        //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

        //print_r ($_SESSION['paintings'][0][1]); 

        // foreach ($_SESSION['paintings'] as $i => $value) {
        //     echo $i;
        //     print_r ($value[0]);

        // }

    }


    $artists = readAllArtists(); 
    $shapes = readAllShapes();
    $museums = readAllMuseums();
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link
            href="http://fonts.googleapis.com/css?family=Merriweather"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="http://fonts.googleapis.com/css?family=Open+Sans"
            rel="stylesheet"
            type="text/css"
        />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="../css/semantic.js"></script>
        <script src="../js/misc.js"></script>

        <link href="../css/semantic.css" rel="stylesheet" />
        <link href="../css/icon.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <header>
            <div class="ui attached stackable grey inverted menu">
                <div class="ui container">
                    <nav class="right menu">
                        <div class="ui simple dropdown item">
                            <i class="user icon"></i>
                            Account
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <a class="item"
                                    ><i class="sign in icon"></i> Login</a
                                >
                                <a class="item"
                                    ><i class="edit icon"></i> Edit Profile</a
                                >
                                <a class="item"
                                    ><i class="globe icon"></i> Choose
                                    Language</a
                                >
                                <a class="item"
                                    ><i class="settings icon"></i> Account
                                    Settings</a
                                >
                            </div>
                        </div>
                        <a href= "view-favorites.php" class="item">
                            <i class="heartbeat icon"></i> Favorites
                        </a>
                        <a class="item"> <i class="shop icon"></i> Cart </a>
                    </nav>
                </div>
            </div>

            <div class="ui attached stackable borderless huge menu">
                <div class="ui container">
                    <h2 class="header item">
                        <img src="../images/logo5.png" class="ui small image" />
                    </h2>
                    <a class="item"> <i class="home icon"></i> Home </a>
                    <a class="item"> <i class="mail icon"></i> About Us </a>
                    <a class="item"> <i class="home icon"></i> Blog </a>
                    <div class="ui simple dropdown item">
                        <i class="grid layout icon"></i>
                        Browse
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <a class="item"
                                ><i class="users icon"></i> Artists</a
                            >
                            <a class="item"
                                ><i class="theme icon"></i> Genres</a
                            >
                            <?php
                                echo "<a href =\"../list.php\" class=\"item\"><i class=\"paint brush icon\"></i>Paintings</a>";
                            ?>
                            <a class="item"
                                ><i class="cube icon"></i> Subjects</a
                            >
                        </div>
                    </div>
                    <div class="right item">
                        <div class="ui mini icon input">
                            <form role="search" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="text" name= "search" placeholder="Search ..." />
                                <i class="search icon"></i>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="ui segment doubling stackable grid container">
            <section class="five wide column">
                <form class="ui form">
                    <h4 class="ui dividing header">Filters</h4>

                    <div class="field">
                        <label>Artist</label>
                        <select class="ui fluid dropdown" name="artist">
                            <option>Select Artist</option>
                            <?php  
                            foreach ($artists as $artist) {
                                echo '<option>' . $artist['LastName']. "</option>";  
                            } 
                            ?> 
                        </select>
                    </div>
                    <div class="field">
                        <label>Museum</label>
                        <select class="ui fluid dropdown" name="gallery">
                            <option>Select Museum</option>
                            <?php  
                            foreach ($museums as $museum) {
                                echo '<option>' . $museum['GalleryName']. "</option>";  
                            } 
                            ?> 
                        </select>
                    </div>
                    <div class="field">
                        <label>Shape</label>
                        <select class="ui fluid dropdown" name="shape">
                            <option>Select Shape</option>
                            <?php  
                            foreach ($shapes as $shape) {
                                echo '<option>' . $shape['ShapeName']. "</option>";  
                            } 
                            ?> 
                        </select>
                    </div>

                    <button class="small ui orange button" type="submit">
                        <i class="filter icon"></i> Filter
                    </button>
                </form>
            </section>

            <section class="eleven wide column">
                <h1 class="ui header">Favourite Paintings</h1>
                <ul class="ui divided items" id="paintingsList">
                    <?php
                    if ( isset($_SESSION['paintings'])){
                        foreach ($_SESSION['paintings'] as $value) {
                            //foreach ($value as $val) {
                                //echo $val;
                                //echo "\n";
                                //print_r($_SESSION['paintings']);
                                $painting = readPaintingsByID($value[0]);

                                //print_r($value[0]);
                                //print_r($painting);
                                //echo $painting[0];
                               // print_r($painting[0]['ArtistID']);
                                $results = readSelectArtistByID($painting[0]['ArtistID']);

                                echo "<li class=\"item\">";
                                    echo "<a class=\"ui small image\" href=\"../detail.php?id=" . $value[0] ."\"
                                        ><img
                                            src=\"../images/art/works/square-small/" . $value[1] . ".jpg\"
                                    /></a>";
                                    echo "<div class=\"content\">";

                                        echo "<a class=\"header\" href=\"../detail.php?id=" . $value[0] . "\"
                                            >" . $value[2] ."</a
                                        >";
                                        echo "<div class=\"meta\">";
                                            
                                            foreach ($results as $requestedArtist) {
                                                echo "<span class=\"cinema\">" . $requestedArtist['FirstName']. $requestedArtist['LastName'] . "</span>";
                                            }
                                        echo "</div>
                                        
                                        <div class=\"description\">
                                            <p>" . 
                                                $painting[0]['Description']
                                                . "
                                            </p>
                                        </div>";
                                        echo "<div class=\"meta\">";
                                            echo "<strong>$" . number_format($painting[0]['Cost'], 0, '', ', '). "</strong>";
                                        echo "</div>";
                                        echo "<div class=\"extra\">
                                            <a
                                                class=\"ui icon orange button\"
                                                href=\"cart.php?id=565\"
                                                ><i class=\"add to cart icon\"></i
                                            ></a>
                                            <a
                                                class=\"ui icon button\"
                                                href=\"remove-favorites.php?id=". $value[0] .
                                                "&ImageFileName=" . $value[1] .
                                                "&Title=" . $value[2] .
                                                "\" ><i class=\"heart icon\"></i
                                            ></a>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</li>";
                            //}
                        }
                    }
                    ?>
             
                </ul>
            </section>
        </main>

        <footer class="ui black inverted segment">
            <div class="ui container">footer for later</div>
        </footer>
    </body>
</html>
