<?php

include '../../configs/config.php';

$output = array();

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$user_password = isset($_POST['user_password']) ? $_POST['user_password'] : null;

if ($user_id && $user_password) {
  if ($conn) {

    $get_user = $conn->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $get_user->bindParam(':user_id', $user_id);
    $get_user->execute();

    $validate_user = $get_user->fetch(PDO::FETCH_ASSOC);

    if ($validate_user && password_verify($user_password, $validate_user['user_password'])) {

      session_start();
      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $validate_user['user_name'];

      $output['msg'] = 'success';
    } else {
      $output['error'] = 'non existent data';
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
