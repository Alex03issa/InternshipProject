<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." />
        <meta name="author" content="Alexander Issa - Side to Side team" />

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="Side to Side" />
        <meta property="og:site" content="https://yoursite.com" />
        <meta property="og:title" content="Side to Side Game - Privacy Policy" />
        <meta property="og:description" content="Privacy policy for the Side to Side mobile game, covering data collection, usage, and protection." />
        <meta property="og:image" content="images/side-to-side.png" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="https://yoursite.com" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Privacy Policy - Side to Side</title>

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
                            <a class="nav-link page-scroll" href="{{ route('blog') }}">Blog</a>
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
                                <span class="ml-2 text-gray-800">{{ Auth::user()->username }}</span> <!-- Display the username -->
                                <a class="ml-2 dropdown-toggle no-underline" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Auth::user()->profile_image }}" alt="User Image" class="w-8 h-8 rounded-full">
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
        <section id="header">
            <header class="ex-header bg-gray">
                <div class="container mx-auto px-4 sm:px-8 xl:max-w-6xl xl:px-4">
                    <h1 class="xl:ml-24">Privacy Policy</h1>
                </div> <!-- end of container -->
            </header> <!-- end of ex-header -->
            <!-- end of header -->
        </section>


         <!-- Main Content -->
         <section id="maincontent">
            <div class="ex-basic-1 py-12">
                <div class="container px-4 sm:px-8 xl:max-w-5xl xl:px-12">

                    <!-- Section 1: Overview -->
                    <h2 class="mt-12 mb-4">1. Overview</h2>
                    <p class="mb-12">At "Side to Side," we value your privacy and are committed to protecting the information you provide when using our game or website. This Privacy Policy outlines what data we collect, how we use it, and the measures we take to safeguard your personal information.</p>

                    <!-- Section 2: Data We Collect -->
                    <h2 class="mb-4">2. Data We Collect</h2>
                    <p class="mb-12">We collect the following types of information from users:</p>

                    <h3 class="mb-2">2.1. Information You Provide</h3>
                    <p class="mb-12">When you sign up for an account, participate in in-game purchases, or contact us, we may collect personal information such as your name, email address, billing information, and game preferences.</p>

                    <h3 class="mb-2">2.2. Automatically Collected Information</h3>
                    <p class="mb-12">We automatically collect certain data when you play "Side to Side" or visit our website, including your IP address, device information, browser type, and interactions with the game (e.g., scores, rewards, skins selected).</p>

                    <!-- Section 3: How We Use Your Data -->
                    <h2 class="mb-4">3. How We Use Your Data</h2>
                    <ul class="list-unstyled mb-6 space-y-2">
                        <li class="flex">
                            <i class="fas fa-chevron-right"></i>
                            <div class="flex-1 ml-2"><strong>To Enhance Gameplay:</strong> We use your data to improve game features, provide personalized experiences, and track your progress.</div>
                        </li>
                        <li class="flex">
                            <i class="fas fa-chevron-right"></i>
                            <div class="flex-1 ml-2"><strong>To Process Transactions:</strong> We collect payment information to facilitate in-app purchases and manage your in-game rewards.</div>
                        </li>
                        <li class="flex">
                            <i class="fas fa-chevron-right"></i>
                            <div class="flex-1 ml-2"><strong>To Improve Our Services:</strong> We use aggregated data to analyze how users interact with the game and website, helping us make improvements.</div>
                        </li>
                        <li class="flex">
                            <i class="fas fa-chevron-right"></i>
                            <div class="flex-1 ml-2"><strong>For Security:</strong> We monitor user activity to detect potential fraud or unauthorized activity and to maintain the security of our services.</div>
                        </li>
                    </ul>

                    <!-- Section 4: Data Sharing -->
                    <h2 class="mb-4">4. Data Sharing</h2>
                    <p class="mb-12">We do not sell your personal information to third parties. However, we may share data with trusted partners in the following situations:</p>

                    <h3 class="mb-2">4.1. Payment Processing</h3>
                    <p class="mb-12">We work with third-party payment processors to handle transactions securely. These providers adhere to strict data protection standards to safeguard your payment information.</p>

                    <h3 class="mb-2">4.2. Compliance with Laws</h3>
                    <p class="mb-12">We may disclose your information if required by law or if we believe such action is necessary to protect our rights or the rights of others.</p>

                    <!-- Section 5: Cookies and Tracking Technologies -->
                    <h2 class="mb-4">5. Cookies and Tracking Technologies</h2>
                    <p class="mb-12">We use cookies and similar technologies to improve your experience on our website. Cookies help us understand user behavior and track game performance, allowing us to enhance gameplay and customize in-game features.</p>

                    <!-- Section 6: Data Security -->
                    <h2 class="mb-4">6. Data Security</h2>
                    <p class="mb-12">We take appropriate technical and organizational measures to protect your data from unauthorized access, alteration, or deletion. However, no online service is completely secure, and we cannot guarantee absolute data protection.</p>

                    <!-- Section 7: Your Rights -->
                    <h2 class="mb-4">7. Your Rights</h2>
                    <p class="mb-12">You have the right to access, correct, or delete your personal information. If you wish to exercise any of these rights, please contact us at <a href="mailto:majed.issa62@gmail.com">majed.issa62@gmail.com</a>.</p>

                    <!-- Section 8: Changes to This Privacy Policy -->
                    <h2 class="mb-4">8. Changes to This Privacy Policy</h2>
                    <p class="mb-12">We may update this Privacy Policy from time to time to reflect changes in our practices or applicable laws. We encourage you to review this page periodically for the latest information on our privacy practices.</p>

                    <!-- Section 9: Contact Us -->
                    <h2 class="mb-4">9. Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy or our data handling practices, please contact us at <a href="mailto:majed.issa62@gmail.com">majed.issa62@gmail.com</a>.</p>

                </div> <!-- end of container -->
            </div>
            <!-- end of ex-basic-1 -->
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

        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const sections = document.querySelectorAll("section");
                const navLinks = document.querySelectorAll(".nav-link");

                window.addEventListener("scroll", () => {
                    let current = "";
                    const scrollPosition = window.pageYOffset + window.innerHeight / 2; // Middle of the viewport

                    // Find the current section
                    sections.forEach(section => {
                        const sectionTop = section.offsetTop;
                        const sectionHeight = section.clientHeight;

                        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                            current = section.getAttribute("id");
                        }
                    });

                    // Only highlight the nav link if there's a matching section
                    navLinks.forEach(link => {
                        link.classList.remove("active");
                        if (link.getAttribute("href").includes(current)) {
                            link.classList.add("active");
                        }
                    });
                });
            });
        </script>


    
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
    </body>
</html>
