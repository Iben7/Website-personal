function togglePassword() {
    const passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}

document.querySelector('.login-form').addEventListener('submit', function (event) {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    let valid = true;

    // Validasi username atau email tidak kosong
    if (username === '') {
        alert("Username atau Email tidak boleh kosong");
        valid = false;
    }

    // Validasi password tidak kosong dan minimal 6 karakter
    if (password === '' || password.length < 6) {
        alert("Password harus memiliki minimal 6 karakter");
        valid = false;
    }

    // Jika validasi gagal, cegah form dari pengiriman
    if (!valid) {
        event.preventDefault();
    }
	function togglePassword() {
    const passwordField = document.getElementById('password');
    passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
}

});