@php
    use App\Helper\Functions;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PingJob | Empowering the job seeker</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146678787-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-146678787-1');
    </script>


    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '{your-app-id}',
                cookie: true,
                xfbml: true,
                version: '{api-version}'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>


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


    <!-- Zoho Analytics -->
    <script src="https://cdn.pagesense.io/js/pingjobinc/129e50549beb4b799b6446daea4d8016.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <!-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5309331350958816"
        crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./assets/css/style.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @media screen and (max-width : 768px) {
            table.topClientTab {
                line-height: 21px;
            }

            table.topVendor {
                line-height: 21px;
            }
        }

        @media screen and (max-width : 1024px) {
            table.topClientTab {
                line-height: 30px;
            }

            table.topVendor {
                line-height: 25px;
            }
        }

        @media screen and (max-width : 1098px) {
            table.topClientTab {
                line-height: 29px;
            }

            table.topVendor {
                line-height: 24px;
            }
        }

        @media screen and (max-width : 1050px) {
            table.topClientTab {
                line-height: 23px;
            }

            table.topVendor {
                line-height: 18px;
            }
        }

        @media screen and (max-width : 1226px) {
            table.topClientTab {
                line-height: 19px;
            }

            table.topVendor {
                line-height: 14px;
            }
        }

        @media screen and (max-width : 1342px) {
            table.topClientTab {
                line-height: 15px;
            }

            table.topVendor {
                line-height: 14px;
            }
        }

        @media screen and (max-width : 1360px) {
            table.topClientTab {
                line-height: 12px;
            }

            table.topVendor {
                line-height: 14px;
            }
        }

        @media screen and (max-width : 1440px) {
            table.topClientTab {
                line-height: 12px;
            }

            table.topVendor {
                line-height: 14px;
            }
        }
    </style>
</head>

