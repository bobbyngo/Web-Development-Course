<?php

    require_once('art-config.php');


    function setConnectionInfo($values=array()) {
        try { 
            $pdo = new PDO($values[0],$values[1],$values[2]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } 
        catch (PDOException $e) { 
            die( $e->getMessage() ); 
        }
        return $pdo;
    }

    function runQuery($pdo, $sql, $parameters=array()) {
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }
        $statement = null;
    
        if (count($parameters) > 0) {
            $statement = $pdo->prepare($sql);
            $executed = $statement->execute($parameters);
        }
        else {
            $statement = $pdo->query($sql);
        }
        return $statement;
    }

    function readAllPaintings() {

        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));

        $sql = "select * from paintings LIMIT 20";  
        //return runQuery($pdo, $sql, array());
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('allPaintings', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array());
            $memcache->set('allPaintings', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }
    

    function readAllArtists() {
        // your code goes here
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));

        $sql = "select * from artists order by LastName";  
    
        //return runQuery($pdo, $sql, array());
    
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('allArtists', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array());
            $memcache->set('allArtists', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }

    function readAllShapes() {

        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));

        $sql = "select * from shapes order by ShapeName";  

        //return runQuery($pdo, $sql, array());
    
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('allShapes', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array());
            $memcache->set('allShapes', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }

    function readAllMuseums() {
        // your code goes here
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));

        $sql = "select * from galleries order by GalleryName";  
    
        // $result = $pdo->query($sql); 
        return runQuery($pdo, $sql, array());
    
        // $memcache = new Memcache;
        // $memcache->connect('localhost', 11211) 
        //   or die ("Could not connect");
 
        // $flags = false;
        // $get_cache = $memcache->get('allMuseums', $flags);

        // if (!$flags) {
        //     $result = runQuery($pdo, $sql, array());
        //     $memcache->set('allMuseums', $result->fetchAll(), false, 30) 
        //     or die ("Failed to save data at the server");
        // }
        // else {
        //     $result = $get_cache;

        // }
        // //return $result->fetchAll();
        // return $result;
    }

    function readPaintingsByID($paintingID) {
        // your code goes here
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));

        $sql = 'select * from paintings WHERE PaintingID= ?';  
        //return runQuery($pdo, $sql, array($paintingID));
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('paintingWithID', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array($paintingID));
            $memcache->set('paintingWithID', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }

    function readSelectArtistByID($artistID) {
        // your code goes here
    
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from artists where ArtistId= ?'; 
        //return runQuery($pdo, $sql, array($artistID)); 
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('selectedArtistById', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array($artistID));
            $memcache->set('selectedArtistById', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }

    function readSelectArtist($artistLastName) {
        // your code goes here

        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        // $sql = 'select * from paintings 
        // inner join artists on paintings.ArtistID = artists.ArtistID 
        // WHERE LastName = ?'; 

        // More efficient, only load last name from artist data
        $sql = 'select paintings.*, artists.LastName from paintings 
        inner join artists on paintings.ArtistID = artists.ArtistID 
        WHERE LastName = ?'; 
        //return runQuery($pdo, $sql, array($artistLastName)); 
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('selectArtistByLastName', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array($artistLastName));
            $memcache->set('selectArtistByLastName', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }

    function readSelectGallery($galleryName) {
        // your code goes here
    
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        //$sql = 'select * from artists where GalleryName= ?'; 
        $sql = 'select paintings.*, galleries.GalleryName from paintings 
        inner join galleries on paintings.GalleryID = galleries.GalleryID 
        WHERE GalleryName = ?'; 
        //return runQuery($pdo, $sql, array($galleryName)); 
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('galleryByGalleryName', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array($galleryName));
            $memcache->set('galleryByGalleryName', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }

    function readSelectShapes($shapeName) {
        // your code goes here
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select paintings.*, shapes.ShapeID from paintings 
        inner join shapes on paintings.ShapeID = shapes.ShapeID
        WHERE ShapeName = ?';  
    
        // $result = $pdo->query($sql); 
        //return runQuery($pdo, $sql, array($shapeName));
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) 
          or die ("Could not connect");
 
        $flags = false;
        $get_cache = $memcache->get('allPaintings', $flags);

        if (!$flags) {
            $result = runQuery($pdo, $sql, array($shapeName));
            $memcache->set('allPaintings', $result->fetchAll(), false, 30) 
            or die ("Failed to save data at the server");
        }
        else {
            $result = $get_cache;

        }
        //return $result->fetchAll();
        return $result;
    }

?>