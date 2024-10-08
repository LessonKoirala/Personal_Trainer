document.addEventListener('DOMContentLoaded', function() {
    // Fetch trainer data using the load_trainer_data.php endpoint
    fetch('load_trainer_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error); // Handle error returned from PHP
                return;
            }

            // Populate the form fields with the trainer's data
            document.getElementById('trainer-name').value = data.name || '';
            document.getElementById('trainer-specialization').value = data.specialization || '';
            document.getElementById('trainer-bio').value = data.bio || '';
            document.getElementById('trainer-photo-preview').src = data.photo || 'default.jpg'; // Default image if no photo
        })
        .catch(error => {
            console.error('Error loading trainer data:', error);
        });

    // Handle profile photo upload preview
    const photoInput = document.getElementById('trainer-photo');
    const photoPreview = document.getElementById('trainer-photo-preview');

    photoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            photoPreview.src = URL.createObjectURL(file);
        }
    });

    // Mobile menu toggle
    const menuToggle = document.getElementById('mobile-menu');
    const navLinks = document.getElementById('nav-links');

    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
    });
});
