<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Side to Side is a mobile game where users control a ball by swiping left and right, jumping on platforms that move upwards infinitely." />
        <meta name="author" content="Alexander Issa - Side to Side team" />

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site" content="https://yoursite.com" /> <!-- website link -->
        <meta property="og:site_name" content="Side to Side" />
        <meta property="og:title" content="Terms and Conditions - Side to Side Game" />
        <meta property="og:description" content="Read the terms and conditions governing the use of Side to Side, the mobile game." />
        <meta property="og:image" content="images/side-to-side.png" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="https://yoursite.com" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Terms & Conditions - Side to Side</title>

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
                    <h1 class="xl:ml-24">Terms & Conditions</h1>
                </div> <!-- end of container -->
            </header> <!-- end of ex-header -->
            <!-- end of header -->
        </section>


        <!-- Basic -->
        <section id="maincontent">
            <div class="ex-basic-1 py-12">
                <div class="container mx-auto px-4 sm:px-8 xl:max-w-5xl xl:px-12">
                    <div class="text-box my-12">
                        <p class="p-large mb-4">The "Side to Side" app automatically collects and receives certain information from your device, including activities on our website, platforms, and applications, as well as hardware and software details like your operating system or browser.</p>
                    </div> <!-- end of text-box -->

                    <h2 class="mb-4">1. Information Collected During Visits</h2>
                    <p class="mb-4">Each time you visit the website or use the services, we collect information such as your IP address, browser type, and device. We also gather access times, the page you came from, and the pages you visit within our services.</p>
                    <p class="mb-12">Under no circumstances will "Side to Side" be liable for any direct, indirect, incidental, or consequential damages, including data loss or profit loss arising from the use or inability to use this site.</p>

                    <h2 class="mb-4">2. Use of Content and Materials</h2>
                    <p class="mb-4">Any use of materials from this site is subject to the user assuming all costs for repairs or corrections of equipment or data. "Side to Side" will not be liable for any damages resulting from the use of materials.</p>
                    <p class="mb-6">All content and templates inherit the GNU general public license. You are prohibited from redistributing or reselling our templates or using them on multiple projects without permission.</p>
                    <ul class="list-unstyled mb-6 space-y-2">
                        <li class="flex">
                            <i class="fas fa-square"></i>
                            <div class="flex-1 ml-2"><strong>Redistribution Restrictions</strong>: You are prohibited from reselling our templates, regardless of modification.</div>
                        </li>
                        <li class="flex">
                            <i class="fas fa-square"></i>
                            <div class="flex-1 ml-2"><strong>Client Use</strong>: You may use our templates for client work, but no more than one project at a time.</div>
                        </li>
                    </ul>

                    <h2 class="mb-4">3. Game Rules and Responsibilities</h2>
                    <p class="mb-12">By playing "Side to Side," you agree to abide by the game's rules, including fair play. Exploiting bugs, using cheats, or engaging in inappropriate behavior may result in suspension or account termination.</p>

                    <h2 class="mb-4">4. Virtual Items and Rewards</h2>
                    <p class="mb-4">The game includes virtual items such as ball skins or backgrounds, which cannot be exchanged for cash. We reserve the right to modify or remove virtual items at any time.</p>
                    <p class="mb-12">Points and rewards earned in the game are subject to change, and we reserve the right to modify reward systems without prior notice.</p>

                    <h2 class="mb-4">5. Purchases and Refunds</h2>
                    <p class="mb-6">In-app purchases are available for virtual items. All sales are final, and refunds will only be issued for unauthorized transactions within 14 days of purchase.</p>
                    <ul class="list-unstyled mb-12 space-y-2">
                        <li class="flex">
                            <i class="fas fa-square"></i>
                            <div class="flex-1 ml-2"><strong>In-App Purchases</strong>: All in-app purchases are final, and refunds will not be issued except in cases of fraud.</div>
                        </li>
                        <li class="flex">
                            <i class="fas fa-square"></i>
                            <div class="flex-1 ml-2"><strong>Non-Refundable</strong>: Virtual items cannot be transferred or refunded.</div>
                        </li>
                    </ul>

                    <h2 class="mb-4">6. Updates and Changes</h2>
                    <p class="mb-4">We may update the game, its content, and these terms periodically. By continuing to use the game, you agree to be bound by any changes.</p>

                    <h2 class="mb-4">7. Limitation of Liability</h2>
                    <p class="mb-12">We are not responsible for any damages resulting from the use of "Side to Side," including data loss or service disruptions. Your use of the game is at your own risk.</p>

                    <h2 class="mb-4">8. User Account and Security</h2>
                    <p class="mb-12">It is your responsibility to keep your account credentials secure. You agree not to share your username and password with anyone. If we detect suspicious activity in your account, we may temporarily suspend access for further investigation. You agree to notify us immediately in the event of unauthorized access to your account.</p>

                    <h2 class="mb-4">9. Age Restrictions</h2>
                    <p class="mb-12">"Side to Side" is intended for users who are 13 years of age or older. By using this game, you represent that you meet this age requirement. We do not knowingly collect personal data from users under the age of 13 without parental consent. If we learn that we have inadvertently collected information from a user under 13, we will delete such data promptly.</p>

                    <h2 class="mb-4">10. User Conduct</h2>
                    <p class="mb-12">You agree not to use the "Side to Side" app to engage in activities that are illegal, harmful, or disruptive. This includes, but is not limited to, hacking, cheating, harassment, and the exploitation of in-game bugs or vulnerabilities. Any user found violating these rules may have their account suspended or permanently banned.</p>

                    <h2 class="mb-4">11. Intellectual Property</h2>
                    <p class="mb-12">All intellectual property related to "Side to Side," including game design, graphics, and software, belongs to the company. You agree not to reproduce, distribute, or modify any part of the game without express permission. Unauthorized use of intellectual property may result in legal action.</p>

                    <h2 class="mb-4">12. Data Collection and Privacy</h2>
                    <p class="mb-12">We collect user data to improve the game experience and analyze performance. By playing the game, you consent to the collection and use of your data as outlined in our Privacy Policy. You have the right to request the deletion of your data at any time by contacting us.</p>

                    <h2 class="mb-4">13. Suspension and Termination of Services</h2>
                    <p class="mb-12">We reserve the right to suspend or terminate your access to the game at any time, with or without notice, for any reason, including breach of these terms. In the event of termination, you will lose access to your account and any associated rewards or in-game items.</p>

                    <h2 class="mb-4">14. Refund Policy</h2>
                    <p class="mb-12">All purchases made through the app, including in-app purchases, are non-refundable. Exceptions may be made in cases of fraud, unauthorized transactions, or technical issues directly caused by the app.</p>

                    <h2 class="mb-4">15. Liability Disclaimer</h2>
                    <p class="mb-12">We do not guarantee that "Side to Side" will be free of errors or uninterrupted. The game is provided "as is," and we are not responsible for any issues that may arise during gameplay, including data loss, service outages, or system failures.</p>

                    <h2 class="mb-4">16. Force Majeure</h2>
                    <p class="mb-12">We shall not be liable for any delay or failure to perform resulting from causes outside our reasonable control, including but not limited to natural disasters, acts of war, strikes, and technical failures.</p>

                    <h2 class="mb-4">17. Changes to Terms and Conditions</h2>
                    <p class="mb-12">We reserve the right to modify these terms at any time. Changes will be posted on our website, and your continued use of the app constitutes acceptance of the updated terms.</p>

                    <h2 class="mb-4">18. Governing Law</h2>
                    <p class="mb-12">These terms shall be governed and construed in accordance with the laws of [Your Country]. Any disputes arising from these terms or the use of the app shall be resolved in the courts of [Your Jurisdiction].</p>

                    <h2 class="mb-4">19. Contact Us</h2>
                    <p>If you have any questions or concerns regarding these Terms & Conditions, feel free to contact us at <a href="mailto:majed.issa62@gmail.com">majed.issa62@gmail.com</a>.</p>

                        
                </div> <!-- end of container -->
            </div> <!-- end of ex-basic-1 -->
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
