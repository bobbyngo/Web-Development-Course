<?php

require_once('includes/book-config.inc.php');

// Collection of functions to deal with SQL database
// 


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


function readAllEmployees() {
    // your code goes here
    $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from employees order by LastName";  

    // $result = $pdo->query($sql); 
    return runQuery($pdo, $sql, array());

    //return $result->fetchAll();
}

function readSelectEmployeeByID($EmployeeID) {
    // your code goes here
    //$pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
    $sql = 'select * from employees where EmployeeId= ?'; 
    return runQuery($pdo, $sql, array($EmployeeID)); 
    // $result = $pdo->query($sql); 

    // return $result;
}

function readSelectEmployeesByName($EmployeeName) {
    // your code goes here

    //$pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
    $sql = "select * from employees where LastName= ?"; 

    return runQuery($pdo, $sql, array($EmployeeName)); 
}

function readTODOs($EmployeeID) {
    // your code goes here

    //$pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$sql = 'select * from employeetodo where EmployeeId=' . "\"" . $EmployeeID ."\"";
    $pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
    $sql = 'select * from employeetodo where EmployeeId=?';

    return runQuery($pdo, $sql, array($EmployeeID)); 
}

?>
