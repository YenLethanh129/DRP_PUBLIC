const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const forgotBtn = document.getElementById('forgot');
const forgotForm = document.getElementById('forgot-form');
const signUpForm = document.getElementById('sign-up-form');

registerBtn.addEventListener('click', () => {
  container.classList.add('active');
  signUpForm.classList.add('show');
  forgotForm.classList.add('hide');
  forgotForm.classList.remove('show');
  signUpForm.classList.remove('hide');
});

// function changeForgot() {
//   container.classList.add('active');
//   signUpForm.classList.add('show');
//   forgotForm.classList.add('hide');
//   forgotForm.classList.remove('show');
// }

forgotBtn.addEventListener('click', () => {
  container.classList.add('active');
  signUpForm.classList.remove('show');
  forgotForm.classList.remove('hide');
  forgotForm.classList.add('show');
  signUpForm.classList.add('hide');
});

loginBtn.addEventListener('click', () => {
  container.classList.remove('active');
});

