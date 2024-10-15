<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." />
        <meta name="author" content="Alexander Issa - Side to Side team" />

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="Password Reset Link - Side to Side" /> <!-- website name -->
        <meta property="og:site" content="https://yoursite.com" /> <!-- website link -->
        <meta property="og:title" content="Side to Side Game" /> <!-- title shown in the actual shared post -->
        <meta property="og:description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." /> <!-- description shown in the actual shared post -->
        <meta property="og:image" content="images/side-to-side.png" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="https://yoursite.com" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Password Reset Link - Side to Side</title>

        <!-- Styles -->
        <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/form-styles.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

        <!-- Favicon  -->
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" />

    
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
                    <li>  <i class="fas fa-times-circle" style="color: red;"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

</html>
