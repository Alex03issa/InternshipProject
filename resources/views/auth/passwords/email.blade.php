<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="{{ asset('css/form-styles.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="form-container">
        <div class="header_signin">
            <a href="{{ route('login') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Forgot Password</h1>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-field">
                <input class="form-input" type="email" name="email" id="email" required autocomplete="email">
                <label class="form-label" for="email">Email Address</label>
            </div>

            <button type="submit">Send Password Reset Link</button>

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
                    <li>  <i class="fas fa-times-circle" style="color: red;"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

</html>
