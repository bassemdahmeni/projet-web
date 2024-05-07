document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        let valid = true;

        // Check all input fields within form
        document.querySelectorAll(".form-c").forEach(input => {
            if (input.value.trim() === "") {
                alert("Please fill out all fields");
                valid = false;
            }
        });

        // Check if password and confirm password match
        const password = document.querySelector("input[name='password']").value;
        const confirm_password = document.querySelector("input[name='confirm_password']").value;
        if (password !== confirm_password) {
            alert("Password and Confirm Password do not match");
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Stop form submission
        }
    });
});