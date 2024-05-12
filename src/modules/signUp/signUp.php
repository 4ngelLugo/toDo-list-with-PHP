<?php

include '../../configs/config.php';

$output = array();

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : null;
$user_password = isset($_POST['user_password']) ? $_POST['user_password'] : null;

$hash = password_hash($user_password, PASSWORD_BCRYPT);

if ($user_id && $user_name && $user_email && $user_password) {
  if ($conn) {

    $validate_user = $conn->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $validate_user->bindParam(':user_id', $user_id);
    $validate_user->execute();

    $validate_rows = $validate_user->fetch(PDO::FETCH_ASSOC);

    if (!$validate_rows) {

      $insert = $conn->prepare('INSERT INTO users VALUE (:user_id, :user_name, :user_email, :user_password)');
      $insert->bindParam(':user_id', $user_id);
      $insert->bindParam(':user_name', $user_name);
      $insert->bindParam(':user_email', $user_email);
      $insert->bindParam(':user_password', $hash);
      $insert->execute();

      if($insert) {
        $output['msg'] = 'user created';
      } else {
        $output['error'] = 'error signing up';
      }

    } else {
      $output['error'] = 'existent user';
    }
  } else {
    $output['error'] = 'connection error';
  }
} else {
  $output['error'] = 'empty';
}

header("Content-type: application/json; charset=utf-8");

echo json_encode($output);

exit();
