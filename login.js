document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector("form");

    loginForm.addEventListener("submit", function(event) {
        const username = document.querySelector('input[name="username"]').value;
        const password = document.querySelector('input[name="password"]').value;

        // Check if the username or password fields are empty
        if (username.trim() === ""  password.trim() === "") {
            alert("Username and password are required.");
            event.preventDefault(); // Prevent form submission
        } else if (username.length < 2  password.length < 2) {
            // Check if username is less than 4 characters or password less than 6 characters
            alert("Username must be at least 2 characters and password must be at least 2 characters long.");
            event.preventDefault(); // Prevent form submission
        }
    });
});