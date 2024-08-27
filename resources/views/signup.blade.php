<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link href="{{ asset('css/signup.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet" />
</head>
<body>

<form class="signup" action="{{ route('signup.submit') }}" method="POST" autocomplete="off">
    @csrf
    <h1><i class="fas fa-user-plus"></i>Sign Up</h1>
    <h2>Already have an account? <a href="{{ route('login') }}">Sign in</a></h2>

    <div class="signup__field">
        <input class="signup__input" type="text" name="username" id="username" required />
        <label class="signup__label" for="username">Username</label>
    </div>

    <div class="signup__field">
        <input class="signup__input" type="email" name="email" id="email" autocomplete="email" required />
        <label class="signup__label" for="email">Email</label>
    </div>

    <div class="signup__field">
        <input class="signup__input" type="password" name="password" id="password" autocomplete="new-password" required />
        <label class="signup__label" for="password">Password</label>
    </div>

    <div class="signup__field">
        <input class="signup__input" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required />
        <label class="signup__label" for="password_confirmation">Confirm Password</label>
    </div>

    <button type="submit"><i class="fas fa-user-plus"></i>Sign up</button>

    <!-- Google Button -->
    <a href="{{ route('google.redirect') }}" class="signup__button--google">
        <i class="fab fa-google"></i>Continue with Google
    </a>

    <!-- Apple ID Button -->
    <a href="{{ route('apple.redirect') }}" class="signup__button--apple">
        <i class="fab fa-apple"></i>Continue with Apple ID
    </a>
</form>

</body>
</html>
