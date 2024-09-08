<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="{{ asset('css/sign.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>
<body>


<form class="signup" action="{{ route('login.submit') }}" method="POST" autocomplete="off">
    @csrf

    <div class="header_signin">
        <a href="{{ route('signup') }}" class="back-button"><i class="fas fa-arrow-left"></i> </a>
        <h1><i class="fas fa-sign-in-alt"></i>Sign In</h1>
    </div>
    
    
    <div class="signup__field">
        <input class="signup__input" type="email" name="email" id="email" autocomplete="email" required />
        <label class="signup__label" for="email">Email</label>
    </div>

    <div class="signup__field">
        <input class="signup__input" type="password" name="password" id="password" autocomplete="current-password" required />
        <label class="signup__label" for="password">Password</label>
    </div>

      <!-- Forgot Password Link -->
    <div class="forgot-password">
        <a href="{{ route('password.request') }}">Forgot Password?</a>
    </div>

    <button type="submit"><i class="fas fa-sign-in-alt"></i>Sign in</button>

    <!-- Google Sign-In Button -->
    <a href="{{ route('google.redirect') }}" class="signup__button--google">
        <i class="fab fa-google"></i>Continue with Google
    </a>

    <!-- Apple ID Button -->
    <a href="{{ route('apple.redirect') }}" class="signup__button--apple">
        <i class="fab fa-apple"></i>Continue with Apple ID
    </a>
</form>

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
                    <li><i class="fas fa-times-circle" style="color: red;"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

</html>
