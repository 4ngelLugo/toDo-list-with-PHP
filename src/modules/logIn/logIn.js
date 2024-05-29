document.addEventListener("DOMContentLoaded", () => {

  const logInForm = document.getElementById('logIn-form');
  const alert = document.getElementById('alert');

  logInForm.addEventListener('submit', logIn);

  function logIn(e) {

    e.preventDefault();

    const data = new FormData(logInForm);

    fetch('./src/modules/logIn/logIn.php', {
      method: "POST",
      body: data
    })

      .then((res) => res.json())
      .then((response) => {

        if (response.error) {
          switch (response.error) {
            case 'empty':
              showAlert('Complete all fields', 'error');
              break;

            case 'non existent data':
              showAlert('Wrong username or password', 'error');
              break;

            case 'connection error':
              showAlert('Unable to connect with the server', 'error');
              break;
          }
        } else if (response.msg) {
          showAlert('Loggin In', 'success');
          setTimeout(() => {
            window.location = './src/toDoList.php';
          }, 1000);
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

  const show = document.getElementById('showPass');
  const inputPass = document.getElementById('user_password');

  show.addEventListener('click', () => {
    if (inputPass.getAttribute('type') === 'password') {
      inputPass.setAttribute('type', 'text');
      show.classList.add('hide');
      show.classList.remove('show');
    } else if (inputPass.getAttribute('type') === 'text') {
      inputPass.setAttribute('type', 'password');
      show.classList.add('show');
      show.classList.remove('hide');
    }

  })

})