<?php
$host = "127.0.0.1";
$port = 3306;
$username = "username";
$password = "password";
$database = "MyDatabase";

$db = new PDO("mysql:host=$host;port=$port",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// other init
date_default_timezone_set("UTC");
session_start();

$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
$db->exec("use `$database`");

function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

$exists = tableExists($db, "High Net Worth Individual");

if (!$exists) {
    //create the database
    $db->exec("CREATE TABLE HNI (
    HNI_id   INTEGER       PRIMARY KEY AUTO_INCREMENT NOT NULL,
    HNI_name VARCHAR (100) NOT NULL
    );");

    $db->exec("CREATE TABLE appointment (
    appointment_id              INTEGER       PRIMARY KEY AUTO_INCREMENT NOT NULL,
    appointment_start           DATETIME      NOT NULL,
    appointment_end             DATETIME      NOT NULL,
    appointment_name    VARCHAR (100),
    appointment_status          VARCHAR (100) DEFAULT 'free' NOT NULL,
    appointment_customer_session VARCHAR (100),
    HNI_id                   INTEGER       NOT NULL
    );");

    $items = array(
        array('name' => 'HNI 1'),
    
    );
    $insert = "INSERT INTO HNI(HNI_name) VALUES (:name)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':name', $name);
    foreach ($items as $m) {
      $name = $m['name'];
      $stmt->execute();
    }

}
