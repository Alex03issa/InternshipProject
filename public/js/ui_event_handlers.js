// Function to handle alerts disappearing after a set timeout
function handleAlerts() {
    const alerts = document.querySelectorAll('.alert-dismissible');

    // Set a timeout to remove the alert after 5 seconds
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
}

// Function to handle password strength and confirmation validation
function handlePasswordValidation() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const passwordIcon = document.getElementById('password-icon');
    const confirmPasswordIcon = document.getElementById('confirm-password-icon');
    const strengthContainer = document.getElementById('password-strength-container');

    // Added existence checks to prevent null errors on pages without these elements
    if (!password || !confirmPassword) {
        // If the required elements are not found, do not run this function.
        return;
    }

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

}


// Function to handle smooth scrolling to sections
function smoothScroll() {
    const navLinks = document.querySelectorAll('.nav-link.page-scroll');

    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            const href = link.getAttribute('href');
            if (href.startsWith('#')) { // Check if it's a section link
                event.preventDefault(); // Prevent default link behavior

                const sectionId = href.substring(1); // Get the section ID without the '#'
                const targetElement = document.getElementById(sectionId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            } else {
                // If it's not an anchor link, navigate to the page
                window.location.href = href;
            }
        });
    });
}



// Function to highlight the active section in the navbar
function highlightActiveSection() {
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', updateActiveLink);
    // Trigger the update when clicking a link
    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();  // Prevent the default anchor behavior
            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: 'smooth',
                });
            }
            // Directly update the active link after scrolling
            updateActiveLink();
        });
    });

    function updateActiveLink() {
        let current = "";

        // Get current scroll position and adjust for navbar height
        const scrollPosition = window.scrollY + 200;

        // Only proceed if sections exist on the page
        if (sections.length > 0) {
            sections.forEach(section => {
                if (section) {
                    const sectionTop = section.offsetTop - 200;
                    const sectionHeight = section.clientHeight;

                    // Check if the current scroll position is within the section bounds
                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        current = section.getAttribute("id");
                    }
                }
            });

            // Only highlight the nav link that corresponds to the current section
            navLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href").includes(current)) {
                    link.classList.add("active");
                }
            });
        }

        // Special case for the top of the page
        if (window.scrollY < 200) {
            navLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href").includes("header") || link.getAttribute("href") === "#") {
                    link.classList.add("active");
                }
            });
        }
    }
}




// Function to scroll to a section smoothly
function scrollToSection(sectionId) {
    const targetElement = document.getElementById(sectionId);
    if (targetElement) {
        setTimeout(() => {
            window.scrollTo({
                top: targetElement.offsetTop,
                behavior: 'smooth'
            });
        }, 300);
    }
}

// Function to manage label position based on input focus and value
function handleFloatingLabels() {
    document.querySelectorAll('.signup__input').forEach(input => {
        const label = input.nextElementSibling;

        input.addEventListener('focus', () => {
            label.classList.add('move-up');
        });

        input.addEventListener('blur', () => {
            if (input.value === "") {
                label.classList.remove('move-up');
            }
        });

        if (input.value !== "") {
            label.classList.add('move-up');
        }
    });
}

// Function to handle password visibility toggle in signs
function handlePasswordVisibilityToggleforSign() {
    const toggles = document.querySelectorAll('.password-icon');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const input = this.closest('.signup__field').querySelector('.signup__input' );

            if (input && (input.type === 'password' || input.type === 'text')) {
                if (input.type === 'password') {
                    input.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    input.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            }
        });
    });
}


// Function to handle password visibility toggle in forms
function handlePasswordVisibilityToggleforForm() {
    const toggles = document.querySelectorAll('.password-icon');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const input = this.closest('.form-field').querySelector('.form-input');

            if (input && (input.type === 'password' || input.type === 'text')) {
                if (input.type === 'password') {
                    input.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    input.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            }
        });
    });
}


// Initialize the scripts when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    handleAlerts();
    handlePasswordValidation(); 
    smoothScroll();
    highlightActiveSection();
    handleFloatingLabels();
    handlePasswordVisibilityToggleforForm();
    handlePasswordVisibilityToggleforSign();

});