<?php

require_once('php/art-config.php');
require_once('php/single-painting.php');

$pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));

// if we have a non-empty search string, search for employee matches
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && !empty($_GET['id']) ) {
  $results = readAllPaintingById($_GET['id']);
  $painting = $results->fetch();
}
else {

  //Default painting
  $results = readAllPaintingById(7);
  $painting = $results->fetch();
}   


?>


<!DOCTYPE html>
<html lang=en>
<head>
<meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
	<script src="js/misc.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">   
</head>
<body >
    
<header>
    <div class="ui attached stackable grey inverted  menu">
        <div class="ui container">
            <nav class="right menu">            
                <div class="ui simple  dropdown item">
                  <i class="user icon"></i>
                  Account
                    <i class="dropdown icon"></i>
                  <div class="menu">
                    <a class="item"><i class="sign in icon"></i> Login</a>
                    <a class="item"><i class="edit icon"></i> Edit Profile</a>
                    <a class="item"><i class="globe icon"></i> Choose Language</a>
                    <a class="item"><i class="settings icon"></i> Account Settings</a>
                  </div>
                </div>
                <a href="php/view-favorites.php" class=" item">
                  <i class="heartbeat icon"></i> Favorites
                </a>        
                <a class=" item">
                  <i class="shop icon"></i> Cart
                </a>                                     
            </nav>            
        </div>     
    </div>   
    
    <div class="ui attached stackable borderless huge menu">
        <div class="ui container">
            <h2 class="header item">
              <img src="images/logo5.png" class="ui small image" >
            </h2>  
            <a class="item">
              <i class="home icon"></i> Home
            </a>       
            <a class="item">
              <i class="mail icon"></i> About Us
            </a>      
            <a class="item">
              <i class="home icon"></i> Blog
            </a>      
            <div class="ui simple dropdown item">
              <i class="grid layout icon"></i>
              Browse 
                <i class="dropdown icon"></i>
              <div class="menu">
                <a class="item"><i class="users icon"></i> Artists</a>
                <a class="item"><i class="theme icon"></i> Genres</a>
                <?php
                echo "<a href =\"list.php\" class=\"item\"><i class=\"paint brush icon\"></i>Paintings</a>";
                ?>
                <a class="item"><i class="cube icon"></i> Subjects</a>
              </div>
            </div>        
            <div class="right item">
                <div class="ui mini icon input">
                  <input type="text" placeholder="Search ...">
                  <i class="search icon"></i>
                </div>
            </div>      

        </div>
    </div>       
</header> 
    
