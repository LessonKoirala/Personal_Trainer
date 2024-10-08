document.addEventListener('DOMContentLoaded', function() {
    fetch('get_trainers.php')
        .then(response => response.json())
        .then(data => {
            console.log("Data fetched from get_trainers.php:", data); // Debugging: Check the data

            const trainerContainer = document.getElementById('trainer-container');
            trainerContainer.innerHTML = ''; // Clear existing content

            if (data.trainers.length === 0) {
                trainerContainer.innerHTML = '<p>No trainers available.</p>';
                return;
            }

            data.trainers.forEach(trainer => {
                const listItem = document.createElement('li');
                listItem.classList.add('trainer-item');
                listItem.innerHTML = `
                    <img src="${trainer.photo}" alt="Profile Picture of ${trainer.name}" class="trainer-photo">
                    <h3>${trainer.name}</h3>
                    <p>Email: ${trainer.email}</p>
                    <p>Specialization: ${trainer.specialization}</p>
                    <p>${trainer.bio}</p>
                    <a href="${trainer.cv}" target="_blank">View CV</a>
                `;
                trainerContainer.appendChild(listItem);
            });
        })
        .catch(error => {
            console.error('Error fetching trainers:', error); // Debugging: Check for errors in fetching data
        });
});
