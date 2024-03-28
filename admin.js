document.getElementById('migrateButton').addEventListener('click', function() {
    // Show the popup with a username and password input fields
    showLoginPopup();
});

// Function to show the login popup
function showLoginPopup() {
    var popupContent = '<h2>Login</h2>' +
                       '<form id="loginForm">' +
                       '  <label for="username">Username:</label>' +
                       '  <input type="text" id="username" name="username" required><br><br>' +
                       '  <label for="password">Password:</label>' +
                       '  <input type="password" id="password" name="password" required><br><br>' +
                       '  <input type="submit" value="Login">' +
                       '</form>';

    // Create a popup element
    var popup = document.createElement('div');
    popup.id = 'loginPopup';
    popup.innerHTML = '<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #ffffff; padding: 20px; border: 1px solid #cccccc; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">' + popupContent + '</div>';

    // Append the popup to the body
    document.body.appendChild(popup);

    // Add event listener for form submission
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        // Get entered username and password
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        // Send AJAX request to mig_admin.php for validation
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'mig_admin.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // If validation successful, start migration
                if (xhr.responseText.trim() == 'success') {
                    document.body.removeChild(document.getElementById('loginPopup'));
                    showPopup('Migrating Database... <img src="waiting.gif" alt="waiting" style="width: 20px; height: 20px;">');
                    migrateDatabase();
                } else {
                    // If validation failed, show error message
                    document.getElementById('loginForm').reset(); // Reset form fields
                    alert('Invalid username or password. Please try again.');
                }
            }
        };
        xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password));
    });
}

// Function to perform the migration process
function migrateDatabase() {
    // Perform the migration using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'migrate.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // After migration is complete, hide the popup and show success message
            setTimeout(function() {
                document.body.removeChild(document.getElementById('popup'));
                showPopup('Migration Successful');
                // Reload the page after 15 seconds
                setTimeout(function() {
                    location.reload();
                }, 10000);
            }, 8000); // Show the success message after 10 seconds
        }
    };
    xhr.send();
}

// Function to show a popup with a message
function showPopup(message) {
    // Create a popup element
    var popup = document.createElement('div');
    popup.id = 'popup';
    popup.innerHTML = `
    <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #ffffff; padding: 20px; border: 1px solid #cccccc; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); text-align: center;">
      <h2>Database Migration in Progress</h2>
      <img src="waiting.gif" alt="waiting" style="width: 40px; height: 40px; margin-top: 10px;">
      <p>Please wait...</p>
    </div>
  `;
    // Append the popup to the body
    document.body.appendChild(popup);
}