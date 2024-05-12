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
              showAlert('Camplete all fields', 'error');
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
            window.location = './src/configs/config.php';
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

})