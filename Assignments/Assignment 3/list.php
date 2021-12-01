<?php

require_once('php/art-config.php');
require_once('php/browse-paintings.php');

$pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));

// if we have a non-empty search string, search for employee matches
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search']) && !empty($_GET['search']) ) {
   //$employees = readSelectEmployeesByName($_GET['search']); 
   //echo "$_GET['search']";
    $artistLastName = $_GET['search'];
    $paintings =readSelectArtist($artistLastName);
   
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['artist']) && $_GET['artist'] != "Select Artist") {
    $artistLastName = $_GET['artist'];
    $paintings =readSelectArtist($artistLastName);
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['gallery']) && $_GET['gallery'] != "Select Museum") {
    $galleryName = $_GET['gallery'];
    $paintings = readSelectGallery($galleryName);

}
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['shape']) && $_GET['shape'] != "Select Shape") {
    $shapeName = $_GET['shape'];
    $paintings = readSelectShapes($shapeName);
}
else {
   // otherwise get all customers
   $paintings = readAllPaintings(); 
   //echo $employees[9]; 
   //echo $employees['EmployeeID'];
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
        <script src="css/semantic.js"></script>
        <script src="js/misc.js"></script>

        <link href="css/semantic.css" rel="stylesheet" />
        <link href="css/icon.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
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
                        <a href= "php/view-favorites.php" class="item">
                            <i  class="heartbeat icon"></i> Favorites
                        </a>
                        <a class="item"> <i class="shop icon"></i> Cart </a>
                    </nav>
                </div>
            </div>

            <div class="ui attached stackable borderless huge menu">
                <div class="ui container">
                    <h2 class="header item">
                        <img src="images/logo5.png" class="ui small image" />
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
                                echo "<a href =\"list.php\" class=\"item\"><i class=\"paint brush icon\"></i>Paintings</a>";
                            ?>
                            <!-- <a class="item"
                                ><i class="paint brush icon"></i> Paintings</a
                            > -->
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
                <form class="ui form" action="list.php" method="GET">
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
                <h1 class="ui header">Paintings</h1>
                <ul class="ui divided items" id="paintingsList">
                <?php
                    foreach ($paintings as $paint) {
                        echo "<li class=\"item\">";
                        echo "<a class=\"ui small image\" href =\"detail.php?id=" . $paint['PaintingID'] . "\">
                        <img src=\"images/art/works/square-medium/" . $paint['ImageFileName'] . ".jpg\"/></a>";
                        
                            echo "<div class=\"content\">";
                                // Title
                                echo "<a class=\"header\" href=\"detail.php?id=" . $paint['PaintingID']. "\">" 
                                . $paint['Title'] 
                                . "</a>";

                                // Artist name
                                $results = readSelectArtistByID($paint['ArtistID']);
                                //$requestedArtist = $results->fetch();  
                                
                                echo "<div class=\"meta\">";
                                foreach ($results as $requestedArtist) {
                                    echo "<span class=\"cinema\">" . $requestedArtist['FirstName']. $requestedArtist['LastName'] . "</span>";
                                }
                                    echo "</div>";
                                // Description
                                echo "<div class=\"description\">";
                                    echo "<p>";
                                        echo $paint['Description'];
                                    echo "</p>";
                                echo "</div>";

                                //Price

                                echo "<div class=\"meta\">";
                                    echo"<strong>$". number_format($paint['Cost'], 0, '', ', ') . "</strong>";
                                echo "</div>";

                                // Icons
                                echo "<div class=\"extra\">";
                                    echo "<a class=\"ui icon orange button\" 
                                    href=\"cart.php?id=" . $paint['PaintingID'] . "\">
                                    <i class=\"add to cart icon\"></i></a>";

                                    echo "<a class=\"ui icon button\"
                                    href=\"php/addToFavorites.php?id=" 
                                    . $paint['PaintingID'] . 
                                    "&ImageFileName=" . $paint['ImageFileName'] .
                                    "&Title=" . $paint['Title'] .
                                    "\">
                                    <i class=\"heart icon\"></i></a>";
                                echo "</div>";
                            echo "</div>";

                        echo "</li>";
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
