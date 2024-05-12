<?php

try {

  $conn = new PDO('mysql:host=localhost;dbname=crud_php-database', 'Angel', 'Miguellugo1');

  // if ($conn) {
  //   echo 'successful connection';
  // }

} catch (PDOException $e) {

  echo $e->getMessage();
};
