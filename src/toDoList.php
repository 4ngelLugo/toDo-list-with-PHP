<?php

session_start();

include './configs/config.php';

$get_pending = $conn->prepare('SELECT * FROM tasks WHERE task_status = "pending" AND task_user = :user_id');
$get_pending->bindParam(':user_id', $_SESSION['user_id']);
$get_pending->execute();

$pending = $get_pending->fetchAll(PDO::FETCH_ASSOC);

$rows = $conn->prepare('SELECT COUNT(*) total FROM tasks WHERE task_status = "pending" AND task_user = :user_id');
$rows->bindParam(':user_id', $_SESSION['user_id']);
$rows->execute();
$total = $rows->fetchColumn();

$get_completed = $conn->prepare('SELECT * FROM tasks WHERE task_status = "completed" AND task_user = :user_id');
$get_completed->bindParam(':user_id', $_SESSION['user_id']);
$get_completed->execute();

$completed = $get_completed->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>To Do list</title>
</head>

<body>
  <section class="addTask">
    <form action="" id="task-form" class="task-form">
      <label class="task-form__label" for="">Crate task</label>
      <input class="task-form__input" name="task_title" type="text" placeholder="Task title" autocomplete="new-taskTitle" />
      <textarea class="task-form__input" name="task_desc" placeholder="Task description"></textarea>
      <div id="alert"></div>

      <button type="submit">Create</button>
    </form>
  </section>

  <section class="tasks">

    <div class="tasks__pending">

      <h2>Pending</h2>

      <?php
      for ($i = 0; $i < $total; $i++) {
      ?>
        <form action="" id="complete-task" class="complete-task">
          <input type="hidden" name="task_id" value="<?php echo $pending[$i]['task_id'] ?>" />
          <input type="text" name="task_title" value="<?php echo $pending[$i]['task_title'] ?>" disabled />
          <button type="submit">Complete</button>
        </form>
      <?php } ?>

      <div id="alert-pending"></div>

    </div>

    <div class="tasks__completed">

      <h2>Completed</h2>

      <?php
      foreach ($completed as $row) {
      ?>
        <input type="checkbox" name="<?php echo $row['task_title'] ?>" id="task<?php echo $row['task_id'] ?>">
        <span><?php echo $row['task_title'] ?></span>
      <?php } ?>
    </div>

  </section>

  <script src="./modules/createTask/createTask.js"></script>
  <script src="./modules/completeTask/completeTask.js"></script>
</body>

</html>