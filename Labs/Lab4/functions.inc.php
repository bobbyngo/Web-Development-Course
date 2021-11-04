<?php

function generateLink($url, $label, $class) {
    
     /* YOUR CODE GOES HERE */
    echo "<a href=\"" .$url. "\" class=\"" .$class. "\">".$label."</a>"; 

}


function outputPostRow($number)  {

    include("travel-data.inc.php");
    /* YOUR CODE GOES HERE */
    echo "<div class='row'>";
        echo "<div class='col-md-4'>";
            $label = "<img src=images/" .${'thumb'.$number}. " alt=". ${'title'.$number}." class=img-responsive>";
            generateLink("post.php?id=".${'postId'.$number}, $label,'');
            //<a href="post.php?id=1" class=""><img src="images/8710320515.jpg" alt="Ekklisia Agii Isidori Church" class="img-responsive"></a>
        echo "</div>";

        // <div class="col-md-4">
        //     <a href="post.php?id=1" class=""><img src="images/8710320515.jpg" alt="Ekklisia Agii Isidori Church" class="img-responsive"></a>
        // </div>

        echo "<div class='col-md-8'>";
            echo "<h2>".${'title'.$number}."</h2>";
            //<h2>Ekklisia Agii Isidori Church</h2>

            echo "<div class='details'>Posted by "; 
            generateLink("user.php?id=".${'userId'.$number}, ${'userName'.$number},'');
            //<div class="details">Posted by <a href="user.php?id=2" class="">Leonie Kohler</a>

            echo "<span class='pull-right'>".${'date'.$number}."</span>";
            //<span class="pull-right">2/8/2017</span>

            echo "<p class='ratings'>";

            constructRating(${'reviewsRating'.$number});
            echo ${'reviewsNum'.$number}. " REVIEWS";

            echo "</p>";

            echo "</div>";
            echo "<p class='excerpt'>".${'excerpt'.$number}."</p>";
            //<p class="excerpt">At the end of the hot climb up to the top Lycabettus Hill you are greeted with the oasis that is the Ekklisia Agii Isidori church.</p>

            echo "<p>";
            generateLink("user.php?id=".${'postId'.$number}, 'Read more','btn btn-primary btn-sm');
            //<p><a href="post.php?id=1" class="btn btn-primary btn-sm">Read more</a></p>
            echo "</p>";
            
        echo "</div>";
    echo "</div>";
    echo "<hr>";
}

/*
  Function constructs a string containing the <img> tags
  necessary to display star images that reflect a rating 
   out of 5
*/
function constructRating($rating) {

    /* YOUR CODE GOES HERE */
    //<p class="ratings"><img src="images/star-gold.svg" width="16">
    //<img src="images/star-white.svg" width="16">
    for ($x = 0; $x < $rating; $x++) {
        echo "<img src='images/star-gold.svg' width='16'>";
    }
    for ($x = 0; $x < (5-$rating); $x++) {
        echo "<img src='images/star-white.svg' width='16'>";
    }
    
}

?>