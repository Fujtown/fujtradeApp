<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Form Wizard</title>
</head>
<body>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to bottom, #FF5722, #6c757d);
    height: 100vh;
    width: 100%;
    background-attachment: fixed;
    display: flex;
    align-items: center; /* Vertical centering */
    justify-content: center; /* Horizontal centering */
    overflow: hidden;
}

.form-wizard {
    width: 100%;
    max-width: 400px;
    margin: auto; /* Helps with centering in some scenarios */
    padding: 20px;
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    color: #fff; /* Ensuring text is visible against the light background */
}

.wizard-section {
    display: none;
}

.wizard-section.active {
    display: block;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #fff; /* Light label color for contrast */
}

.form-group input[type="password"],
.form-group input[type="checkbox"] {
    width: 96%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid rgba(255, 255, 255, 0.3); /* Subtle border for inputs */
    background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent input backgrounds */
    color: #fff; /* Light input text for contrast */
}

button {
    background-color: #FF5722; /* Bootstrap primary blue */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    margin-top: 10px;
}

button:hover {
    background-color: #c2441d; /* Darker blue */
}

/* Adjusts the 'Back' button to match glassmorphism theme */
button[type="button"] {
    background-color: rgba(108, 117, 125, 0.8); /* Semi-transparent grey */
}

button[type="button"]:hover {
    background-color: rgba(90, 98, 104, 0.8); /* Darker semi-transparent grey */
}

/* Style adjustments for better readability and matching the theme */
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: #e2e2e2;
    opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
    color: #e2e2e2;
}

::-ms-input-placeholder { /* Microsoft Edge */
    color: #e2e2e2;
}

.styled-checkbox {
  --normal-bg: #eee;
  --hover-bg: #ddd;
  --active-bg: #FF5722;
}
.styled-checkbox label {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
}
.styled-checkbox label:before {
  content: "";
  background-color: var(--normal-bg);
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50' width='50px' height='50px' fill='white'><path d='M 41.9375 8.625 C 41.273438 8.648438 40.664063 9 40.3125 9.5625 L 21.5 38.34375 L 9.3125 27.8125 C 8.789063 27.269531 8.003906 27.066406 7.28125 27.292969 C 6.5625 27.515625 6.027344 28.125 5.902344 28.867188 C 5.777344 29.613281 6.078125 30.363281 6.6875 30.8125 L 20.625 42.875 C 21.0625 43.246094 21.640625 43.410156 22.207031 43.328125 C 22.777344 43.242188 23.28125 42.917969 23.59375 42.4375 L 43.6875 11.75 C 44.117188 11.121094 44.152344 10.308594 43.78125 9.644531 C 43.410156 8.984375 42.695313 8.589844 41.9375 8.625 Z' /></svg>");
  background-size: 1000%;
  background-position: center;
  display: block;
  width: 25px;
  height: 25px;
  border-radius: 5px;
  transition: 0.2s;
}
.styled-checkbox label:hover:before {
  background-color: var(--hover-bg);
}
.styled-checkbox label:active:before {
  transform: scale(0.9);
}
.styled-checkbox input {
  display: none;
}
.styled-checkbox input:checked + label:before {
  background-color: var(--active-bg);
  background-size: 90%;
}
@media only screen and (max-width: 668px)   {

    .form-wizard{
        width: 88%;
    }
}
</style>
<div class="form-wizard">
    <!-- Section 1: Terms and Conditions -->
    <div class="wizard-section active" id="section1">
        <h2>Terms and Conditions</h2>
        <div class="styled-checkbox">
            <input type="checkbox" id="my-checkbox" />
            <label for="my-checkbox"> I accept the terms and conditions.</label>
          </div>


        <button onclick="nextSection(2)">Next</button>
    </div>

    <!-- Section 2: Passwords -->
    <div class="wizard-section" id="section2">
        <h2>Update Your Password</h2>
        <form id="passwordForm">
            @csrf
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" id="currentPassword" name="currentPassword">
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
            </div>
            <input type="hidden" name="id" id="clientID" value="{{ $id }}">
            <button type="submit">Submit</button>
            <button type="button" onclick="previousSection(1)">Back</button>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
 function nextSection(sectionNum) {
    // Only move to section 2 if terms are accepted
    if (sectionNum === 2) {
        var termsChecked = document.getElementById('my-checkbox').checked;
        if (!termsChecked) {
            alert("Please accept the terms and conditions to proceed.");
            return; // Do not proceed to the next section
        }
    }

    // Hide the current active section
    var currentSection = document.querySelector('.wizard-section.active');
    currentSection.classList.remove('active');

    // Show the new section
    var nextSection = document.getElementById('section' + sectionNum);
    nextSection.classList.add('active');
}

function previousSection(sectionNum) {
    // Hide the current active section
    var currentSection = document.querySelector('.wizard-section.active');
    currentSection.classList.remove('active');

    // Show the previous section
    var prevSection = document.getElementById('section' + sectionNum);
    prevSection.classList.add('active');
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting through the browser

        var currentPassword = document.getElementById('currentPassword').value;
        var newPassword = document.getElementById('newPassword').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        var id=document.getElementById('clientID').value;
        // Check if current password is not empty
        if (!currentPassword) {
            alert("Please enter your current password.");
            return;
        }

        // Check if new password and confirm new password match
        if (newPassword !== confirmPassword) {
            alert("New passwords do not match.");
            return;
        }

        // Proceed with AJAX request
        var formData = new FormData();
        formData.append('currentPassword', currentPassword);
        formData.append('newPassword', newPassword);
        formData.append('id', id);
        // Additional data can be appended here

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url: "{{ url('/updatePassword') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: 'Awesome !',
                    text: 'Password updated successfully !',
                    type: 'success',
                    didClose: () => {
                        // Redirect to the home page
                        window.location.href = '/signin';
                    }
                });
            },
            error: function(response) {
            if(response.status === 422) { // Validation error
                let errors = response.responseJSON.errors;
                Object.keys(errors).forEach(function (key) {
                    $('#error-' + key).text(errors[key][0]);
                });
            } else {
                Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'An error occurred. Please try again.',
                  });
            }
        }
        });
    });
});

</script>
</body>
</html>
