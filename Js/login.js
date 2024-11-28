const signUpButton = document.getElementById("signUp");
const signInButton = document.getElementById("signIn");
const container = document.getElementById("container");

signUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

signInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

// Hiển thị thông báo nếu có
var errorMessage = document.getElementById('error-message');
if (errorMessage.textContent !== '') {
  errorMessage.style.display = 'none';
  alert('Sai tên đăng nhập hoặc mật khẩu!');
  // Ẩn thông báo sau 10 giây
  setTimeout(function () {
    errorMessage.style.display = 'none';
  }, 1000);

}



