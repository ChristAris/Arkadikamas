// Κώδικας JavaScript για ανάκτηση και εμφάνιση των χρηστών
document.addEventListener('DOMContentLoaded', function () {
    // Ανάκτηση δεδομένων χρηστών από το JSON
    const usersJson =" <?php echo $usersJson; ?>;"
    const userListContainer = document.getElementById('userList');

    // Εμφάνιση των χρηστών στη σελίδα
    usersJson.forEach(user => {
        const userElement = document.createElement('div');
        userElement.innerHTML = `<p>${user.name} - ${user.email}</p>`;
        userListContainer.appendChild(userElement);
    });
});
