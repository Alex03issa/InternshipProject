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
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                    @if(auth()->user()->user_type === 'admin')
                                        <a class="dropdown-item" href="{{ route('filament.admin.pages.dashboard') }}">Admin Dashboard</a>
                                    @elseif(auth()->user()->user_type === 'user')
                                        <a class="dropdown-item" href="{{ route('filament.user.pages.user-dashboard') }}">Dashboard</a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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


        @php
            $homeHeaderPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'home-header';
                });
            })->sortByDesc('published_at')->first();

            $introductionPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'introduction';
                });
            })->sortByDesc('published_at')->first();

            $aboutApplicationPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'about-application';
                });
            })->sortByDesc('published_at')->first();

            $featuresPosts = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'features';
                });
            })->sortByDesc('published_at')->first();

            $detailPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'detail';
                });
            })->sortByDesc('published_at')->first();

            $blogPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'blog';
                });
            })->sortByDesc('published_at')->first();


            $downloadPost = $posts->where('active', true)->filter(function($post) {
                return $post->categories->contains(function($category) {
                    return $category->pivot->section === 'download';
                });
            })->sortByDesc('published_at')->first();


            $allPostsInactive = !$homeHeaderPost && !$introductionPost && !$featuresPosts && !$detailPost && !$blogPost && !$downloadPost;
        @endphp

        @if($allPostsInactive)
            <!-- Maintenance Message -->
            <section id="maintenance-message">
                <div class="ex-basic-1 py-12" style="margin: 200px;">
                    <div class="container mx-auto px-4 sm:px-8 xl:max-w-5xl xl:px-12">
                        <div class="text-box my-12">
                            <p class="p-large mb-4 text-center">Sorry, we are currently under maintenance. The content will be back soon. Stay tuned!</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        
        <!-- Home Header Section -->
        @if($homeHeaderPost)
            <section id="home-header">
                <header class="header py-28 text-center md:pt-36 lg:text-left xl:pt-44 xl:pb-32">
                    <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-2 lg:gap-x-8">
                        <div class="mb-16 lg:mt-32 xl:mt-40 xl:mr-12">
                            @if($homeHeaderPost->body)
                                <p class="p-large mb-8">{!! $homeHeaderPost->body !!}</p>
                            @endif
                            @foreach($homeHeaderPost->contentBlocks->sortBy('order') as $block)
                                @if($block->type == 'heading')
                                    <h1 class="h1-large mb-5">{!! $block->content !!}</h1>
                                @elseif($block->type == 'paragraph')
                                    <p class="p-large mb-8">{!! $block->content !!}</p>
                                @elseif($block->type == 'subtitle')
                                    @php
                                        $nextBlock = $homeHeaderPost->contentBlocks->where('order', $block->order + 1)->first();
                                    @endphp
                                    <ul class="list-unstyled mb-6">
                                        <li class="flex">
                                            <i class="fas fa-chevron-right"></i>
                                            <div class="flex ml-2">
                                                <strong>{!! $block->content !!}</strong>
                                                @if ($nextBlock && $nextBlock->type == 'list')
                                                    {!! $nextBlock->content !!}
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                @elseif($block->type == 'list')
                                    <ul class="list mb-7 space-y-2">
                                        <li class="flex">
                                            <i class="fas fa-chevron-right"></i>
                                            <div>{!! $block->content !!}</div>
                                        </li>
                                    </ul>
                                @elseif($block->type == 'link')
                                    <a href="{!! $block->content !!}" class="text-primary hover:underline">{{ $block->content }}</a>
                                @endif
                            @endforeach
                            <a class="btn-solid-lg" href="https://www.apple.com/app-store/"><i class="fab fa-apple"></i>Download</a>
                            <a class="btn-solid-lg secondary" href="https://play.google.com/store/games?hl=en"><i class="fab fa-google-play"></i>Download</a>
                        </div>
                        <div class="xl:text-right">
                            <img class="inline" src="{{ asset('storage/' . $homeHeaderPost->uploaded_file) }}" alt="{{ $homeHeaderPost->title }}" />
                        </div>
                    </div>
                </header>
            </section>
        @endif

        <!-- Introduction Section -->
        @if($introductionPost)
            <section id="introduction">
                <div class="pt-4 pb-14 text-center">
                    <div class="container px-4 sm:px-8 xl:px-4">
                        @if($introductionPost->body)
                            <p class="mb-4 text-gray-800 text-3xl leading-10 lg:max-w-5xl lg:mx-auto">{{ $introductionPost->body }}</p>
                        @endif
                        @foreach($introductionPost->contentBlocks->sortBy('order') as $block)
                            @if($block->type == 'heading')
                                <h2 class="mb-6">{!! $block->content !!}</h2>
                            @elseif($block->type == 'paragraph')
                                <p class="mb-4 text-gray-800 text-3xl leading-10 lg:max-w-5xl lg:mx-auto">{!! $block->content !!}</p>
                            @elseif($block->type == 'subtitle')
                                @php
                                    $nextBlock = $introductionPost->contentBlocks->where('order', $block->order + 1)->first();
                                @endphp
                                <ul class="list-unstyled mb-6">
                                    <li class="flex">
                                        <i class="fas fa-chevron-right"></i>
                                        <div class="flex ml-2">
                                            <strong>{!! $block->content !!}</strong>
                                            @if ($nextBlock && $nextBlock->type == 'list')
                                                {!! $nextBlock->content !!}
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            @elseif($block->type == 'list')
                                <ul class="list mb-7 space-y-2">
                                    <li class="flex">
                                        <i class="fas fa-chevron-right"></i>
                                        <div>{!! $block->content !!}</div>
                                    </li>
                                </ul>
                            @elseif($block->type == 'link')
                                <a href="{!! $block->content !!}" class="text-primary hover:underline">{{ $block->content }}</a>
                            @endif
                        @endforeach
                    </div> <!-- end of container -->
                </div>
            </section>
        @endif

        <!-- About the Game Section -->
        @if($aboutApplicationPost)
            <section id="about-application">
                <div class="pt-16 pb-12">
                    <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-12 lg:gap-x-12">
                        <div class="lg:col-span-7">
                            <div class="mb-16 lg:mb-0 xl:mt-16">
                                @if($aboutApplicationPost->body)
                                    <p class="mb-4">{!! $aboutApplicationPost->body !!}</p>
                                @endif
                                @foreach($aboutApplicationPost->contentBlocks->sortBy('order') as $block)
                                    @if($block->type == 'heading')
                                        <h2 class="mb-6">{!! $block->content !!}</h2>
                                    @elseif($block->type == 'paragraph')
                                        <p class="mb-4">{!! $block->content !!}</p>
                                    @elseif($block->type == 'subtitle')
                                        @php
                                            $nextBlock = $aboutApplicationPost->contentBlocks->where('order', $block->order + 1)->first();
                                        @endphp
                                        <ul class="list-unstyled mb-6">
                                            <li class="flex">
                                                <i class="fas fa-chevron-right"></i>
                                                <div class="flex ml-2">
                                                    <strong>{!! $block->content !!}</strong>
                                                    @if ($nextBlock && $nextBlock->type == 'list')
                                                        {!! $nextBlock->content !!}
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="lg:col-span-5">
                            <div class="xl:ml-14">
                                <img class="inline" src="{{ asset('storage/' . $aboutApplicationPost->uploaded_file) }}" alt="{{ $aboutApplicationPost->title }}"  />
                            </div>
                        </div>
                    </div> <!-- end of container -->
                </div>
            </section>
        @endif


        <!-- Features Section -->
        @if($featuresPosts)
            <section id="features">
                <div class="cards-1">
                    <div class="container px-4 sm:px-8 xl:px-4">
                        <div class="features-layout">

                            @foreach($featuresPosts->contentBlocks as $index => $block)
                                @php
                                
                                    if ($index < 2) {
                                        $cardId = 'card-left';
                                        $iconClass = 'fas fa-trophy fa-3x';
                                        $iconColor = '#eb427e';
                                    } elseif ($index < 4) {
                                        $cardId = 'card-middle-1';
                                        $iconClass = 'fas fa-paint-brush fa-3x';
                                        $iconColor = '#594cda';
                                    } elseif ($index < 6) {
                                        $cardId = 'card-middle-2';
                                        $iconClass = 'fas fa-globe fa-3x';
                                        $iconColor = '#594cda';
                                    } else {
                                        $cardId = 'card-right';
                                        $iconClass = 'fas fa-gamepad fa-3x';
                                        $iconColor = '#eb427e';
                                    }
                                @endphp

                                <!-- Start middle-cards wrapper for middle cards (index > 2) -->
                                @if($index == 2)
                                    <div class="middle-cards">
                                @endif

                                <!-- Card Structure with Title and Description -->
                                @if($index % 2 == 0)
                                    <div class="card" id="{{ $cardId }}">
                                        <div class="card-image-feature text-center mb-4">
                                            <div class="icon-circle">
                                                <i class="{{ $iconClass }}" style="color: {{ $iconColor }};"></i>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{!! $block->content ?? 'Default Title' !!}</h5>
                                @else
                                            <p class="mb-4">{!! $block->content ?? 'Default Description' !!}</p>
                                        </div> <!-- Close card-body and card div here -->
                                    </div>
                                @endif

                                
                                @if($index == 5)
                                    </div> <!-- end of middle-cards -->
                                @endif

                            @endforeach

                        </div> <!-- end of features-layout -->
                    </div> <!-- end of container -->
                </div> <!-- end of cards-1 -->
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
                                        <div class="image-container flex-grow mb-4">
                                            @if($ad->ad_url)
                                                <a href="{{ route('trackClick', ['adId' => $ad->id]) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $ad->ad_image) }}" alt="{{ $ad->ad_name }}" class="object-contain w-full h-auto max-h-64 mx-auto rounded-lg">
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $ad->ad_image) }}" alt="{{ $ad->ad_name }}" class="object-contain w-full h-auto max-h-64 mx-auto rounded-lg">
                                            @endif
                                        </div>
                                    @endif
                                    <div class="text-container mt-auto">
                                        <h3 class="text-xl font-semibold mb-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                            {{ $ad->ad_name }}
                                        </h3>
                                        <p class="mb-2 text-gray-600 whitespace-nowrap overflow-hidden text-ellipsis">
                                            Sponsored by {{ $ad->ad_owner }}
                                        </p>
                                        @if($ad->ad_url)
                                            <a href="{{ route('trackClick', ['adId' => $ad->id]) }}" target="_blank" class="text-indigo-600 hover:underline whitespace-nowrap">Visit Site</a>
                                        @endif
                                    </div>
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


        <!-- Detail Section -->
        @if($detailPost)
            <section id="detail">
                <div class="pt-12 pb-16 lg:pt-16">
                    <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-12 lg:gap-x-12">
                        <div class="lg:col-span-6">
                            <div class="mb-16 lg:mb-0 xl:mt-16">
                                @if($detailPost->body)
                                    <p class="mb-4">{!! $detailPost->body !!}</p>
                                @endif
                                @foreach($detailPost->contentBlocks->sortBy('order') as $block)
                                    @if($block->type == 'heading')
                                        <h2 class="mb-6">{!! $block->content !!}</h2>
                                    @elseif($block->type == 'paragraph')
                                        <p class="mb-4">{!! $block->content !!}</p>
                                    @elseif($block->type == 'subtitle')
                                        @php
                                            $nextBlock = $detailPost->contentBlocks->where('order', $block->order + 1)->first();
                                        @endphp
                                        <ul class="list-unstyled mb-6">
                                            <li class="flex">
                                                <i class="fas fa-chevron-right"></i>
                                                <div class="flex ml-2">
                                                    <strong>{!! $block->content !!}</strong>
                                                    @if ($nextBlock && $nextBlock->type == 'list')
                                                        {!! $nextBlock->content !!}
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="lg:col-span-6">
                            <div class="xl:ml-14">
                                <img class="inline" src="{{ asset('storage/' . $detailPost->uploaded_file) }}" alt="{{ $detailPost->title }}"  />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!-- Blog Section -->
        @if($blogPost)
            <section id="blog">
                <div class="py-24">
                    <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-12 lg:gap-x-12">
                        <div class="lg:col-span-6">
                            <div class="mb-12 lg:mb-0 xl:mr-14">
                                <img class="inline" src="{{ asset('storage/' . $blogPost->uploaded_file) }}" alt="{{ $blogPost->title }}" />
                            </div>
                        </div>
                        <div class="lg:col-span-5">
                            <div class="xl:mt-12">
                                @if($blogPost->body)
                                    <p class="mb-4">{!! $blogPost->body !!}</p>
                                @endif
                                @foreach($blogPost->contentBlocks->sortBy('order') as $block)
                                    @if($block->type == 'heading')
                                        <h2 class="mb-6">{!! $block->content !!}</h2>
                                    @elseif($block->type == 'paragraph')
                                        <p class="mb-4">{!! $block->content !!}</p>
                                    @elseif($block->type == 'subtitle')
                                        @php
                                            $nextBlock = $blogPost->contentBlocks->where('order', $block->order + 1)->first();
                                        @endphp
                                        <ul class="list-unstyled mb-6">
                                            <li class="flex">
                                                <i class="fas fa-chevron-right"></i>
                                                <div class="flex ml-2">
                                                    <strong>{!! $block->content !!}</strong>
                                                    @if ($nextBlock && $nextBlock->type == 'list')
                                                        {!! $nextBlock->content !!}
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    @elseif($block->type == 'list')
                                        <ul class="list mb-7 space-y-2">
                                            <li class="flex">
                                                <i class="fas fa-chevron-right"></i>
                                                <div>{!! $block->content !!}</div>
                                            </li>
                                        </ul>
                                    @elseif($block->type == 'link')
                                        <a href="{!! $block->content !!}" class="text-primary hover:underline">{{ $block->content }}</a>
                                    @endif
                                @endforeach
                                <a class="btn-outline-reg" href="{{ route('blog') }}">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Statistics -->
        @if (!$allPostsInactive)
        <section id="counter-statisque">
            <div class="counter">
                <div class="container px-4 sm:px-8">
                    
                    <!-- Counter -->
                    <div id="counter">
                        <div class="cell">
                            <div class="counter-value number-count" data-count="{{ $siteStatistics->total_visits ?? 0 }}">0</div>
                            <p class="counter-info">Total Visits</p>
                        </div>
                        <div class="cell">
                            <span class="counter-value" data-count="{{ $siteStatistics->daily_visits ?? 0 }}">0</span>
                            <p class="counter-info">Daily Visits</p>
                        </div>
                        <div class="cell">
                            <div class="counter-value number-count" data-count="0">0</div>
                            <p class="counter-info">Total Downloads</p>
                        </div>
                        <div class="cell">
                            <div class="counter-value number-count" data-count="{{ $siteStatistics->total_users_registered ?? 0 }}">0</div>
                            <p class="counter-info">Total Users</p>
                        </div>
                        <div class="cell">
                            <div class="counter-value number-count" data-count="{{ $siteStatistics->monthly_users_registered ?? 0 }}">0</div>
                            <p class="counter-info">New Users This Month</p>
                        </div>
                        
                    </div> <!-- end of counter -->

                </div> <!-- end of container -->
            </div> <!-- end of counter -->
            <!-- end of statistics -->
        </section>
        @endif


        <!-- About Us Section -->
        <section id="aboutus">
            <div class="slider-1 py-32 bg-gray">
                <div class="container px-4 sm:px-8">
                    <h2 class="mb-12 text-center lg:max-w-xl lg:mx-auto">Meet the Side to Side Development Team</h2>

                    <!-- Card Slider -->
                    <div class="slider-container">
                        <div class="swiper-container card-slider">
                            <div class="swiper-wrapper">
                                
                                <!-- Loop through team members only if there are multiple entries -->
                                @if($teamMembers->count() > 1)
                                    @foreach($teamMembers as $member)
                                        <div class="swiper-slide">
                                            <div class="card">
                                                <img class="card-image" src="{{ asset('storage/' . $member->image_url ?? 'images/default-team-image.jpg') }}" alt="{{ $member->name }}" />
                                                <div class="card-body">
                                                    <h4 class="card-title">{{ $member->name }}</h4>
                                                    <p class="card-text">{{ $member->position }}</p>
                                                    <p class="italic mb-3">"{{ $member->quote }}"</p>
                                                </div>
                                            </div>
                                        </div> <!-- end of swiper-slide -->
                                    @endforeach
                                @else
                                    <!-- Display single team member without looping -->
                                    <div class="swiper-slide">
                                        <div class="card">
                                            <img class="card-image" src="{{ asset('storage/' . $teamMembers->first()->image_url ?? 'images/default-team-image.jpg') }}" alt="{{ $teamMembers->first()->name }}" />
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $teamMembers->first()->name }}</h4>
                                                <p class="card-text">{{ $teamMembers->first()->position }}</p>
                                                <p class="italic mb-3">"{{ $teamMembers->first()->quote }}"</p>
                                            </div>
                                        </div>
                                    </div> <!-- end of swiper-slide -->
                                @endif

                            </div> <!-- end of swiper-wrapper -->

                            <!-- Conditionally add navigation arrows if there is more than one team member -->
                            @if($teamMembers->count() > 1)
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            @endif
                            <!-- end of add arrows -->

                        </div> <!-- end of swiper-container -->
                    </div> <!-- end of slider-container -->
                </div> <!-- end of container -->
            </div> <!-- end of slider-1 -->
        </section>



        <!-- Download Section -->
        @if($downloadPost)
            <section id="download">
                <div class="basic-5">
                    <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-2">
                        <div class="mb-16 lg:mb-0">
                            <img src="{{ asset('storage/' . $downloadPost->uploaded_file) }}" alt="{{ $downloadPost->title }}" />
                        </div>
                        <div class="lg:mt-24 xl:mt-44 xl:ml-12">
                            @if($downloadPost->body)
                                <p class="mb-9 text-gray-800 text-3xl leading-10">{{ $downloadPost->body }}</p>
                            @endif
                            @foreach($downloadPost->contentBlocks->sortBy('order') as $block)
                                @if($block->type == 'heading')
                                    <h2 class="mb-6">{!! $block->content !!}</h2>
                                @elseif($block->type == 'paragraph')
                                    <p class="mb-4">{!! $block->content !!}</p>
                                @elseif($block->type == 'subtitle')
                                    @php
                                        $nextBlock = $downloadPost->contentBlocks->where('order', $block->order + 1)->first();
                                    @endphp
                                    <ul class="list-unstyled mb-6">
                                        <li class="flex">
                                            <i class="fas fa-chevron-right"></i>
                                            <div class="flex ml-2">
                                                <strong>{!! $block->content !!}</strong>
                                                @if ($nextBlock && $nextBlock->type == 'list')
                                                    {!! $nextBlock->content !!}
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                @endif
                            @endforeach
                            <a class="btn-solid-lg" href="https://www.apple.com/app-store/"><i class="fab fa-apple"></i>Download</a>
                            <a class="btn-solid-lg secondary" href="https://play.google.com/store/games?hl=en"><i class="fab fa-google-play"></i>Download</a>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!-- Footer -->
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
                            <a href="https://www.facebook.com/">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="https://www.linkedin.com/">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-linkedin fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="https://www.youtube.com/">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-youtube fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="https://www.instagram.com/">
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
        <script>
            var totalMembers = {{ $teamMembers->count() }};
        </script>
        <script src="js/jquery.min.js"></script> <!-- jQuery for JavaScript plugins -->
        <script src="js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
        <script src="js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
        <script src="js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
        <script src="js/scripts.js"></script> <!-- Custom scripts -->
        <script src="js/ui_event_handlers.js"></script>
        <script src="js/click_tracker.js"></script>
        



      
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