<body style="margin:0px;padding:0px;">
    {{-- top nav --}}
    <section id="top-nav" class="mainTopHeader">
        <nav
            class="navbar navbar-expand-md navbar-light navbar-laravel {{ request()->routeIs('home') ? 'transparent-navbar' : '' }}">
            <div class="headerContent">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h2>
                        <img src="{{ asset('assets/images/logo.png') }}" />
                        {{-- <img src="{{ asset('assets/images/LOGO-FINAL-PNG.png') }}" /> --}}
                    </h2>
                </a>
                <div class="headerList header-text" style="margin-left: 20px;">
                    <p class="navbar-find-heading">Find only Client Jobs, Fast.</h2>
                    <p class="navbar-find-heading-subtitle">Search by skills. View Vendors & Job history.
                        One-click apply.
                    <p>
                </div>
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
            </div>
            <!-- Right Side Of Navbar -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto topnav-right">
                    <li class="nav-item postjob-button">
                        <a class="nav-link btn btn-theme text-white" href="{{ route('post_new_job') }}"><i
                                class="la la-save"></i>{{ __('app.post_new_job') }} </a>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="la la-sign-in"></i>
                                {{ __('app.login') }}</a>
                        </li>
                        <li class="nav-item">
                            @if (Route::has('new_register'))
                                <a class="nav-link" href="{{ route('new_register') }}"><i class="la la-user-plus"></i>
                                    {{ __('app.register') }}</a>
                            @endif
                        </li>
                    @else
                        <a class="nav-link btn btn-dark  text-white ml-lg-2 dashboard_button_dark"
                            href="{{ route('dashboard') }}"><i class="la la-dashboard"></i>{{ __('app.dashboard') }}
                        </a>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="la la-user"></i> {{ Auth::user()->name }}
                                <span class="badge badge-warning"><i
                                        class="la la-briefcase"></i>{{ auth()->user()->premium_jobs_balance }}</span>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">



                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
            <!-- Right Side Of Navbar end -->

        </nav>
    </section>
    {{-- top nav end --}}
    <div class="container-fluid mt-4">
        @yield('content')
    </div>
    <!-- container-fluid -->

    {{-- footer --}}
    <footer class="pj-footer">
        <div id="main-footer" class="main-footer py-3 pb-5">
            <nav style="overflow:hidden;">
                @php
                    $total = count($categories);
                @endphp
                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="width:max-content;">
                    <a class="nav-item nav-link active" id="category-1-nav" data-toggle="tab" href="#category-1"
                        role="tab" data-analytics-track="click" data-analytics-key="seoTabClick"
                        data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors"
                        aria-controls="category-1" aria-selected="false">Categories
                    </a>
                    @if ($total > 30)
                        <a class="nav-item nav-link" id="category-2-nav" data-toggle="tab" href="#category-2"
                            role="tab" data-analytics-track="click" data-analytics-key="seoTabClick"
                            data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors"
                            aria-controls="category-2" aria-selected="false">More
                        </a>
                    @endif
                    @if ($total > 60)
                        <a class="nav-item nav-link" id="category-2-nav" data-toggle="tab" href="#category-2"
                            role="tab" data-analytics-track="click" data-analytics-key="seoTabClick"
                            data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors"
                            aria-controls="category-2" aria-selected="false">More
                        </a>
                    @endif
                    @if ($total > 90)
                        <a class="nav-item nav-link" id="category-4-nav" data-toggle="tab" href="#category-4"
                            role="tab" data-analytics-track="click" data-analytics-key="seoTabClick"
                            data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors"
                            aria-controls="category-4" aria-selected="false">More
                        </a>
                    @endif
                    <a class="nav-item nav-link" id="top-city-state-nav" data-toggle="tab" href="#top-city-state"
                        role="tab" data-analytics-track="click" data-analytics-key="seoTabClick"
                        data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Clients"
                        aria-controls="top-city-state" aria-selected="true">State / City
                    </a>
                </div>
            </nav>
            <div class="row">
                <div class="col-lg-9 col-md-6">
                    <div class="tab-content mt-4" id="nav-tabContent" data-an-category="seoTabContent-Top Clients">

                        <div class="tab-pane fade unauth-job-list active show" id="category-1" role="tabpanel"
                            aria-labelledby="category-1-nav" data-an-category="seoTabContent-Top Clients">
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
                                            @for ($i = 0; $i < $per; $i++)
                                                <li>
                                                    <a
                                                        href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                        {{ $categories[$i]->category_name }}
                                                        <span
                                                            class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = $per; $i < $per + $per; $i++)
                                                <li>
                                                    <a
                                                        href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                        {{ $categories[$i]->category_name }}
                                                        <span
                                                            class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    @if ($categories->count())
                                        <ul class="list-unstyled footer-links-homepage">
                                            @for ($i = $per + $per; $i < $per + $per + $per; $i++)
                                                <li>
                                                    <a
                                                        href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                        {{ $categories[$i]->category_name }}
                                                        <span
                                                            class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade unauth-job-list" id="category-2" role="tabpanel"
                            aria-labelledby="category-2-nav" data-an-category="seoTabContent-Top Clients">
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

                                                @for ($i = 30; $i < 30 + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                            <ul class="list-unstyled footer-links-homepage">
                                                @for ($i = 30 + $per; $i < 30 + $per + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                            <ul class="list-unstyled footer-links-homepage">
                                                @for ($i = 30 + $per + $per; $i < 30 + $per + $per + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade unauth-job-list" id="category-3" role="tabpanel"
                            aria-labelledby="category-3-nav" data-an-category="seoTabContent-Top Clients">
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

                                                @for ($i = 60; $i < 60 + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                            <ul class="list-unstyled footer-links-homepage">
                                                @for ($i = 60 + $per; $i < 60 + $per + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                            <ul class="list-unstyled footer-links-homepage">
                                                @for ($i = 60 + $per + $per; $i < 60 + $per + $per + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade unauth-job-list" id="category-4" role="tabpanel"
                            aria-labelledby="category-4-nav" data-an-category="seoTabContent-Top Clients">
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

                                                @for ($i = 90; $i < 90 + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                            <ul class="list-unstyled footer-links-homepage">
                                                @for ($i = 90 + $per; $i < 90 + $per + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        @if ($categories->count())
                                            <ul class="list-unstyled footer-links-homepage">
                                                @for ($i = 90 + $per + $per; $i < 90 + $per + $per + $per; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ route('jobs_listing', ['category' => $categories[$i]->id]) }}">
                                                            {{ $categories[$i]->category_name }}
                                                            <span
                                                                class="text-muted">({{ $categories[$i]->job_count }})</span>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade unauth-job-list" id="top-city-state" role="tabpanel"
                            aria-labelledby="top-city-state-nav" data-an-category="seoTabContent-Top Clients">
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
                                            @for ($i = 0; $i < $total; $i++)
                                                <li>
                                                    <a href="{{ route('jobs_by_state_or_city', $total_state_job[$i]->state_name) }}"
                                                        id="jobapplytxt">
                                                        {{ preg_replace('/[0-9\@\#\.\;]+/', '', $total_state_job[$i]->state_name) }}
                                                        <span
                                                            class="text-muted">({{ $total_state_job[$i]->numberOfSales }})</span>
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
                                                    <a href="{{ route('jobs_by_state_or_city', str_replace(' ', ' ', $t_city->city_name)) }}"
                                                        id="jobapplytxt">
                                                        {{ preg_replace('/[0-9\@\#\.\;]+/', '', $t_city->city_name) }}
                                                        <span
                                                            class="text-muted">({{ $t_city->numberOfcities }})</span>
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
                                <button onclick="location.href='https://www.facebook.com/pingjobsearch/';"
                                    type="button" class="btn btn-social-icon btn-outline-facebook"><i
                                        class="fab fa-facebook"></i></button>
                            </li>
                            <li>
                                <button onclick="location.href='https://www.instagram.com/pingjobsearch/';"
                                    type="button" class="btn btn-social-icon btn-outline-instagram"><i
                                        class="fab fa-instagram"></i></button>
                            </li>
                            <li>
                                <button onclick="location.href='https://twitter.com/pingjobsearch';" type="button"
                                    class="btn btn-social-icon btn-outline-twitter"><i
                                        class="fab fa-twitter"></i></button>
                            </li>
                            <li>
                                <button onclick="location.href='https://www.linkedin.com/company/ping-job';"
                                    type="button" class="btn btn-social-icon btn-outline-linkedin"><i
                                        class="fab fa-linkedin"></i></button>
                            </li>
                            <li>
                                <a href="https://wa.me/+15109361066" target="_blank" type="button"
                                    class="btn btn-social-icon btn-outline-success"
                                    style='justify-content: center;display: flex;align-items: center;border-width: 0;'><i
                                        class="fab fa-whatsapp"></i></a>
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
                                    <a class="btn btn-outline-success text-white"
                                        href="{{ route('client_add_view') }}">{{ __('app.register_client') }} </a>
                                </li>
                            @else
                                <li class="nav-item postjob-button">
                                    <a class="btn btn-outline-success text-white"
                                        href="{{ route('register_employer') }}">{{ __('app.register_client') }} </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item postjob-button">
                                <a class="btn btn-outline-success text-white"
                                    href="{{ route('register_employer') }}">{{ __('app.register_client') }} </a>
                            </li>
                            <li class="nav-item postjob-button">
                                <a class="btn btn-outline-primary text-white" href="https://social.pingjob.com/"
                                    target="_blank">{{ __('app.social_login') }}</a>
                            </li>
                        @endauth
                        <li class="nav-item postjob-button">
                            <a class="btn btn-outline-success text-white"
                                href="https://www.pingjob.com/pricing">{{ __('app.price') }} </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright-text-wrap">
            <p class="m-2 text-center">{!! get_text_tpl(get_option('copyright_text')) !!}</p>
        </div>

    </footer>
    {{-- footer end --}}
    <!-- apply job modal -->
    <div class="modal fade" id="applyJobModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('apply_job') }}" method="post" id="applyJob"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('app.online_job_application_form')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (session('error'))
                            <div class="alert alert-warning">{{ session('error') }}</div>
                        @endif
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label">@lang('app.name'):</label>
                            <input required type="text"
                                class="form-control {{ e_form_invalid_class('name', $errors) }}" id="name"
                                name="name"
                                value="@if (Auth::check()) {{ $name = Auth::user()->name }} @else {{ old('name') }} @endif"
                                placeholder="@lang('app.your_name')">
                            {!! e_form_error('name', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input required type="text"
                                class="form-control {{ e_form_invalid_class('email', $errors) }}" id="email"
                                name="email"
                                value="@if (Auth::check()) {{ $email = Auth::user()->email }} @else {{ old('email') }} @endif"
                                placeholder="@lang('app.email_ie')">
                            {!! e_form_error('email', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                            <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                            <input required type="text"
                                class="form-control {{ e_form_invalid_class('phone_number', $errors) }}"
                                id="phone_number" name="phone_number"
                                value="@if (Auth::check()) {{ $phone = Auth::user()->phone }} @else {{ old('phone_number') }} @endif"
                                placeholder="@lang('app.phone_number')">
                            {!! e_form_error('phone_number', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea required class="form-control {{ e_form_invalid_class('message', $errors) }}" id="message" name="message"
                                placeholder="@lang('app.your_message')">{{ old('message') }}</textarea>
                            {!! e_form_error('message', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('resume') ? 'has-error' : '' }}">
                            <label for="resume" class="control-label">@lang('app.resume'):</label>
                            <input required type="file"
                                class="form-control {{ e_form_invalid_class('resume', $errors) }}" id="resume"
                                name="resume">
                            <p class="text-muted">@lang('app.resume_file_types')</p>
                            {!! e_form_error('resume', $errors) !!}
                        </div>
                        <input type="hidden" name="job_id" id="job_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.apply_online')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- apply job modal end -->
    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */
    </script>
    {{-- footer script --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript">
        $(".radio_val").click(function() {

            let radio_value = $('input[name="search_category"]:checked').val();

            if (radio_value == 'client') {

                document.getElementById('search_form').action = 'clients';

            } else {

                document.getElementById('search_form').action = 'jobs';

            }



        })





        $(document).ready(function() {

            $("#post").on("keyup", function() {

                var value = $(this).val().toLowerCase();

                $("#mypost tr").filter(function() {

                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

                });

            });



            $("#topclient").on("keyup", function() {

                var value = $(this).val().toLowerCase();

                $("#myclient tr").filter(function() {

                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

                });

            });

        });

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









            $('#example').dataTable({
                "ordering": false,
                "pageLength": 25,
                'responsive': true,
                "bLengthChange": false,
                "pagingType": "full_numbers",
                info: false,
            });

            $('#example5').dataTable({
                "searching": false,
                "ordering": false,

                "pageLength": 10,

                'responsive': true,

                "bLengthChange": false,

                "pagingType": "full_numbers",
                info: false,

            });




            $('#example1').dataTable({

                "ordering": false,

                "pageLength": 10,

                'responsive': true,

                "pagingType": "simple",
                info: false,
                // responsive: true
            });



            $('#example3').dataTable({

                "ordering": false,

                "pageLength": 24,

                "bLengthChange": false,

                // responsive: true

                "pagingType": "simple",
                info: false,

            });


            $('#statesTable').dataTable({

                "ordering": false,

                "pageLength": 10,

                "bLengthChange": false,
                "info": false,
                // 'responsive': true,

                "pagingType": "simple",
                "searching": false

            });

            $('#example4').dataTable({
                "searching": false,

                "ordering": false,

                "pageLength": 5,

                "bLengthChange": false,
                // responsive: true
                info: false,
                "pagingType": "simple",
            });
            $('#citiesTable').dataTable({
                "searching": false,
                "ordering": false,
                "pageLength": 10,
                "bLengthChange": false,
                // responsive: true
                info: false,
                "pagingType": "simple",
            });
        });
    </script>
    {{-- footer script end --}}

</body>

</html>
