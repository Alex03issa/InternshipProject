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
        <title>Side to Side</title>

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
                            <a class="nav-link page-scroll active" href="#home-header">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li>
                            <a class="nav-link page-scroll" href="#blog">Blog</a>
                        </li>
                        <li>
                            <a class="nav-link page-scroll" href="#aboutus">About Us</a>
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
        <section id="home-header">
            <header class="header py-28 text-center md:pt-36 lg:text-left xl:pt-44 xl:pb-32">
                <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-2 lg:gap-x-8">
                    <div class="mb-16 lg:mt-32 xl:mt-40 xl:mr-12">
                        <h1 class="h1-large mb-5">Side to Side - The Ultimate Platform Jumping Game</h1>
                        <p class="p-large mb-8">Control the ball, jump on platforms, and keep scoring in this endless, fun-filled game!</p>
                        <a class="btn-solid-lg" href="#your-link"><i class="fab fa-apple"></i>Download</a>
                        <a class="btn-solid-lg secondary" href="#your-link"><i class="fab fa-google-play"></i>Download</a>
                    </div>
                    <div class="xl:text-right">
                        <img class="inline" src="images/header smartphone.webp" alt="alternative" />
                    </div>
                </div> <!-- end of container -->
            </header> <!-- end of header -->
        </section>

        <!-- Introduction -->
        <section id="introduction">
            <div class="pt-4 pb-14 text-center">
                <div class="container px-4 sm:px-8 xl:px-4">
                    <p class="mb-4 text-gray-800 text-3xl leading-10 lg:max-w-5xl lg:mx-auto">Side to Side is an addictive mobile game that will keep you on your toes as you control a ball jumping on endlessly moving platforms. Can you keep up?</p>
                </div> <!-- end of container -->
            </div>
            <!-- end of introduction -->

            <!-- About the Game -->
            <div id="about-application" class="pt-16 pb-12">
                <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-12 lg:gap-x-12">
                    <div class="lg:col-span-7">
                        <div class="mb-16 lg:mb-0 xl:mt-16">
                            <h2 class="mb-6">About the Side to Side Game</h2>
                            <p class="mb-4">Side to Side is an exciting mobile game that challenges players to control a ball by swiping left and right. The objective is to jump from platform to platform as they move upwards infinitely. The game tests your reflexes and timing as you try to score as many points as possible by staying on the platforms without falling.</p>
                            <p class="mb-4">With its intuitive controls and endless gameplay, Side to Side provides an engaging and addictive experience for players of all ages. Keep jumping, score higher, and see how far you can go!</p>
                        </div>
                    </div>
                    <div class="lg:col-span-5">
                        <div class="xl:ml-14">
                            <img class="inline" src="images/detail1.webp" alt="alternative" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <section id="features">
            <div class="cards-1">
                <div class="container px-4 sm:px-8 xl:px-4">
                    <div class="features-layout">
                        
                        <!-- Card 1 (Left) -->
                        <div class="card" id="card-left">
                            <div class="card-image-feature text-center mb-4">
                                <div class="icon-circle">
                                    <i class="fas fa-trophy fa-3x" style="color: #eb427e;"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Rewards System</h5>
                                <p class="mb-4">Earn rewards for reaching milestones! For every 100 points scored, players will receive exciting rewards, such as new skins, power-ups, and more!</p>
                            </div>
                        </div>

                        <!-- Middle Cards (Stacked) -->
                        <div class="middle-cards">
                            <div class="card" id="card-middle-1">
                                <div class="card-image-feature text-center mb-4">
                                    <div class="icon-circle">
                                        <i class="fas fa-paint-brush fa-3x" style="color: #594cda;"></i>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title">Customizable Ball and Background</h5>
                                    <p class="mb-4">Personalize your gaming experience by changing the color and skin of the ball, as well as the background. Show off your unique style as you jump to the top!</p>
                                </div>
                            </div>

                            <div class="card" id="card-middle-2">
                                <div class="card-image-feature text-center mb-4">
                                    <div class="icon-circle">
                                        <i class="fas fa-globe fa-3x" style="color: #594cda;"></i>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title">Global Leaderboard</h5>
                                    <p class="mb-4">Compete with players from around the world! Climb the global leaderboard by scoring high and see where you stand against the best players.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4 (Right) -->
                        <div class="card" id="card-right">
                            <div class="card-image-feature text-center mb-4">
                                <div class="icon-circle">
                                    <i class="fas fa-gamepad fa-3x" style="color: #eb427e;"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Smooth Controls</h5>
                                <p class="mb-4">Experience smooth and responsive controls designed for easy gameplay. Swipe left and right effortlessly as you jump from platform to platform.</p>
                            </div>
                        </div>

                    </div> <!-- end of features-layout -->
                </div> <!-- end of container -->
            </div> <!-- end of cards-1 -->
        </section>



        <!-- Details Section -->
        <section id="detail">
            <div  class="pt-12 pb-16 lg:pt-16">
                <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-12 lg:gap-x-12">
                    <div class="lg:col-span-6">
                        <div class="mb-16 lg:mb-0 xl:mt-16">
                            <h2 class="mb-6">Unlock New Skins and Power-ups</h2>
                            <p class="mb-4">As you reach higher scores, you'll unlock new skins for your ball and special power-ups that will give you an edge in the game. Customize your gameplay and showcase your achievements.</p>
                            <p class="mb-4">Challenge yourself to reach new heights and unlock all the skins and power-ups available in the game!</p>
                        </div>
                    </div>
                    <div class="lg:col-span-6">
                        <div class="xl:ml-14">
                            <img class="inline" src="images/detail3.webp" alt="alternative" />
                        </div>
                    </div>
                </div> <!-- end of container -->
            </div>
            <!-- end of details -->
        </section>

       <!-- <section id="ad">
            <div class="ad-container">
                 //Google AdSense Ad 
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2477819131946252" crossorigin="anonymous"></script>
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-2477819131946252"
                    data-ad-slot="7525814060"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </section> -->

        
            <!-- Details 2 -->
        <section id="blog">    
            <div class="py-24">
                <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-12 lg:gap-x-12">
                    <div class="lg:col-span-6">
                        <div class="mb-12 lg:mb-0 xl:mr-14">
                            <img class="inline" src="images/detail2.webp" alt="alternative" />
                        </div>
                    </div> <!-- end of col -->
                    <div class="lg:col-span-5">
                        <div class="xl:mt-12">
                            <h2 class="mb-6">Customize Your Experience</h2>
                            <ul class="list mb-7 space-y-2">
                                <li class="flex">
                                    <i class="fas fa-chevron-right"></i>
                                    <div>Change the color and skin of your ball</div>
                                </li>
                                <li class="flex">
                                    <i class="fas fa-chevron-right"></i>
                                    <div>Select different backgrounds to match your style</div>
                                </li>
                                <li class="flex">
                                    <i class="fas fa-chevron-right"></i>
                                    <div>Use power-ups to boost your score</div>
                                </li>
                            </ul>
                            <a class="btn-outline-reg" href="{{ route('blog') }}">Details</a>
                        </div>
                    </div> <!-- end of col -->
                </div> <!-- end of container -->
            </div>
            <!-- end of details 2 -->
        </section>

        <!-- Statistics -->
        <section id="counter-statisque">
            <div class="counter">
                <div class="container px-4 sm:px-8">
                    
                    <!-- Counter -->
                    <div id="counter">
                        <div class="cell">
                            <div class="counter-value number-count" data-count="531">1</div>
                            <p class="counter-info">Number of Visits</p>
                        </div>
                        <div class="cell">
                            <div class="counter-value number-count" data-count="385">1</div>
                            <p class="counter-info">Total Downloads</p>
                        </div>
                        <div class="cell">
                            <div class="counter-value number-count" data-count="159">1</div>
                            <p class="counter-info"> New Users This Month</p>
                        </div>
                        <div class="cell">
                            <div class="counter-value number-count" data-count="127">1</div>
                            <p class="counter-info">Rewards Unlocked</p>
                        </div>
                    </div> <!-- end of counter -->

                </div> <!-- end of container -->
            </div> <!-- end of counter -->
            <!-- end of statistics -->
        </section>


        <!-- Testimonials -->
        <section id="aboutus">
            <div  class="slider-1 py-32 bg-gray">
                <div class="container px-4 sm:px-8">
                    <h2 class="mb-12 text-center lg:max-w-xl lg:mx-auto">Meet the Side to Side Development Team</h2>

                    <!-- Card Slider -->
                    <div class="slider-container">
                        <div class="swiper-container card-slider">
                            <div class="swiper-wrapper">
                                
                                <!-- Slide 1 -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="images/article-details-large.jpg" alt="alternative" />
                                        <div class="card-body">
                                            <h4 class="card-title">Wadee Issa</h4>
                                            <p class="card-text">Mobile Developer & Project Management</p>
                                            <p class="italic mb-3">"Side to Side has been a rewarding project. The smooth gameplay and endless fun keep our users engaged."</p>
                                        </div>
                                    </div>
                                </div> <!-- end of swiper-slide -->
                                
                                <!-- Slide 2 -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="images/testimonial-2.jpg" alt="alternative" />
                                        <div class="card-body">
                                            <h4 class="card-title">Alexander Issa</h4>
                                            <p class="card-text">Mobile Developer & Web Developer</p>
                                            <p class="italic mb-3">"Creating a seamless and responsive interface was key to making Side to Side a hit among players."</p>
                                        </div>
                                    </div>
                                </div> <!-- end of swiper-slide -->

                                <!-- Slide 3 -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="images/pricing-background.jpg" alt="alternative" />
                                        <div class="card-body">
                                            <h4 class="card-title">Nassim Cheric</h4>
                                            <p class="card-text">Quality Assurance</p>
                                            <p class="italic mb-3">"Ensuring a bug-free experience for our users has been my top priority. Side to Side delivers quality at every level."</p>
                                        </div>
                                    </div>
                                </div> <!-- end of swiper-slide -->

                            </div> <!-- end of swiper-wrapper -->

                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- end of add arrows -->

                        </div> <!-- end of swiper-container -->
                    </div> <!-- end of slider-container -->
                </div> <!-- end of container -->
            </div> <!-- end of slider-1 -->
            <!-- end of testimonials -->
        </section>

        
        <!-- Conclusion -->
        <section id="download">
            <div class="basic-5">
                <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-2">
                    <div class="mb-16 lg:mb-0">
                        <img src="images/conclusionimage.webp" alt="alternative" />
                    </div>
                    <div class="lg:mt-24 xl:mt-44 xl:ml-12">
                        <p class="mb-9 text-gray-800 text-3xl leading-10">Mobile games don’t get much better than Side to Side. Customize your ball, climb the leaderboard, and unlock rewards! Download now and start your adventure!</p>
                        <a class="btn-solid-lg" href="#your-link"><i class="fab fa-apple"></i>Download</a>
                        <a class="btn-solid-lg secondary" href="#your-link"><i class="fab fa-google-play"></i>Download</a>
                    </div>
                </div> <!-- end of container -->
            </div> <!-- end of basic-5 -->
            <!-- end of conclusion -->
        </section>

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
                        <li class="mb-2"><a class="nav-link page-scroll" href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                        <li class="mb-2"><a class="nav-link page-scroll" href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                    </ul>
                    <p class="pb-2 p-small statement">Copyright © <a href="{{ route('homepage') }}" class="underline">Side to Side</a> (Alexander Issa)</p>
                </div>
            </div> <!-- end of copyright -->
        </section>

        <!-- Scripts -->
        <script src="js/jquery.min.js"></script> <!-- jQuery for JavaScript plugins -->
        <script src="js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
        <script src="js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
        <script src="js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
        <script src="js/scripts.js"></script> <!-- Custom scripts -->
        <script src="js/ui_event_handlers.js"></script>


      
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
