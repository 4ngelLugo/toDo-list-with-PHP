<?php

include '../../configs/config.php';

$output = array();

$task_id = isset($_POST['task_id']) ? $_POST['task_id'] : null;

if ($task_id) {
  if ($conn) {

    $complete_task = $conn->prepare('UPDATE tasks SET task_status = "completed" WHERE task_id = :task_id');
    $complete_task->bindParam(':task_id', $task_id);
    $complete_task->execute();

    if ($complete_task) {
      $output['msg'] = 'task completed';
    } else {
      $output['error'] = 'error updating';
    }
  } else {
    $output['error'] = 'connection error';
  }
} else {
  $output['error'] = 'error updating';
}

header("Content-type: application/json; charset=utf-8");

echo json_encode($output);

exit();