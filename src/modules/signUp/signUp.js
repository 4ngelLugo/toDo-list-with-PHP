document.addEventListener("DOMContentLoaded", () => {

  const signUpForm = document.getElementById('signUp-form');
  const alert = document.getElementById('alert');

  signUpForm.addEventListener('submit', signUp);

  function signUp(e) {

    e.preventDefault();

    const data = new FormData(signUpForm);

    fetch('./src/modules/signUp/signUp.php', {
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

            case 'connection error':
              showAlert('Unable to connect with the server', 'error');
              break;

            case 'error signing up':
              showAlert('An unexpected error ocurred', 'error');
              break;

            case 'existent user':
              showAlert('User already created', 'error');
              break;
          }
        } else if (response.msg) {
          showAlert('User created successfully', 'success');
          setTimeout(() => {
            window.location = './index.html';
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