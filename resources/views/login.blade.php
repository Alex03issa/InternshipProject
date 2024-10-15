<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." />
        <meta name="author" content="Alexander Issa - Side to Side team" />

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="Sign In - Side to Side" /> <!-- website name -->
        <meta property="og:site" content="https://yoursite.com" /> <!-- website link -->
        <meta property="og:title" content="Side to Side Game" /> <!-- title shown in the actual shared post -->
        <meta property="og:description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." /> <!-- description shown in the actual shared post -->
        <meta property="og:image" content="images/side-to-side.png" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="https://yoursite.com" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Sign in - Side to Side</title>

        <!-- Styles -->
        <link href="css/fontawesome-all.css" rel="stylesheet" />
        <link href="{{ asset('css/sign.css') }}" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
        
        <!-- Favicon  -->
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" />

    
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
        <span class="toggle-password password-icon" style="cursor: pointer;">
            <i class="fas fa-eye-slash"></i>
        </span>
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

<script src="{{ asset('js/ui_event_handlers.js') }}"></script>

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
