<?php

session_start();

include '../../configs/config.php';

$output = array();
$task_user = $_SESSION['user_id'];

$task_title = isset($_POST['task_title']) ? $_POST['task_title'] : null;
$task_desc = isset($_POST['task_desc']) ? $_POST['task_desc'] : null;

if ($task_title && $task_desc) {
  if ($conn) {

    $insert_task = $conn->prepare('INSERT INTO tasks (task_title, task_desc, task_user) VALUES (:task_title, :task_desc, :task_user)');
    $insert_task->bindParam(':task_title', $task_title);
    $insert_task->bindParam(':task_desc', $task_desc);
    $insert_task->bindParam(':task_user', $task_user);
    $insert_task->execute();

    if ($insert_task) {
      $output['msg'] = 'task created';
    } else {
      $output['error'] = 'error creating';
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
