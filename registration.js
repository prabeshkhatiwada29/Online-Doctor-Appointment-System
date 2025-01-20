window.onload = function() {
    const messageContainer = document.getElementById('message-container');

    // Display error messages if any
    if (typeof errors !== 'undefined' && errors.length > 0) {
        messageContainer.innerHTML = "<div class='error-messages'>" + 
            errors.map(error => `<p class='error'>${error}</p>`).join('') + 
            "</div>";
    }

    // Display success message if any
    if (typeof success !== 'undefined' && success) {
        messageContainer.innerHTML = success; // Display success message directly
    }
};

// Frontend validation function (you can leave this as it is)
function validateForm() {
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;
    let messageContainer = document.getElementById('message-container');
    let errors = [];

    // Validate Username
    if (username.length < 3 || !/^[A-Za-z\s]+$/.test(username)) {
        errors.push("Username must be at least 3 characters long and contain only letters and spaces.");
    }

    // Validate Email
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        errors.push("Invalid email address.");
    }

    // Validate Password
    if (password.length < 8 || !/[A-Za-z]/.test(password) || !/\d/.test(password)) {
        errors.push("Password must be at least 8 characters long and include letters and numbers.");
    }

    // Confirm Password Match
    if (password !== confirmPassword) {
        errors.push("Passwords do not match.");
    }

    // If there are errors, display them and stop form submission
    if (errors.length > 0) {
        messageContainer.innerHTML = "<div class='error-messages'>" + errors.map(error => `<p class='error'>${error}</p>`).join('') + "</div>";
        return false; // Prevent form submission
    }

    return true;
}
