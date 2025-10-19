const password = document.getElementById('password');
const eye = document.getElementById('eye');
const hideIcon = document.getElementById('hide');
const showIcon = document.getElementById('show');

eye.addEventListener('click', () => {
  if (password.type === 'password') {
    password.type = 'text';
    hideIcon.style.display = 'none';
    showIcon.style.display = 'block';
  } else {
    password.type = 'password';
    hideIcon.style.display = 'block';
    showIcon.style.display = 'none';
  }
});
