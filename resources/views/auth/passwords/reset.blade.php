<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." />
        <meta name="author" content="Alexander Issa - Side to Side team" />

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="Confirmation Password Reset - Side to Side" /> <!-- website name -->
        <meta property="og:site" content="https://yoursite.com" /> <!-- website link -->
        <meta property="og:title" content="Side to Side Game" /> <!-- title shown in the actual shared post -->
        <meta property="og:description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." /> <!-- description shown in the actual shared post -->
        <meta property="og:image" content="images/side-to-side.png" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="https://yoursite.com" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Confirmation Password Reset - Side to Side</title>

        <!-- Styles -->
        <link href="css/fontawesome-all.css" rel="stylesheet" />
        <link href="{{ asset('css/form-styles.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

        <!-- Favicon  -->
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" />

</head>
<body>
    <div class="form-container">
        <div class="header_signin">
            <a href="{{ route('login') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Reset Password</h1>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-field">
                <input class="form-input" type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                <label class="form-label" for="email">Email Address</label>
            </div>

            <div class="form-field">
                <input class="form-input" type="password" name="password" id="password" required autocomplete="new-password">
                <label class="form-label" for="password">New Password</label>
                <div class="password-strength-container" id="password-strength-container">
                    <p id="strength-message">Weak</p>
                    <ul>
                        <li id="length"><i class="fas fa-times-circle"></i> At least 8 characters</li>
                        <li id="uppercase"><i class="fas fa-times-circle"></i> Contains an uppercase letter</li>
                        <li id="number"><i class="fas fa-times-circle"></i> Contains a number</li>
                        <li id="special"><i class="fas fa-times-circle"></i> Contains a special character</li>
                    </ul>
                </div>
            </div>

            <div class="form-field">
                <input class="form-input" type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <span id="confirm-password-icon" class="password-icon"></span>
            </div>

            <button type="submit">Reset Password</button>
        </form>
    </div>

    <script>
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
            }, 3000); // Adjust time as needed
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
</script>


</body>


 <!-- Display error and messages -->
<div class="alert-container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle" style="color: green;"></i>{{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle" style="color: red;"></i>{{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
               
                @foreach ($errors->all() as $error)
                    <li> <i class="fas fa-times-circle" style="color: red;"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>


</html>
