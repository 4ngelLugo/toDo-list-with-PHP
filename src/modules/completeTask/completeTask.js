document.addEventListener("DOMContentLoaded", () => {

  const tasks = document.querySelectorAll('#complete-task');
  const alert = document.getElementById('alert-pending')

  tasks.forEach(task => {
    task.addEventListener('submit', (e) => {

      e.preventDefault();

      let data = new FormData(task);

      fetch('./modules/completeTask/completeTask.php', {
        method: 'POST',
        body: data
      })

        .then((res) => res.json())
        .then((response) => {

          if (response.error) {

            switch (response.error) {
              case 'error updating':
                showAlert('Error completing the task', 'error');
                break;

              case 'connection error':
                showAlert('Unable to connect with the server', 'error');
                break;
            }

          } else if (response.msg) {
            location.reload();
          }

        })
    });
  });

  const showAlert = (message, type) => {

    alert.innerHTML = `<div>${message}</div>`;
    alert.classList.toggle(`${type}`);
    setTimeout(() => {
      alert.innerHTML = '';
      alert.classList.toggle(`${type}`);
    }, 5000)

  }
})