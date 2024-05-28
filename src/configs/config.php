<?php

try {

  $conn = new PDO('mysql:host=localhost;dbname=crud_php-database', 'Angel', 'Miguellugo1');
  
} catch (PDOException $e) {

  echo $e->getMessage();
};