<main >
    <!-- Main section about painting -->
    <section class="ui segment grey100">
        <div class="ui doubling stackable grid container">
		
            <div class="nine wide column">
              <?php
                echo "<img src=\"images/art/works/medium/" . $painting['ImageFileName'] . ".jpg\" alt=\"...\" class=\"ui big image\" id=\"artwork\">";
              ?>
                
                <!-- <div class="ui fullscreen modal">
                  <div class="image content">
                    <!-- 
                      <img src="images/art/works/large/105010.jpg" alt="..." class="image" >
                      
                        echo "<img src=\"images/art/works/medium/" . $painting['ImageFileName'] . ".jpg\" alt=\"...\" class=\"image\"";
                      
                      <div class="description">
                      <p></p>
                    </div>
                  </div>
                </div> -->
                
            </div>	<!-- END LEFT Picture Column --> 
			
            <div class="seven wide column">
              <!-- Main Info -->
              <div class="item">
                <h2 class="header">
                  <?php
                    echo $painting['Title'];
                  ?>
                </h2>
                <h3>
                <?php
                    $artists = readSelectArtistByID($painting['ArtistID']);
                    $artist = $artists->fetch(); 
                    echo $artist['LastName'];
                ?>
                </h3>
                <div class="meta">
                  <p>
                    <?php
                      $reviews = readReviewByPaintingID($painting['PaintingID']);
                      $review = $reviews->fetch();
                      $rating = $review['Rating'];
                      for ($x = 1; $x <= $rating; $x++) {
                        echo "<i class=\"orange star icon\"></i>";
                      }
                      for ($x = 1; $x <= (5 - $rating); $x++) {
                        echo "<i class=\"empty star icon\"></i>";
                      }
                    ?>
                  </p>
                  <p>
                    <?php
                      echo $painting['Description'];
                    ?>
                  </p>
                </div>  
              </div>                          
                  
          <!-- Tabs For Details, Museum, Genre, Subjects -->
          <div class="ui top attached tabular menu ">
              <a class="active item" data-tab="details"><i class="image icon"></i>Details</a>
              <a class="item" data-tab="museum"><i class="university icon"></i>Museum</a>
              <a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a>
              <a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a>    
          </div>
          
          <div class="ui bottom attached active tab segment" data-tab="details">
              <table class="ui definition very basic collapsing celled table">
					  <tbody>
						  <tr>
						 <td>
							  Artist
						  </td>
						  <td>
              <?php
                $artists = readSelectArtistByID($painting['ArtistID']);
                //$artist = $artists->fetch(); 
                foreach($artists as $artist){
                  echo "<a href=\"" . $artist['ArtistLink'] ."\">" . $artist['LastName'] . "</a>";
                }               
              ?>
							
						  </td>                       
						  </tr>
						<tr>                       
						  <td>
							  Year
						  </td>
						  <td>
              <?php
                echo $painting['YearOfWork'];
              ?>
						  </td>
						</tr>       
						<tr>
						  <td>
							  Medium

						  </td>
						  <td>
              <?php
                echo $painting['Medium'];
                ?>
						  </td>
						</tr>  
						<tr>
						  <td>
							  Dimensions
						  </td>
						  <td>
              <?php
                echo $painting['Width'] . "cm x" . $painting['Height'] . "cm";
              ?>
						  </td>
						</tr>        
					  </tbody>
					</table>
                </div>
				
                <div class="ui bottom attached tab segment" data-tab="museum">
                    <table class="ui definition very basic collapsing celled table">
                      <tbody>
                        <tr>
                          <td>
                              Museum
                          </td>
                          <td>
                            <?php
                              $galleries = readGalleryByGalleryID($painting['GalleryID']);
                              $gallery = $galleries->fetch(); 
                              echo $gallery['GalleryName'];
                            ?>
                          </td>
                        </tr>       
                        <tr>
                          <td>
                              Assession #
                          </td>
                          <td>
                            <?php
                              echo number_format($painting['AccessionNumber'], 0, '','');
                            ?>
                          </td>
                        </tr>  
                        <tr>
                          <td>
                              Copyright
                          </td>
                          <td>
                            <?php
                              echo $painting['CopyrightText'];
                            ?>
                          </td>
                        </tr>       
                        <tr>
                          <td>
                              URL
                          </td>
                          <td>
                          <?php
                            echo "<a href=\"" . $painting['MuseumLink'] . "\">View painting at museum site</a>";
                          ?>
                          </td>
                        </tr>        
                      </tbody>
                    </table>    
                </div>     
                <div class="ui bottom attached tab segment" data-tab="genres">
 
                  <ul class="ui list">
                    <?php
                      $paintingID = $painting['PaintingID'];
                      $genreIDs = readGenreIDByPaintingID($paintingID);
                      foreach ($genreIDs as $genreID) {
                        $genres = readGenresByGenreID($genreID['GenreID']);
                        $genre = $genres->fetch();
                        echo "<li class=\"item\"><a href=\"" . $genre['Link'] . "\">" . $genre["GenreName"] . "</a>";
                      }
                    ?>
                  </ul>

                </div>  
                <div class="ui bottom attached tab segment" data-tab="subjects">
                    <ul class="ui list">
                    <?php
                      $paintingID = $painting['PaintingID'];
                      
                      $subjectIDs = readSubjectIDByPaintingID($paintingID);
                      foreach ($subjectIDs as $subjectID) {
                        $subjects = readSubjectBySubjectID($subjectID['SubjectID']);
                        foreach ($subjects as $subject) {
                          //$subject = $subjects->fetch();
                          echo "<li class=\"item\">". $subject["SubjectName"] . "</a>";
                        }
                      }
                    ?>
                    </ul>
                </div>  
                
                <!-- Cart and Price -->
                <div class="ui segment">
                    <div class="ui form">
                        <div class="ui tiny statistic">
                          <div class="value">
                            <?php
                              echo "$" . number_format($painting['Cost'], 0, "", ", ");
                            ?>
                          </div>
                        </div>
                        <div class="four fields">
                            <div class="three wide field">
                                <label>Quantity</label>
                                <input type="number">
                            </div>                               
                            <div class="four wide field">
                        
                                <label>Frame</label>
                                <select id="frame" class="ui search dropdown">
                                  <?php  
                                    $orderDetails = readOrderByPaintingID($painting['PaintingID']);
                                    
                                    foreach ($orderDetails as $orderDetail) {
                                      $frames = readFrameByID($orderDetail['FrameID']);
                                      $frame = $frames->fetch(); 
                                      echo "<option>" . $frame['Title']. "</option>";
                                    } 
                                    ?>
                                </select>
                            </div>  
                            <div class="four wide field">
                                <label>Glass</label>
                                
                                <select id="glass" class="ui search dropdown">
                              
                                <?php  
                                    $orderDetails = readOrderByPaintingID($painting['PaintingID']);
                                    
                                    foreach ($orderDetails as $orderDetail) {
                                      $glasses = readGlassByID($orderDetail['GlassID']);

                                      $glass = $glasses->fetch(); 
                                      echo $glass['Title'];
                                      echo "<option>" . $glass['Title']. "</option>";
                                    } 
                                    ?>
                                </select>
                            </div>  
                            <div class="four wide field">
                                <label>Matt</label>
                                <select id="matt" class="ui search dropdown">
                                <?php  
                                    $orderDetails = readOrderByPaintingID($painting['PaintingID']);
                                    
                                    foreach ($orderDetails as $orderDetail) {
                                      $matts = readMattByID($orderDetail['MattID']);

                                      $matt = $matts->fetch(); 
                                      echo $matt['Title'];
                                      echo "<option>" . $matt['Title']. "</option>";
                                    } 
                                    ?>
                                </select>
                            </div>           
                        </div>                     
                    </div>

                    <div class="ui divider"></div>

                    <button class="ui labeled icon orange button">
                      <i class="add to cart icon"></i>
                      Add to Cart
                    </button>
                    <button class="ui right labeled icon button">
                      <i class="heart icon"></i>
                      <?php
                      echo "<a href=\"php/addToFavorites.php?id=" 
                                    . $painting['PaintingID'] . 
                                    "&ImageFileName=" . $painting['ImageFileName'] .
                                    "&Title=" . $painting['Title'] .
                                    "\">Add to Favorites</a>"; 
                      ?>
                    </button>        
                </div>     <!-- END Cart -->                      
                          
            </div>	<!-- END RIGHT data Column --> 
        </div>		<!-- END Grid --> 
    </section>		<!-- END Main Section --> 
    
    <!-- Tabs for Description, On the Web, Reviews -->
    <section class="ui doubling stackable grid container">
        <div class="sixteen wide column">
        
            <div class="ui top attached tabular menu ">
              <a class="active item" data-tab="first">Description</a>
              <a class="item" data-tab="second">On the Web</a>
              <a class="item" data-tab="third">Reviews</a>
            </div>
			
            <div class="ui bottom attached active tab segment" data-tab="first">
              <?php
                echo $painting['Description'];
              ?>
            </div>	<!-- END DescriptionTab --> 
			
            <div class="ui bottom attached tab segment" data-tab="second">
				<table class="ui definition very basic collapsing celled table">
                  <tbody>
                      <tr>
                     <td>
                          Wikipedia Link
                      </td>
                      <td>
                        <?php
                          echo "<a href=\"" . $painting['WikiLink'] ."\">View painting on Wikipedia</a>";
                        ?>
                      </td>                       
                      </tr>                       
                      
                      <tr>
                     <td>
                          Google Link
                      </td>
                      <td>
                        <?php
                          echo "<a href=\"" . $painting['GoogleLink'] ."\">View painting on Google Art Project</a>";
                        ?>
                      </td>                       
                      </tr>
                      
                      <tr>
                     <td>
                          Google Text
                      </td>
                      <td>
                      <?php
                        echo $painting['GoogleDescription'];
                      ?>
                      </td>                       
                      </tr>                      
                      
   
       
                  </tbody>
                </table>
            </div>   <!-- END On the Web Tab --> 
			
            <div class="ui bottom attached tab segment" data-tab="third">                
				      <div class="ui feed">
					
				  <!--<div class="event">
					<div class="content">
						<div class="date">12/14/2016</div>
						<div class="meta">
							<a class="like">
							  <i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i>
							</a>
						</div>                    
						<div class="summary">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ac vestibulum ligula. Nam ac erat sit amet odio semper vulputate. Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse consequat pellentesque tellus, nec molestie tortor mattis eu. Aliquam cursus euismod nisl, vel vulputate metus interdum sit amet. Nam dictum eget ex non posuere. Praesent vel sodales velit. Ut id metus aliquam, egestas leo et, auctor ante.        
						</div>       
					</div>
				  </div> -->
					
          <?php
          
            $reviews = readReviewByPaintingID($painting['PaintingID']);
              //$review = $reviews->fetch();
              
              foreach ($reviews as $review) {
                echo  "<div class=\"event\">";
                  echo "<div class=\"content\">";
                    echo "<div class=\"date\">" . $review['ReviewDate'] . "</div>";
          
                    echo "<div class=\"meta\">";
                      echo "<a class=\"like\">";
            
                      $rating = $review['Rating'];
            
                      for ($x = 0; $x <= $rating; $x++) {
                        echo "<i class=\"star icon\"></i>";
                      }
                      echo "</a>";
                    echo "</div>";         
                    echo "<div class=\"summary\">";
                    echo $review['Comment'];
                //Donec vel tincidunt quam. Donec sed dictum quam, nec rutrum risus. Praesent ac tortor ut leo luctus cursus nec pharetra odio. Sed id orci id quam commodo congue eget eget erat. Quisque luctus posuere pharetra.        
                    echo "</div>"; 
                  echo"</div>";
                echo"</div>";                               
              echo "<div class=\"ui divider\"></div>"; 
              //echo "</div>";
            }
					?>
          </div>
				</div>
        
								<!-- END Reviews Tab --> 
        </div>        
    </section> <!-- END Description, On the Web, Reviews Tabs --> 
    
    <!-- Related Images ... will implement this in assignment 2 -->    
    <section class="ui container">
    <h3 class="ui dividing header">Related Works</h3>  
    <!-- Hard coded -->
        <main>
            <!-- Main section about painting -->
            <section class="ui segment grey100">
                <div class="ui doubling stackable grid container">
                    <div class="nine wide column">
                        <img
                            src="images/art/works/medium/105010.jpg"
                            alt="..."
                            class="ui big image"
                            id="artwork"
                        />

                        <!-- <div class="ui fullscreen modal">
                            <div class="image content">
                                <img
                                    src="images/art/works/large/105010.jpg"
                                    alt="..."
                                    class="image"
                                />
                                <div class="description">
                                    <p></p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- END LEFT Picture Column -->

                    <div class="seven wide column">
                        <!-- Main Info -->
                        <div class="item">
                            <h2 class="header">
                                The Anatomy Lesson of Dr. Nicolaes Tulp
                            </h2>
                            <h3>Rembrandt</h3>
                            <div class="meta">
                                <p>
                                    <i class="orange star icon"></i>
                                    <i class="orange star icon"></i>
                                    <i class="orange star icon"></i>
                                    <i class="orange star icon"></i>
                                    <i class="empty star icon"></i>
                                </p>
                                <p>
                                    <em
                                        >The Anatomy Lesson of Dr. Nicolaes
                                        Tulp</em
                                    >
                                    is a 1632 oil painting by Rembrandt housed
                                    in the Mauritshuis museum in The Hague, the
                                    Netherlands.
                                </p>
                            </div>
                        </div>

                        <!-- Tabs For Details, Museum, Genre, Subjects -->
                        <div class="ui top attached tabular menu">
                            <a class="active item" data-tab="details"
                                ><i class="image icon"></i>Details</a
                            >
                            <a class="item" data-tab="museum"
                                ><i class="university icon"></i>Museum</a
                            >
                            <a class="item" data-tab="genres"
                                ><i class="theme icon"></i>Genres</a
                            >
                            <a class="item" data-tab="subjects"
                                ><i class="cube icon"></i>Subjects</a
                            >
                        </div>

                        <div
                            class="ui bottom attached active tab segment"
                            data-tab="details"
                        >
                            <table
                                class="
                                    ui
                                    definition
                                    very
                                    basic
                                    collapsing
                                    celled
                                    table
                                "
                            >
                                <tbody>
                                    <tr>
                                        <td>Artist</td>
                                        <td>
                                            <a href="#">Rembrandt</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Year</td>
                                        <td>1632</td>
                                    </tr>
                                    <tr>
                                        <td>Medium</td>
                                        <td>Oil on canvas</td>
                                    </tr>
                                    <tr>
                                        <td>Dimensions</td>
                                        <td>216cm x 170cm</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div
                            class="ui bottom attached tab segment"
                            data-tab="museum"
                        >
                            <table
                                class="
                                    ui
                                    definition
                                    very
                                    basic
                                    collapsing
                                    celled
                                    table
                                "
                            >
                                <tbody>
                                    <tr>
                                        <td>Museum</td>
                                        <td>
                                            Royal Picture Gallery Mauritshuis
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Assession #</td>
                                        <td>146</td>
                                    </tr>
                                    <tr>
                                        <td>Copyright</td>
                                        <td>Private Use Only</td>
                                    </tr>
                                    <tr>
                                        <td>URL</td>
                                        <td>
                                            <a
                                                href="https://www.mauritshuis.nl/en/explore/the-collection/artworks/the-anatomy-lesson-of-dr-nicolaes-tulp-146/"
                                                >View painting at museum site</a
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="ui bottom attached tab segment"
                            data-tab="genres"
                        >
                            <ul class="ui list">
                                <li class="item"><a href="#">Baroque</a></li>
                                <li class="item">
                                    <a href="#">Dutch Golden Age</a>
                                </li>
                            </ul>
                        </div>
                        <div
                            class="ui bottom attached tab segment"
                            data-tab="subjects"
                        >
                            <ul class="ui list">
                                <li class="item"><a href="#">People</a></li>
                                <li class="item"><a href="#">Science</a></li>
                            </ul>
                        </div>

                    
                    </div>
                    <!-- END RIGHT data Column -->
                </div>
                <!-- END Grid -->
            </section>
            <!-- END Main Section -->

	</section>  
	
</main>    
    

    
  <footer class="ui black inverted segment">
      <div class="ui container">footer</div>
  </footer>
</body>
</html>