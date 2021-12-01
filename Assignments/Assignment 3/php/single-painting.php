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

    function readAllPaintingById($id) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from paintings WHERE PaintingID = ?";  
    
        // $result = $pdo->query($sql); 
        return runQuery($pdo, $sql, array($id));
    }

    function readSelectArtistByID($artistID) {
        // your code goes here
        //$pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from artists where ArtistId= ?'; 
        return runQuery($pdo, $sql, array($artistID)); 
        // $result = $pdo->query($sql); 
    
        // return $result;
    }

    function readReviewByPaintingID($id) {
        // your code goes here
        //$pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from reviews where PaintingID= ?'; 
        //$sql = 'select paintings.*, reviews.Rating from paintings 
        //inner join reviews on paintings.PaintingID = reviews.PaintingID 
        //WHERE PaintingID = ?';
        return runQuery($pdo, $sql, array($id)); 
        // $result = $pdo->query($sql); 
    
        // return $result;
    }

    function readGalleryByGalleryID($id) {
        // your code goes here
        //$pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from galleries where GalleryID= ?'; 
        //$sql = 'select paintings.*, reviews.Rating from paintings 
        //inner join reviews on paintings.PaintingID = reviews.PaintingID 
        //WHERE PaintingID = ?';
        return runQuery($pdo, $sql, array($id)); 
        // $result = $pdo->query($sql); 
    }

    function readGenresByGenreID($id) {
        // your code goes here
        //$pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from genres where GenreID= ?'; 
        //$sql = 'select paintings.*, reviews.Rating from paintings 
        //inner join reviews on paintings.PaintingID = reviews.PaintingID 
        //WHERE PaintingID = ?';
        return runQuery($pdo, $sql, array($id)); 
        // $result = $pdo->query($sql); 
    }

    function readGenreIDByPaintingID($paintingID) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from paintinggenres where paintingID= ?'; 
        return runQuery($pdo, $sql, array($paintingID));
    }
  
    function readSubjectIDByPaintingID($paintingID) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from paintingsubjects where paintingID= ?'; 
        return runQuery($pdo, $sql, array($paintingID));
    }

    function readSubjectBySubjectID($subjectID) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from subjects where SubjectID= ?'; 
        return runQuery($pdo, $sql, array($subjectID));
    }
    

    function readOrderByPaintingID($paintingID) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select paintings.PaintingID, orderdetails.* from paintings 
        inner join orderdetails on paintings.PaintingID = orderdetails.PaintingID
        WHERE paintings.PaintingID = ?'; 
        return runQuery($pdo, $sql, array($paintingID));
    }

    function readFrameByID($frameID) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from typesframes where FrameID= ?'; 
        return runQuery($pdo, $sql, array($frameID));
    }

    function readGlassByID($glassID) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from typesglass where GlassID= ?'; 
        return runQuery($pdo, $sql, array($glassID));
    }

    function readMattByID($mattID) {
        $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
        $sql = 'select * from typesmatt where MattID= ?'; 
        return runQuery($pdo, $sql, array($mattID));
    }
    
?>