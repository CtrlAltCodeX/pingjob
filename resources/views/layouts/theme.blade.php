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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
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

</head>

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

        <div id="main-footer" class="main-footer bg-dark py-5">

            <div class="container">
                <div class="row">
                    <div class="col-md-4">

                        <div class="footer-logo-wrap mt-2">
                            <h4 class="mb-3">PingJob</h4>

                        </div>

                        <div class="footer-menu-wrap">
                            <ul class="list-unstyled">
                                <?php
                                $show_in_footer_menu = config('footer_menu_pages');
                                ?>
                                @if($show_in_footer_menu->count() > 0)
                                @foreach($show_in_footer_menu as $page)
                                <li><a href="{{ route('single_page', $page->slug) }}">{{ $page->title }} </a></li>
                                @endforeach
                                @endif
                                <li><a href="{{route('contact_us')}}">@lang('app.contact_us')</a> </li>
                                <li><a href="{{route('help_view')}}">@lang('app.help')</a> </li>
                            </ul>

                        </div>

                    </div>




                    <div class="col-md-4">



                        <div class="footer-menu-wrap mt-2">
                            <h4 class="mb-3">Follow Us </h4>
                            <ul class="list-unstyled">
                                <li><a href="https://www.Facebook.com/pingjob" target="_blank">Facebook</a></li>
                                <li><a href="https://www.Twitter.com/pingjobsearch" target="_blank">Twitter</a></li>
                                <li><a href="https://www.linkedin.com/company/ping-job" target="_blank">LinkedIn </a></li>
                                <li><a href="https://www.instagram.com/pingjobsearch/" target="_blank">Instagram </a></li>
                                <li><a href="https://wa.me/+5103999927" target="_blank">Whatsapp </a></li>
                            </ul>
                        </div>


                    </div>

                    <div class="col-md-3">

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
                                <li style="color: #38c172;"><a>@lang('app.clients')({{ $clients->count() }})</a></li>
                                <li style="color: #38c172;">@lang('app.approve_vendor')({{ $vendors->count() }})</li>
                                <li style="color: #38c172;">@lang('app.jobs')({{ $jobs->count() }})</li>
                                <li style="color: #38c172;">@lang('app.approve_contacts')({{ $contacts->count() }})</li>
                                <li style="color: #38c172;">@lang('app.approve_review')({{ 777 + $reviews->count() }})</li>
                                <li style="color: #38c172;">@lang('app.resumes')({{ 3906 + $job_applications->count() }})</li>
                            </ul>

                        </div>

                    </div>


                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-copyright-text-wrap text-center mt-4">
                            <p>{!! get_text_tpl(get_option('copyright_text')) !!}</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>


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