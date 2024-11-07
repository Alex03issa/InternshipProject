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
                                <a class="nav-link page-scroll" href="{{ route('download') }}">Download</a>
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
                                <a class="nav-link page-scroll" href="{{ route('download') }}">Download</a>
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



        <section id="header">
            <header class="ex-header bg-gray">
                <div class="container mx-auto px-4 sm:px-8 xl:max-w-6xl xl:px-4">
                    <h1 class="xl:ml-24">{{ $category->title }}</h1> 
                </div>
            </header>
        </section>

        @php
            
            $mainHeaderPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'mainheader' && $category->title === 'Terms & Conditions';
                });
            })->sortByDesc('published_at')->first();

            $mainContentPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'maincontent' && $category->title === 'Terms & Conditions';
                });
            })->sortByDesc('published_at')->first();

           
            $allPostsInactive = !$mainHeaderPost && !$mainContentPost;
        @endphp

        @if($allPostsInactive)
            <section id="maintenance-message">
                <div class="ex-basic-1 py-12">
                    <div class="container mx-auto px-4 sm:px-8 xl:max-w-5xl xl:px-12">
                        <div class="text-box my-12">
                            <p class="p-large mb-4 text-center">Sorry, we are currently under maintenance. The content will be back soon. Stay tuned!</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Main Header Section -->
        @if($mainHeaderPost)
            <section id="mainheader">
                <div class="ex-basic-1 py-12">
                    <div class="container mx-auto px-4 sm:px-8 xl:max-w-5xl xl:px-12">
                        <div class="text-box my-12">
                            <p class="p-large mb-4">{!! $mainHeaderPost->body !!}</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Main Content Section -->
        @if($mainContentPost)
            <section id="maincontent">
                <div class="ex-basic-1 py-12">
                    <div class="container mx-auto px-4 sm:px-8 xl:max-w-5xl xl:px-12">
                        @if($mainContentPost->body)
                            <p class="mb-4">{!! $mainContentPost->body !!}</p>
                        @else
                            @foreach($mainContentPost->contentBlocks->sortBy('order') as $block)
                                @if($block->type == 'heading')
                                    <h2 class="mb-4">{!! $block->content !!}</h2>
                                @elseif($block->type == 'paragraph')
                                    <p class="mb-4">{!! $block->content !!}</p>
                                @elseif($block->type == 'subtitle')
                                    @php
                                        $nextBlock = $mainContentPost->contentBlocks->where('order', $block->order + 1)->first();
                                    @endphp
                                    <ul class="list-unstyled mb-6">
                                        <li class="flex">
                                            <i class="fas fa-square"></i>
                                            <div class="flex ml-2">
                                                <strong>{!! $block->content !!}</strong>
                                                @if ($nextBlock && $nextBlock->type == 'list')
                                                    {!! $nextBlock->content !!}
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                @elseif($block->type == 'link')
                                    <a href="mailto:{!! $block->content !!}">{!! $block->content !!}</a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </section>
        @endif


        <!-- Contact Us Section -->
        <section id="contactus">
            <div class="footer">
                <div class="container px-4 sm:px-8">
                    @if($contactUsPost && $contactUsPost->body)
                        <p class="mb-4">{!! $contactUsPost->body !!}</p>
                    @elseif($contactUsPost)
                        @foreach($contactUsPost->contentBlocks->sortBy('order') as $block)
                            @if($block->type == 'heading')
                                <h4 class="mb-8 lg:max-w-3xl lg:mx-auto">{!! $block->content !!}</h4>
                            @elseif($block->type == 'paragraph')
                                <p class="mb-8">{!! $block->content !!}</p>
                            @elseif($block->type == 'link')
                                <a class="text-indigo-600 hover:text-gray-500" href="mailto:{!! $block->content !!}">{!! $block->content !!}</a>
                            @endif
                        @endforeach
                    @else
                        <h4 class="mb-8 lg:max-w-3xl lg:mx-auto">
                            For more information about the Side to Side game or to reach the development team, please contact us at 
                            <a class="text-indigo-600 hover:text-gray-500" href="mailto:majed.issa62@gmail.com">majed.issa62@gmail.com</a>
                        </h4>
                    @endif
                

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
