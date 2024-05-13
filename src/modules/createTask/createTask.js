document.addEventListener("DOMContentLoaded", () => {

  const taskForm = document.getElementById('task-form');
  const alert = document.getElementById('alert');

  taskForm.addEventListener('submit', createTask);

  function createTask(e) {

    e.preventDefault();

    const data = new FormData(taskForm)

    fetch('./modules/createTask/createTask.php', {
      method: 'POST',
      body: data
    })

      .then((res) => res.json())
      .then((response) => {

        if (response.error) {

          switch (response.error) {
            case 'empty':
              showAlert('Complete all fields', 'error');
              break;

            case 'connection error':
              showAlert('Unable to connect with the server', 'error');
              break;
          }

        } else if (response.msg) {
          location.reload();
        }
      })
  }

  const showAlert = (message, type) => {

    alert.innerHTML = `<div>${message}</div>`;
    alert.classList.toggle(`${type}`);
    setTimeout(() => {
      alert.innerHTML = '';
      alert.classList.toggle(`${type}`);
    }, 5000)

  }
})