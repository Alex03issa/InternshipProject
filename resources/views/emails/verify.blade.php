<!DOCTYPE html>
<html>
<head>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." />
        <meta name="author" content="Alexander Issa - Side to Side team" />

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="Side to Side" /> <!-- website name -->
        <meta property="og:site" content="https://yoursite.com" /> <!-- website link -->
        <meta property="og:title" content="Side to Side Game" /> <!-- title shown in the actual shared post -->
        <meta property="og:description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." /> <!-- description shown in the actual shared post -->
        <meta property="og:image" content="images/side-to-side.png" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="https://yoursite.com" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Email Verification</title>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />
        <link href="css/fontawesome-all.css" rel="stylesheet" />
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
     
        
        
        <!-- Favicon  -->
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" />



    
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                padding: 20px;
                background-color: #ffffff;
                max-width: 600px;
                margin: 50px auto;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .logo {
                text-align: center;
                margin-bottom: 20px;
            }
            .logo img {
                max-width: 150px;
            }
            .title {
                font-size: 24px;
                font-weight: bold;
                text-align: center;
                color: #333333;
                margin-bottom: 20px;
            }
            .content {
                font-size: 16px;
                color: #666666;
                margin-bottom: 30px;
                text-align: center;
            }
            .verify-button {
                display: inline-block;
                background:#252c38;
                border: 1px solid #252c38;
                color: white;
                border-radius: 32px;
                font-size: 16px;
                line-height: 0;
                text-decoration: none;
                transition: all 0.2s;
                padding: 15px 25px;
                text-align: center;
                margin: 0 auto;
                display: block;
                
            }
            .verify-button:hover {
                border: 1px solid #252c38;
                background-color: transparent;
                color: #252c38; 
                text-decoration: none;
            }
            .footer {
                font-size: 12px;
                color: #999999;
                text-align: center;
                margin-top: 30px;
            }
        </style>
    </head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <div class="title">
            Welcome to Side to Side
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>Thank you for signing up with Side to Side. Please verify your email address by clicking the button below:</p>
        </div>
        <a href="{{ $verificationUrl }}" class="verify-button">Verify Email</a>
        <div class="footer">
            <p>If you did not sign up for this account, please ignore this email.</p>
            <p>&copy; 2024 Side to Side. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
