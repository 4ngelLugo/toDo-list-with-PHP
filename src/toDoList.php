<?php

session_start();

echo $_SESSION['user_id'];

include './configs/config.php';

$get_tasks = $conn->prepare('SELECT * FROM tasks');
$get_tasks->execute();

$tasks = $get_tasks->fetchAll(PDO::FETCH_ASSOC);

$get_pending = $conn->prepare('SELECT * FROM tasks WHERE task_status = "pending"');
$get_pending->execute();

$pending = $get_pending->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>To Do list</title>
</head>

<sc>
  <section class="addTask">
    <form action="" id="task-form" class="task-form">
      <label class="task-form__label" for="">Crate task</label>
      <input class="task-form__input" name="task_title" type="text" placeholder="Task title" />
      <textarea class="task-form__input" name="task_desc" placeholder="Task description"></textarea>
      <div id="alert"></div>

      <button type="submit">Create</button>
    </form>
  </section>

  <section class="tasks">

    <div class="tasks__pending">
      <?php
      foreach ($pending as $row) {
      ?>
        <input type="checkbox" name="<?php echo $row['task_title'] ?>" id="task<?php echo $row['task_id'] ?>">
        <span><?php echo $row['task_title'] ?></span>
      <?php } ?>
    </div>

  </section>

  <script src="./modules/createTask/createTask.js"></script>
  </body>

</html>