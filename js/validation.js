function validateLoginForm() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
  
    if (username.trim() === '' || password.trim() === '') {
      alert('Please enter both username and password');
      return false; // Prevent form submission
    }
  
    return true; // Allow form submission
  }
  
  function validateRegisterForm() {
    var username = document.getElementById('reg_username').value;
    var password = document.getElementById('reg_password').value;
    var email = document.getElementById('email').value;
  
    if (username.trim() === '' || email.trim() === '') {
      alert('Please fill in all fields');
      return false; // Prevent form submission
    }
  
    if (password.trim().length < 6) {
      alert('Password should be at least 6 characters');
      return false; // Prevent form submission
    }
  
    return true; // Allow form submission
  }
  