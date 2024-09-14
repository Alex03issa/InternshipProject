document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll('.alert-dismissible');

    // Set a timeout to remove the alert after 3 seconds
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show'); // Bootstrap's fade out
            alert.classList.add('fade'); // Add the fade class for animation
            
            // Wait for the fade out transition to finish before removing from DOM
            setTimeout(() => {
                alert.parentElement.remove(); // Completely remove the alert container from the DOM
            }, 150); // Time to allow fade transition to complete
        }, 5000); // Adjust time as needed
    });
});


   
document.addEventListener("DOMContentLoaded", function() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const passwordIcon = document.getElementById('password-icon');
        const confirmPasswordIcon = document.getElementById('confirm-password-icon');
        const strengthContainer = document.getElementById('password-strength-container');

        const lengthIndicator = document.getElementById('length');
        const uppercaseIndicator = document.getElementById('uppercase');
        const numberIndicator = document.getElementById('number');
        const specialIndicator = document.getElementById('special');
        const strengthMessage = document.getElementById('strength-message');

        // Show the strength container when the password field is focused
        password.addEventListener('focus', function() {
            strengthContainer.style.display = 'block';
        });

        // Hide the strength container when the password confirmation field is focused
        confirmPassword.addEventListener('focus', function() {
            strengthContainer.style.display = 'none';
        });

        // Hide the strength container when clicking outside
        document.addEventListener('click', function(event) {
            if (!password.contains(event.target) && !strengthContainer.contains(event.target)) {
                strengthContainer.style.display = 'none';
            }
        });

        // Check password requirements on input
        password.addEventListener('input', function() {
            const value = password.value;

            // Check password requirements
            const lengthValid = value.length >= 8;
            const uppercaseValid = /[A-Z]/.test(value);
            const numberValid = /[0-9]/.test(value);
            const specialValid = /[^A-Za-z0-9]/.test(value);

            // Update the indicators
            updateIndicator(lengthIndicator, lengthValid);
            updateIndicator(uppercaseIndicator, uppercaseValid);
            updateIndicator(numberIndicator, numberValid);
            updateIndicator(specialIndicator, specialValid);

            // Update the overall strength message
            if (lengthValid && uppercaseValid && numberValid && specialValid) {
                strengthMessage.textContent = "Strong";
                strengthMessage.style.color = "green";
            } else if (lengthValid && (uppercaseValid || numberValid || specialValid)) {
                strengthMessage.textContent = "Medium";
                strengthMessage.style.color = "orange";
            } else {
                strengthMessage.textContent = "Weak";
                strengthMessage.style.color = "red";
            }

            // Update the icon for password match
            updateMatchIcon();
        });

        confirmPassword.addEventListener('input', updateMatchIcon);

        function updateIndicator(element, isValid) {
            if (isValid) {
                element.classList.remove('invalid');
                element.classList.add('valid');
                element.querySelector('.fas').classList.remove('fa-times-circle');
                element.querySelector('.fas').classList.add('fa-check-circle');
            } else {
                element.classList.remove('valid');
                element.classList.add('invalid');
                element.querySelector('.fas').classList.remove('fa-check-circle');
                element.querySelector('.fas').classList.add('fa-times-circle');
            }
        }

        function updateMatchIcon() {
            const isMatch = password.value === confirmPassword.value && password.value !== '';
            if (isMatch) {
                confirmPasswordIcon.innerHTML = '<i class="fas fa-check-circle" style="color: green;"></i>';
            } else {
                confirmPasswordIcon.innerHTML = '<i class="fas fa-times-circle" style="color: red;"></i>';
            }
            confirmPasswordIcon.style.display = isMatch || confirmPassword.value ? 'block' : 'none';
        }
    });