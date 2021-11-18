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
}


function runQuery($pdo, $sql, $parameters=array()) {

    // $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $result = $pdo->query($sql);

    // return $result->fetchAll();
}


function readAllEmployees() {
    // your code goes here
    $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from employees order by LastName";  
    $result = $pdo->query($sql); 
    return $result->fetchAll();
}

function readSelectEmployeeByID($EmployeeID) {
    // your code goes here
    $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'select * from employees where EmployeeId=' . "\"" . $EmployeeID ."\"";  
    $result = $pdo->query($sql); 

    return $result;
}

function readSelectEmployeesByName($EmployeeName) {
    // your code goes here

    $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from employees where LastName=" . "\"" . $EmployeeName ."\""; 
    $result = $pdo->query($sql); 
    return $result->fetchAll();
}

function readTODOs($EmployeeID) {
    // your code goes here

    $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'select * from employeetodo where EmployeeId=' . "\"" . $EmployeeID ."\"";
    $result = $pdo->query($sql); 
    return $result->fetchAll(); 
}

?>
