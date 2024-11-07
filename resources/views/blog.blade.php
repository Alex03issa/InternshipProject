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

        @php
            
            $overviewPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'overiew-sec' && $category->title === 'Blog';
                });
            })->sortByDesc('published_at')->first();

            $introPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'introduction-sec' && $category->title === 'Blog';
                });
            })->sortByDesc('published_at')->first();

            $featurePost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'feature-sec' && $category->title === 'Blog';
                });
            })->sortByDesc('published_at')->first();

            $gameplayTipsPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                     return $category->pivot->section === 'download' && $category->title === 'Blog';
                });
            })->sortByDesc('published_at')->first();
           
            $allPostsInactive = !$overviewPost && !$introPost && !$featurePost && !$gameplayTipsPost;
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
           
        <!-- Overview Section -->
        @if($overviewPost && $overviewPost->uploaded_file)
            <section id="overview-sec" class="py-12">
                <img class="mx-auto mt-12 mb-4 max-w-full" src="{{ asset('storage/' . $overviewPost->uploaded_file) }}" alt="{{ $overviewPost->title }}" />
            </section>
        @endif

        <!-- Introduction Section -->
        @if($introPost)
            <section id="introduction-sec" class="pt-4 bg-light">
                <div class="container px-4 sm:px-8 xl:px-32">
                    @if($introPost->body)
                        <p class="mb-4">{!! $introPost->body !!}</p>
                    @elseif($introPost->contentBlocks && $introPost->contentBlocks->isNotEmpty())
                        @foreach($introPost->contentBlocks->sortBy('order')->take(3) as $block)
                            @if($block->type == 'heading')
                                <h2 class="mb-4 text-primary">{!! $block->content !!}</h2>
                            @elseif($block->type == 'paragraph')
                                <p class="mb-4">{!! $block->content !!}</p>
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>
        @endif

        <!-- Feature Highlights Section -->
        @if($featurePost)
            <section id="feature-sec" class="ex-cards-1 py-8 bg-white">
                <div class="container px-4 sm:px-8">
                    @if($featurePost->body)
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="card-title text-secondary">{{ $featurePost->title }}</h3>
                                <p class="card-text">{!! $featurePost->body !!}</p>
                            </div>
                        </div>
                    @elseif($featurePost->contentBlocks && $featurePost->contentBlocks->isNotEmpty())
                        @php
                            $contentBlocks = $featurePost->contentBlocks->sortBy('order')->values(); 
                        @endphp
                        @for ($i = 0; $i < $contentBlocks->count(); $i += 2)
                            <div class="card mb-4">
                                <div class="card-body"> 
                                    @if(isset($contentBlocks[$i]) && $contentBlocks[$i]->type == 'heading')
                                        <h3 class="card-title text-secondary">{!! $contentBlocks[$i]->content !!}</h3>
                                    @endif
                                    @if(isset($contentBlocks[$i + 1]) && $contentBlocks[$i + 1]->type == 'paragraph')
                                        <p class="card-text">{!! $contentBlocks[$i + 1]->content !!}</p>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>
            </section>
        @endif

        <!-- Download Section -->
        @if($gameplayTipsPost)
            <section id="download" class="py-6 bg-light">
                <div class="container px-4 sm:px-8 xl:px-32">

                    @if($gameplayTipsPost)
                        @if($gameplayTipsPost->body)
                            <p class="mb-4">{!! $gameplayTipsPost->body !!}</p>
                            <a class="btn-solid-reg mb-12" href="index.html#download">Download Now</a>
                        @else
                            <h2 class="mb-6 text-primary">{{ $gameplayTipsPost->title }}</h2>

                            @if($gameplayTipsPost->uploaded_file)
                                <img class="mb-12 mx-auto max-w-full" src="{{ asset('storage/' . $gameplayTipsPost->uploaded_file) }}" alt="{{ $gameplayTipsPost->title }}" />
                            @endif

                            @php
                                $paragraphBlocks = $gameplayTipsPost->contentBlocks->where('type', 'paragraph')->sortBy('order');
                            @endphp

                            @foreach($paragraphBlocks->take(2) as $block)
                                <p class="mb-4">{!! $block->content !!}</p>
                            @endforeach

                            <div class="text-box mb-12 p-4 bg-white rounded shadow-sm">
                                @php
                                    $remainingBlocks = $gameplayTipsPost->contentBlocks->sortBy('order')->skip(2); // Skip first two paragraphs
                                @endphp
                                @foreach($remainingBlocks->take(2) as $block)
                                    @if($block->type == 'heading')
                                        <h3 class="mb-2">{!! $block->content !!}</h3>
                                    @elseif($block->type == 'paragraph')
                                        <p class="mb-4">{!! $block->content !!}</p>
                                    @endif
                                @endforeach
                            </div>

                            @foreach($remainingBlocks->skip(2)->take(1) as $block)
                                <p class="mb-6">{!! $block->content !!}</p>
                            @endforeach

                            @php
                                $icons = [
                                'fas fa-trophy text-primary',  
                                'fas fa-globe text-primary',          
                                'fas fa-fingerprint text-primary',  
                                'fas fa-palette text-primary',     
                                'fas fa-sync text-primary', 
                                ];
                                $iconIndex = 0; 
                            @endphp


                            @foreach($gameplayTipsPost->contentBlocks->sortBy('order') as $block)
                                @if($block->type == 'subtitle')
                                    <ul class="list-unstyled mb-6 space-y-2" style="padding-left: 0;">
                                        <li class="flex">
                                            <i class="{{ $icons[$iconIndex % count($icons)] }}"></i>
                                            <div class="flex ml-2">
                                                <strong>{!! $block->content !!}</strong>
                                                @php
                                                    $nextBlock = $gameplayTipsPost->contentBlocks->where('order', $block->order + 1)->first();
                                                @endphp
                                                @if ($nextBlock && $nextBlock->type == 'list')
                                                    {!! $nextBlock->content !!}
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                    @php
                                        $iconIndex++; 
                                    @endphp
                                @endif
                            @endforeach
                            
                            <a class="btn-solid-reg mb-12" href="index.html#download">Download Now</a>
                        @endif
                    @endif
                </div>
            </section>
        @endif

        <!-- Ad Section -->
        @if($ads->where('active', true)->where('ad_platform', 'website')->isNotEmpty())
            <section id="ads-section" class="py-8">
                <div class="container mx-auto text-center">
                    <h2 class="text-2xl font-bold mb-4">Sponsored Ads</h2>

                    <!-- Center the ad container with conditional layout based on ad count -->
                    <div class="@if($ads->where('active', true)->where('ad_platform', 'website')->count() > 2) grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 @else flex justify-center space-x-6 @endif">
                        @foreach($ads->where('active', true)->where('ad_platform', 'website')->take(3) as $ad) <!-- Limit to 3 active ads with platform 'website' -->
                            @if($ad->ad_type == 'custom')
                                <!-- Display Custom Ad -->
                                <div class="ad-item bg-white p-4 rounded-lg shadow-lg inline-block">
                                    @if($ad->ad_image)
                                        <a href="{{ route('ad.click', $ad->id) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $ad->ad_image) }}" alt="{{ $ad->ad_name }}"  class="object-contain rounded-lg mb-4 mx-auto" style="max-width: 100%; height: auto;">
                                        </a>
                                    @endif
                                    <h3 class="text-xl font-semibold mb-2">
                                        <a href="{{ route('ad.click', $ad->id) }}" target="_blank" class="hover:underline">{{ $ad->ad_name }}</a>
                                    </h3>
                                    <p class="mb-2 text-gray-600">{{ $ad->description }}</p> <!-- Display Description -->
                                    <p class="mb-4">Sponsored by {{ $ad->ad_owner }}</p>
                                    <a href="{{ route('ad.click', $ad->id) }}" target="_blank" class="text-indigo-600 hover:underline">Visit Site</a>
                                </div>
                            @elseif($ad->ad_type == 'google')
                                <!-- Display Google Ad -->
                                <div class="google-ad-item mb-6">
                                    {!! $ad->google_ad_code !!}
                                </div>
                            @endif
                        @endforeach
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
        <script>
            fetch("{{ route('ad.view', $ad->id) }}");
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
                            <li> <i class="fas fa-times-circle" style="color: red;"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
</html>