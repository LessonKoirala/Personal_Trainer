// Handle form submission
document.getElementById('signup-form').addEventListener('submit', function(event) {
    // Remove preventDefault to allow the form to submit normally to signup.php
    // We need to submit the form for both client and trainer

    // Get the userType value
    const userType = document.querySelector('input[name="userType"]:checked').value;

    // For clients, just allow the form submission to signup.php
    // If the user is a trainer, let PHP handle the redirection
    if (userType === 'trainer') {
        // We will rely on PHP for handling redirection after data is saved.
    }
});

// Handle Google signup button click
document.getElementById('google-signup').addEventListener('click', function() {
    // Open the Google login form page in a new small tab
    window.open('google-signup.html', 'GoogleLogin', 'width=400,height=600');
});
