<?php

$output = array();

include '../../configs/config.php';

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$user_password = isset($_POST['user_password']) ? $_POST['user_password'] : null;

function getUserRole($id, $conn)
{
  $get_role = $conn->prepare('SELECT role_name FROM users INNER JOIN roles ON users.user_role = roles.role_id WHERE user_id = :user_id');
  $get_role->bindParam(':user_id', $id);
  $get_role->execute();

  $role = $get_role->fetch(PDO::FETCH_ASSOC);

  return $role['role_name'];
}

if ($user_id && $user_password) {
  if ($conn) {

    $get_user = $conn->prepare('SELECT * FROM users WHERE user_id = :user_id AND user_password = :user_password');
    $get_user->bindParam(':user_id', $user_id);
    $get_user->bindParam(':user_password', $user_password);
    $get_user->execute();

    $validate_user = $get_user->fetch(PDO::FETCH_ASSOC);

    if ($validate_user) {
      
      session_start();
      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_role'] = getUserRole($user_id, $conn);
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
