<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EZXHTKL8RP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-EZXHTKL8RP');
    </script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <? header('Content-type: text/html; charset=utf-8'); ?>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!! !empty($title) ? $title : 'PingJob | Empowering the job seeker' !!}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @stack('css')
    @yield('assets')

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5dd2618dd96992700fc7f0d7/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TZVH8P5');
    </script>
    <!-- End Google Tag Manager -->

    <style>
        .pj-footer{
            width: inherit !important;
        }
    </style>

</head>
@php
$categories = \App\Models\Category::orderBy('job_count', 'desc')
->where('job_count', '>=', 1)->get();
$total_state_job = DB::select("SELECT jobs.state_id,jobs.state_name, COUNT(*) AS numberOfSales FROM jobs JOIN states ON states.id = jobs.state_id GROUP BY jobs.state_id,jobs.state_name ORDER BY COUNT(*) DESC limit 15");
$total_city_jobe = DB::select("SELECT jobs.city_id,jobs.city_name, COUNT(*) AS numberOfcities FROM jobs JOIN cities ON cities.id = jobs.city_id GROUP BY jobs.city_id,jobs.city_name ORDER BY COUNT(*) DESC limit 15");
@endphp

<body class="{{request()->routeIs('home') ? ' home ' : ''}} {{request()->routeIs('job_view') ? ' job-view-page ' : ''}}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel {{request()->routeIs('home') ? 'transparent-navbar' : ''}}">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h2><img src="{{ asset('assets/images/logo.png') }}"></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <li class="nav-item">
                            <a class="nav-link btn btn-success text-white" href="{{route('post_new_job')}}"><i class="la la-save"></i>{{__('app.post_new_job')}} </a>
                        </li>


                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="la la-sign-in"></i> {{ __('app.login') }}</a>
                        </li>
                        <li class="nav-item">
                            @if (Route::has('new_register'))
                            <a class="nav-link" href="{{ route('new_register') }}"><i class="la la-user-plus"></i> {{ __('app.register') }}</a>
                            @endif
                        </li>
                        @else


                        <a class="nav-link btn btn-dark  text-white ml-lg-2" s href="{{route('dashboard')}}"><i class="la la-dashboard"></i>{{__('app.dashboard')}} </a>



                        <li class="nav-item dropdown">



                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="la la-user"></i> {{ Auth::user()->name }}
                                <span class="badge badge-warning"><i class="la la-briefcase"></i>{{auth()->user()->premium_jobs_balance}}</span>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">



                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="main-container">
            @yield('content')
        </div>

        {{-- footer --}}
        <footer class="pj-footer">
            <div id="main-footer" class="main-footer py-3 pb-5">
                <nav style="overflow:hidden;">
                    @php
                    $total = count($categories);
                    @endphp
                    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="width:max-content;">
                        <a class="nav-item nav-link active" id="category-1-nav" data-toggle="tab" href="#category-1" role="tab" data-analytics-track="click" data-analytics-key="seoTabClick" data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors" aria-controls="category-1" aria-selected="false">Categories
                        </a>
                        @if ($total > 30)
                        <a class="nav-item nav-link" id="category-2-nav" data-toggle="tab" href="#category-2" role="tab" data-analytics-track="click" data-analytics-key="seoTabClick" data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors" aria-controls="category-2" aria-selected="false">More
                        </a>
                        @endif
                        @if ($total > 60)
                        <a class="nav-item nav-link" id="category-2-nav" data-toggle="tab" href="#category-2" role="tab" data-analytics-track="click" data-analytics-key="seoTabClick" data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors" aria-controls="category-2" aria-selected="false">More
                        </a>
                        @endif
                        @if ($total > 90)
                        <a class="nav-item nav-link" id="category-4-nav" data-toggle="tab" href="#category-4" role="tab" data-analytics-track="click" data-analytics-key="seoTabClick" data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors" aria-controls="category-4" aria-selected="false">More
                        </a>
                        @endif
                        <a class="nav-item nav-link" id="top-city-state-nav" data-toggle="tab" href="#top-city-state" role="tab" data-analytics-track="click" data-analytics-key="seoTabClick" data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Clients" aria-controls="top-city-state" aria-selected="true">State / City
                        </a>
                    </div>
                </nav>
                <div class="row">
                    <div class="col-lg-9 col-md-6">
                        <div class="tab-content mt-4" id="nav-tabContent" data-an-category="seoTabContent-Top Clients">

                            <div class="tab-pane fade unauth-job-list active show" id="category-1" role="tabpanel" aria-labelledby="category-1-nav" data-an-category="seoTabContent-Top Clients">
                                <div class="row">
                                    @php
                                    $total = count($categories);
                                    if ($total > 30) {
                                    $per = round(30 / 3);
                                    } else {
                                    $per = round($total / 3);
                                    }
                                    @endphp
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 0; $i < $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = $per; $i < $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = $per + $per; $i < $per + $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade unauth-job-list" id="category-2" role="tabpanel" aria-labelledby="category-2-nav" data-an-category="seoTabContent-Top Clients">
                                @if (count($categories) > 30)
                                <div class="row">
                                    @php
                                    $total = count($categories);
                                    $newTotal = $total - 30;

                                    if ($newTotal > 30) {
                                    $per = 10;
                                    } else {
                                    $per = round($newTotal / 3);
                                    }
                                    @endphp
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">

                                            @for ($i = 30; $i < 30 + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 30 + $per; $i < 30 + $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 30 + $per + $per; $i < 30 + $per + $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade unauth-job-list" id="category-3" role="tabpanel" aria-labelledby="category-3-nav" data-an-category="seoTabContent-Top Clients">
                                @if (count($categories) > 60)
                                <div class="row">
                                    @php
                                    $total = count($categories);
                                    $newTotal = $total - 60;

                                    if ($newTotal > 60) {
                                    $per = 10;
                                    } else {
                                    $per = round($newTotal / 3);
                                    }
                                    @endphp
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">

                                            @for ($i = 60; $i < 60 + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 60 + $per; $i < 60 + $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 60 + $per + $per; $i < 60 + $per + $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade unauth-job-list" id="category-4" role="tabpanel" aria-labelledby="category-4-nav" data-an-category="seoTabContent-Top Clients">
                                @if (count($categories) > 90)
                                <div class="row">
                                    @php
                                    $total = count($categories);
                                    $newTotal = $total - 90;

                                    if ($newTotal > 90) {
                                    $per = 10;
                                    } else {
                                    $per = round($newTotal / 3);
                                    }
                                    @endphp
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">

                                            @for ($i = 90; $i < 90 + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 90 + $per; $i < 90 + $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 90 + $per + $per; $i < 90 + $per + $per + $per; $i++) <li>
                                                <a href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                    {{ $categories[$i]->category_name }}
                                                    <span class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade unauth-job-list" id="top-city-state" role="tabpanel" aria-labelledby="top-city-state-nav" data-an-category="seoTabContent-Top Clients">
                                <div class="row">
                                    @php
                                    $total = count($total_state_job);
                                    @endphp
                                    <div class="col-lg-4 col-md-6">
                                        <div class="footer-logo-wrap mt-2">
                                            <h4 class="mb-3">Jobs by States</h4>
                                        </div>
                                        @if (count($total_state_job))
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = 0; $i < $total; $i++) <li>
                                                <a href="{{ route('jobs_by_state_or_city', $total_state_job[$i]->state_name) }}" id="jobapplytxt">
                                                    {{ preg_replace('/[0-9\@\#\.\;]+/', '', $total_state_job[$i]->state_name) }}
                                                    <span class="text-muted">({{ $total_state_job[$i]->numberOfSales }})</span>
                                                </a>
                                                </li>
                                                @endfor
                                        </ul>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="footer-logo-wrap mt-2">
                                            <h4 class="mb-3">Jobs by City</h4>
                                        </div>
                                        @if (count($total_city_jobe))
                                        <ul class="list-unstyled footer-links-homepage">
                                            @foreach ($total_city_jobe as $t_city)
                                            <li>
                                                <a href="{{ route('jobs_by_state_or_city', str_replace(' ', ' ', $t_city->city_name)) }}" id="jobapplytxt">
                                                    {{ preg_replace('/[0-9\@\#\.\;]+/', '', $t_city->city_name) }}
                                                    <span class="text-muted">({{ $t_city->numberOfcities }})</span>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3 col-md-6 mt-4">
                        {{-- web stats --}}
                        <div class="footer-menu-wrap  mt-2">
                            <h4 class="mb-3">Website stats</h4>
                            <?php
                            $clients = config('clients');
                            $vendors = config('vendors');
                            $jobs = config('jobs');
                            $contacts = config('contacts');
                            $reviews = config('reviews');
                            $job_applications = config('job_applications');
                            ?>
                            <ul class="list-unstyled">
                                <li style="color: #38c172;"><a>@lang('app.clients')({{ $clients->count() }})</a>
                                </li>
                                <li style="color: #38c172;">@lang('app.approve_vendor')({{ $vendors->count() }})</li>
                                <li style="color: #38c172;">@lang('app.jobs')({{ $jobs->count() }})</li>
                                <li style="color: #38c172;">@lang('app.approve_contacts')({{ $contacts->count() }})</li>
                                <li style="color: #38c172;">@lang('app.approve_review')({{ 777 + $reviews->count() }})</li>
                                <li style="color: #38c172;">
                                    @lang('app.resumes')({{ 3906 + $job_applications->count() }})</li>
                            </ul>

                        </div>
                        {{-- web stats --}}
                        {{-- pages --}}
                        <div class="footer-logo-wrap mt-2">
                            <h4 class="mb-3">PingJob</h4>
                        </div>
                        <div class="footer-menu-wrap">
                            <ul class="list-unstyled footer-links-homepage">
                                <?php
                                $show_in_footer_menu = config('footer_menu_pages');
                                ?>
                                @if ($show_in_footer_menu->count() > 0)
                                @foreach ($show_in_footer_menu as $page)
                                <li><a href="{{ route('single_page', $page->slug) }}">{{ $page->title }}
                                    </a></li>
                                @endforeach
                                @endif
                                <li><a href="{{ route('contact_us') }}">@lang('app.contact_us')</a> </li>
                                <li><a href="{{ route('help_view') }}">@lang('app.help')</a> </li>
                            </ul>
                        </div>
                        {{-- pages end --}}
                        {{-- social buttons --}}
                        <div class="text-center my-4">
                            <ul class="list-unstyled mb-0 mediaLinks">
                                <li>
                                    <button onclick="location.href='https://www.facebook.com/pingjobsearch/';" type="button" class="btn btn-social-icon btn-outline-facebook"><i class="fab fa-facebook"></i></button>
                                </li>
                                <li>
                                    <button onclick="location.href='https://www.instagram.com/pingjobsearch/';" type="button" class="btn btn-social-icon btn-outline-instagram"><i class="fab fa-instagram"></i></button>
                                </li>
                                <li>
                                    <button onclick="location.href='https://twitter.com/pingjobsearch';" type="button" class="btn btn-social-icon btn-outline-twitter"><i class="fab fa-twitter"></i></button>
                                </li>
                                <li>
                                    <button onclick="location.href='https://www.linkedin.com/company/ping-job';" type="button" class="btn btn-social-icon btn-outline-linkedin"><i class="fab fa-linkedin"></i></button>
                                </li>
                                <li>
                                    <a href="https://wa.me/+15109361066" target="_blank" type="button" class="btn btn-social-icon btn-outline-success" style='justify-content: center;display: flex;align-items: center;border-width: 0;'><i class="fab fa-whatsapp"></i></a>
                                </li>
                            </ul>

                        </div>
                        {{-- social buttons end --}}
                        {{-- register and social login --}}
                        <ul class="list-unstyled footer-links-homepage">

                            <!-- Authentication Links -->
                            @auth
                            @if (Auth::user()->is_admin())
                            <li class="nav-item postjob-button">
                                <a class="btn btn-outline-success " href="{{ route('client_add_view') }}">{{ __('app.register_client') }} </a>
                            </li>
                            @else
                            <li class="nav-item postjob-button">
                                <a class="btn btn-outline-success " href="{{ route('register_employer') }}">{{ __('app.register_client') }} </a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item postjob-button">
                                <a class="btn btn-outline-success " href="{{ route('register_employer') }}">{{ __('app.register_client') }} </a>
                            </li>
                            <li class="nav-item postjob-button">
                                <a class="btn btn-outline-primary " href="https://social.pingjob.com/" target="_blank">{{ __('app.social_login') }}</a>
                            </li>
                            @endauth
                            <li class="nav-item postjob-button">
                                <a class="btn btn-outline-success " href="https://www.pingjob.com/pricing">{{ __('app.price') }} </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright-text-wrap">
                <p class="m-2 text-center">{!! get_text_tpl(get_option('copyright_text')) !!}</p>
            </div>

        </footer>
    </div>


    <!-- Scripts -->
    @yield('page-js')
    <script src="{{ asset('assets/js/main.js') }}"></script>


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146678787-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-146678787-1');
    </script>

    <script data-ad-client="ca-pub-8984168971674670" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>


    <script>
        $(document).ready(function() {

            $('#applyJobModal').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget);

                var job_id = button.data('jobid');
                var modal = $(this);

                modal.find('.modal-body #job_id').val(job_id);
            })

            $('#addContactModal').on('show.bs.modal', function(event) {
                var a = $(event.relatedTarget)
                var cat_id = a.data('catid')
                var modal = $(this)
                modal.find('.modal-body #cat_id').val(cat_id);
            })


        });
    </script>

    <script type="text/javascript" class="init">
        $('#example').dataTable({
            "ordering": false,
            responsive: true
        });


        $('#example1').dataTable({
            "ordering": false,
            responsive: true
        });
    </script>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TZVH8P5" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @stack('js')
</body>

</html>