<?php
require_once("common.php");

$table_användare = "CREATE TABLE IF NOT EXISTS användare (
  uid INT PRIMARY KEY AUTO_INCREMENT,
  användarnamn VARCHAR(20),
  mejladress VARCHAR(50),
  lösenordhash VARCHAR(255)
);";

$table_bild = "CREATE TABLE IF NOT EXISTS bild (
  bid INT PRIMARY KEY AUTO_INCREMENT,
  bildadress VARCHAR(255)
);";

$table_inlägg = "CREATE TABLE IF NOT EXISTS inlägg (
  pid INT PRIMARY KEY AUTO_INCREMENT,
  titel VARCHAR(100),
  innehåll TEXT,
  skapades TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  skapare INT,
  bild INT DEFAULT NULL,
  FOREIGN KEY (skapare) REFERENCES användare(uid),
  FOREIGN KEY (bild) REFERENCES bild(bid)
);";

$tables_to_create = array(
  $table_användare,
  $table_bild,
  $table_inlägg
);

foreach($tables_to_create as $t => $sql) {
  if ($conn->query($sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
  }
}