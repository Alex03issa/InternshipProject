<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Pavo is a mobile app Tailwind CSS HTML template created to help you present benefits, features and information about mobile apps in order to convince visitors to download them" />
        <meta name="author" content="Alexander Issa - Side to Side team" />

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="" /> <!-- website name -->
        <meta property="og:site" content="" /> <!-- website link -->
        <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
        <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
        <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Blog - Side to Side</title>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />
        <link href="css/fontawesome-all.css" rel="stylesheet" />
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
        <link href="css/swiper.css" rel="stylesheet" />
        <link href="css/magnific-popup.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />

        <!-- Favicon  -->
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" />

    </head>
    <body data-spy="scroll" data-target=".fixed-top">

        <!-- Navigation -->
        <nav class="navbar fixed-top">
            <div class="container sm:px-4 lg:px-8 flex flex-wrap items-center justify-between lg:flex-nowrap">
                <!-- Image Logo -->
                <a class="inline-block mr-4 py-0.5 text-xl whitespace-nowrap hover:no-underline focus:no-underline" href="{{ route('homepage') }}">
                    <img src="images/logo.png" alt="alternative" class="h-8" />
                </a>
                <button class="background-transparent rounded text-xl leading-none hover:no-underline focus:no-underline lg:hidden lg:text-gray-400" type="button" data-toggle="offcanvas">
                    <span class="navbar-toggler-icon inline-block w-8 h-8 align-middle"></span>
                </button>
                <div class="navbar-collapse offcanvas-collapse lg:flex lg:flex-grow lg:items-center" id="navbarsExampleDefault">
                    <ul class="pl-0 mt-3 mb-2 ml-auto flex flex-col list-none lg:mt-0 lg:mb-0 lg:flex-row">
                        <li>
                            <a class="nav-link page-scroll" href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li>
                            <a class="nav-link page-scroll active" href="#blog-header">Blog <span class="sr-only">(current)</span></a>
                        </li>
                        <li>
                            <a class="nav-link page-scroll" href="{{ route('aboutus') }}">About Us</a>
                        </li>
                        

                        @if(Auth::check()) <!-- Check if the user is logged in -->
                            <li>
                                <a class="nav-link page-scroll" href="#download">Download</a>
                            </li>
                            <li>
                            <a class="nav-link page-scroll" href="#contactus">Contact Us</a>
                        </li>
                            <li class="ml-8 flex items-center dropdown">
                                <span class="username-text">
                                    @if(Auth::user()->username == 'default_username')
                                        {{ Auth::user()->name }} 
                                    @else
                                        {{ Auth::user()->username }} 
                                    @endif
                                </span>

                                <a class="ml-2 dropdown-toggle no-underline" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(!empty(Auth::user()->profile_image)) <!-- Check if profile image exists -->
                                        <img src="{{ Auth::user()->profile_image }}" alt="User Image" class="w-8 h-8 rounded-full user-image">
                                    @else
                                        <i class="fas fa-user fa-2x"></i> 
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Profile</a>
                                    <a class="dropdown-item" href="#">Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            
                            <li>
                                <a class="nav-link page-scroll" href="#download">Download</a>
                            </li>
                            <li>
                                <a class="nav-link page-scroll" href="#contactus">Contact Us</a>
                            </li>
                            <li>
                                <a class="nav-link page-scroll" href="{{ route('signup') }}">Sign Up</a>
                            </li>
                        @endif
                    </ul>
                </div> <!-- end of navbar-collapse -->
            </div> <!-- end of container -->
        </nav> <!-- end of navbar -->


        <!-- Header -->
        <section id="blog-header">
            <header class="ex-header bg-gray">
                <div class="container px-4 sm:px-8 xl:px-4">
                    <h1 class="xl:ml-24">Explore Side to Side</h1>
                </div> <!-- end of container -->
            </header> <!-- end of ex-header -->
            <!-- end of header -->
        </section>

        <!-- Overview Section -->
        <section id="overiew-sec" class="py-12">
            <div class="container px-4 sm:px-8">
                <img class="mx-auto mt-12 mb-4 max-w-full" src="images/article-details-large.jpg" alt="alternative" />
            </div> <!-- end of container -->
        </section> <!-- end of overview section -->

        <!-- Introduction Section -->
        <section id="introduction-sec" class="pt-4 bg-light">
            <div class="container px-4 sm:px-8 xl:px-32">
                <h2 class="mb-4 text-primary">Game Overview</h2>
                <p class="mb-4">"Side to Side" is a thrilling mobile game that challenges players to navigate a ball through an endless series of platforms. By swiping left and right, you can jump between platforms and avoid obstacles. The goal? To score as many points as possible while ascending into infinity.</p>
                <p class="mb-12">With its ever-increasing difficulty and engaging mechanics, "Side to Side" is sure to keep players hooked, striving to reach the top of the global leaderboard and unlock exciting rewards along the way.</p>
            </div> <!-- end of container -->
        </section> <!-- end of introduction section -->

        <!-- Feature Highlights Section -->
        <section id="feature-sec" class="ex-cards-1 py-8 bg-white">
            <div class="container px-4 sm:px-8">

                <!-- Feature Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">Customize Your Game</h3>
                        <p class="card-text">Personalize your gaming experience by unlocking new skins for your ball and vibrant backgrounds. Stand out from other players with unique styles that you can earn as rewards by achieving high scores.</p>
                    </div>
                </div> <!-- end of card -->

                <!-- Feature Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">Global Leaderboard</h3>
                        <p class="card-text">Compete with players worldwide. Track your ranking on the global leaderboard, which resets weekly to give everyone a chance to rise to the top. Challenge your friends and become the best in the world!</p>
                    </div>
                </div> <!-- end of card -->

                <!-- Feature Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">Smooth and Responsive Controls</h3>
                        <p class="card-text">Experience smooth, intuitive controls that allow for precise movements and jumps. Perfect your timing and coordination to master the game and achieve the highest scores possible.</p>
                    </div>
                </div> <!-- end of card -->

            </div> <!-- end of container -->
        </section> <!-- end of feature highlights section -->

      <!-- Gameplay Tips Section -->
        <section id="download" class="py-6 bg-light">
            <div class="container px-4 sm:px-8 xl:px-32">
                <h2 class="mb-6 text-primary">Mastering Side to Side</h2>
                <img class="mb-12 mx-auto max-w-full" src="images/article-details-small.jpg" alt="alternative" />
                <p class="mb-4">To excel in "Side to Side," timing is everything. Anticipate platform movements and plan your jumps carefully. The game’s pace increases as you progress, so stay focused and refine your skills with each play.</p>
                <p class="mb-12">Check the global leaderboard regularly to see how you stack up against other players. Every week brings a new opportunity to climb the ranks and showcase your skills!</p>
            </div> <!-- end of container -->

            <div class="container px-4 sm:px-8 xl:px-32">
                <div class="text-box mb-12 p-4 bg-white rounded shadow-sm">
                    <h3 class="mb-2">Stay Competitive and Have Fun</h3>
                    <p class="mb-4">As you climb the leaderboard, you'll face tougher challenges. Use the rewards you’ve unlocked to enhance your gameplay. Each game is a chance to improve and rise to the top!</p>
                </div> <!-- end of text-box -->

                <p class="mb-6">Remember, "Side to Side" is not just about high scores—it's about enjoying the vibrant, dynamic gameplay. With responsive controls and customizable visuals, every game offers a new, exciting experience. Have fun, and may the best player win!</p>

                <!-- Corrected List Section -->
                <ul class="list-unstyled mb-12 space-y-2" style="padding-left: 0;">
                    <li class="flex">
                        <i class="fas fa-trophy text-primary"></i>
                        <div class="flex-1 ml-2">
                            <strong>Unlock New Skins:</strong> Customize your ball with a variety of skins as you progress.
                        </div>
                    </li>
                    <li class="flex">
                        <i class="fas fa-globe text-primary"></i>
                        <div class="flex-1 ml-2">
                            <strong>Compete Globally:</strong> See how you rank against players worldwide.
                        </div>
                    </li>
                    <li class="flex">
                        <i class="fas fa-fingerprint text-primary"></i>
                        <div class="flex-1 ml-2">
                            <strong>Responsive Controls:</strong> Enjoy smooth, intuitive gameplay.
                        </div>
                    </li>
                    <li class="flex">
                        <i class="fas fa-palette text-primary"></i>
                        <div class="flex-1 ml-2">
                            <strong>Vibrant Graphics:</strong> Each game is a visual treat.
                        </div>
                    </li>
                    <li class="flex">
                        <i class="fas fa-sync text-primary"></i>
                        <div class="flex-1 ml-2">
                            <strong>Regular Updates:</strong> New skins, features, and challenges are added regularly.
                        </div>
                    </li>
                </ul>

                <a class="btn-solid-reg mb-12" href="index.html#download">Download Now</a>
            </div> <!-- end of container -->
        </section> <!-- end of download section -->


        <!-- Footer -->
        <section id="contactus"> 
            <div class="footer">
                <div class="container px-4 sm:px-8">
                    <h4 class="mb-8 lg:max-w-3xl lg:mx-auto">For more information about the Side to Side game or to reach the development team, please contact us at <a class="text-indigo-600 hover:text-gray-500" href="mailto:majed.issa62@gmail.com">majed.issa62@gmail.com</a></h4>
                    <div class="social-container">
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-linkedin fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-youtube fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-instagram fa-stack-1x"></i>
                            </a>
                        </span>
                    </div> <!-- end of social-container -->
                </div> <!-- end of container -->
            </div> <!-- end of footer -->

            <!-- Copyright -->
            <div class="copyright">
                <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-3">
                    <ul class="mb-4 list-unstyled p-small">
                        <li class="mb-2"><a class="nav-link page-scroll" href="{{ route('blog') }}">Blog</a></li>
                        <li class="mb-2"><a class="nav-link page-scroll" href="{{ route('terms') }}">Terms & Conditions</a></li>
                        <li class="mb-2"><a class="nav-link page-scroll" href="{{ route('privacy') }}">Privacy Policy</a></li>
                    </ul>
                    <p class="pb-2 p-small statement">Copyright © <a href="#your-link" class="no-underline">Side to Side</a></p>
                </div>
            </div> <!-- end of copyright -->
        </section>

        <!-- Scripts -->
        <script src="js/jquery.min.js"></script> <!-- jQuery for JavaScript plugins -->
        <script src="js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
        <script src="js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
        <script src="js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
        <script src="js/scripts.js"></script> <!-- Custom scripts -->
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
                            <li> <i class="fas fa-times-circle" style="color: red;"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
</html>
