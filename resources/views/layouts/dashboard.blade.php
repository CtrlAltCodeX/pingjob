<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($title) ? $title : __('app.dashboard') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">

    @yield('page-css')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */
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

</head>

<body>
    @php
        $pendingJobCount = \App\Models\Job::pending()->count();
        $approvedJobCount = \App\Models\Job::approved()->count();
        $blockedJobCount = \App\Models\Job::blocked()->count();
        $user = \App\Models\User::find(Auth::id());
    @endphp

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="la la-home"></i>
                                @lang('app.view_site')</a> </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        @if ($user->is_admin())
                            <li style='margin-right: 6px;' class="nav-item">
                                <a class="nav-link btn btn-success text-white"
                                    href="{{ route('client_add_view') }}">{{ __('app.register_client') }} </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link btn btn-success text-white" href="{{ route('post_new_job') }}"><i
                                    class="la la-save"></i>{{ __('app.post_new_job') }} </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                <span class="badge badge-warning"><i
                                        class="la la-briefcase"></i>{{ auth()->user()->premium_jobs_balance }}</span>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <div id="main-container" class="main-container">

            <div class="row">
                <div class="col-md-3">

                    <div class="sidebar">
                        <ul class="sidebar-menu list-group">

                            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                                <a href="{{ route('dashboard') }}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-home"></i> </span>
                                    <span class="title">@lang('app.dashboard')</span>
                                </a>
                            </li>

                            <li class="{{ request()->is('dashboard/u/applied-jobs*') ? 'active' : '' }}">
                                <a href="{{ route('applied_jobs') }}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-list-alt"></i> </span>
                                    <span class="title">@lang('app.applied_jobs')</span>
                                </a>
                            </li>
                            @if ($user && ($user->is_admin() || $user->premium_jobs_balance))
                                <li class="{{ request()->is('dashboard/resumes-repo*') ? 'active' : '' }}">
                                    <a href="{{ route('view_resumes_repo') }}" class="list-group-item-action active">
                                        <span class="sidebar-icon"><i class="la la-bitbucket"></i> </span>
                                        <span class="title">@lang('app.resumes')</span>
                                    </a>
                                </li>
                            @endif
                            <li class="{{ request()->is('dashboard/u/user-review-status*') ? 'active' : '' }}">
                                <a href="{{ route('user_review_status') }}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-star-o"></i> </span>
                                    <span class="title">@lang('app.approve_review')</span>
                                </a>
                            </li>



                            @if ($user->is_admin())
                                <li class="{{ request()->is('dashboard/categories*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard_categories') }}"
                                        class="list-group-item-action active">
                                        <span class="sidebar-icon"><i class="la la-th-large"></i> </span>
                                        <span class="title">@lang('app.categories')</span>
                                    </a>
                                </li>
                            @endif

                            @if (!$user->is_user())


                                <li class="{{ request()->is('dashboard/employer*') ? 'active' : '' }}">
                                    <a href="#" class="list-group-item-action">
                                        <span class="sidebar-icon"><i class="la la-black-tie"></i> </span>
                                        <span class="title">@lang('app.employer')</span>
                                        <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                    </a>

                                    <ul class="dropdown-menu" style="display: none;">
                                        <li><a class="sidebar-link"
                                                href="{{ route('post_new_job') }}">@lang('app.post_new_job')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('posted_jobs') }}">@lang('app.posted_jobs')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('employer_applicant') }}">@lang('app.applicants')</a></li>
                                        {{-- <li><a class="sidebar-link" href="{{route('employer_applicant_resumes')}}">@lang('app.resumes')</a></li> --}}
                                        <li><a class="sidebar-link"
                                                href="{{ route('shortlisted_applicant') }}">@lang('app.shortlist')</a>
                                        </li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('employer_profile') }}">@lang('app.profile')</a></li>
                                        @if ($user->is_admin())
                                            <li><a class="sidebar-link"
                                                    href="{{ route('employeer_list') }}">@lang('app.employer')</a></li>
                                        @endif
                                    </ul>
                                </li>

                            @endif

                            @if ($user->is_admin())
                                <li class="{{ request()->is('dashboard/jobs*') ? 'active' : '' }}">
                                    <a href="#" class="list-group-item-action">
                                        <span class="sidebar-icon"><i class="la la-briefcase"></i> </span>
                                        <span class="title">@lang('app.jobs')</span>
                                        <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                    </a>

                                    <ul class="dropdown-menu" style="display: none;">
                                        <li><a class="sidebar-link"
                                                href="{{ route('pending_jobs') }}">@lang('app.pending') <span
                                                    class="badge badge-success float-right">{{ $pendingJobCount }}</span></a>
                                        </li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('approved_jobs') }}">@lang('app.approved') <span
                                                    class="badge badge-success float-right">{{ $approvedJobCount }}</span>
                                            </a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('blocked_jobs') }}">@lang('app.blocked') <span
                                                    class="badge badge-success float-right">{{ $blockedJobCount }}</span>
                                            </a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('post_new_job') }}">@lang('app.add_job_by_any_client') </a></li>
                                    </ul>
                                </li>

                                <li class="{{ request()->is('dashboard/reviews-status*') ? 'active' : '' }}">
                                    <a href="#" class="list-group-item-action">
                                        <span class="sidebar-icon"><i class="la la-file-text-o"></i> </span>
                                        <span class="title">@lang('app.approve')</span>
                                        <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                    </a>

                                    <ul class="dropdown-menu" style="display: none;">
                                        <li><a class="sidebar-link"
                                                href="{{ route('dashboard_reviews') }}">@lang('app.approve_review')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('dashboard_vendors') }}">@lang('app.approve_vendor')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('dashboard_contacts') }}">@lang('app.approve_contacts')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('dashboard_approve_client') }}">@lang('app.approve_client')</a>
                                        </li>
                                    </ul>

                                </li>

                                <li class="{{ request()->is('dashboard/flagged*') ? 'active' : '' }}">
                                    <a href="{{ route('flagged_jobs') }}" class="list-group-item-action active">
                                        <span class="sidebar-icon"><i class="la la-flag-o"></i> </span>
                                        <span class="title">@lang('app.flagged_jobs')</span>
                                    </a>
                                </li>


                                <li class="{{ request()->is('dashboard/cms*') ? 'active' : '' }}">
                                    <a href="#" class="list-group-item-action">
                                        <span class="sidebar-icon"><i class="la la-file-text-o"></i> </span>
                                        <span class="title">@lang('app.cms')</span>
                                        <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                    </a>

                                    <ul class="dropdown-menu" style="display: none;">
                                        <li><a class="sidebar-link"
                                                href="{{ route('pages') }}">@lang('app.pages')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('posts') }}">@lang('app.posts')</a></li>
                                    </ul>
                                </li>


                                <li class="{{ request()->is('dashboard/settings*') ? 'active' : '' }}">
                                    <a href="#" class="list-group-item-action">
                                        <span class="sidebar-icon"><i class="la la-cogs"></i> </span>
                                        <span class="title">@lang('app.settings')</span>
                                        <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                    </a>

                                    <ul class="dropdown-menu" style="display: none;">
                                        <li><a class="sidebar-link"
                                                href="{{ route('general_settings') }}">@lang('app.general_settings')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('pricing_settings') }}">@lang('app.pricing')</a></li>
                                        <li><a class="sidebar-link"
                                                href="{{ route('gateways_settings') }}">@lang('app.gateways')</a></li>
                                    </ul>
                                </li>
                            @endif



                            @if ($user->is_admin())
                                {{--
                            <li>
                                <a href="{{route('dashboard')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-user-secret"></i> </span>
                                    <span class="title">@lang('app.administrator')</span>
                                </a>
                            </li>

                            --}}
                                <li class="{{ request()->is('dashboard/u/users*') ? 'active' : '' }}">
                                    <a href="{{ route('users') }}" class="list-group-item-action active">
                                        <span class="sidebar-icon"><i class="la la-users"></i> </span>
                                        <span class="title">@lang('app.users')</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('help_admin_view') }}" class="list-group-item-action active">
                                        <span class="sidebar-icon"><i class="la la-question"></i> </span>
                                        <span class="title">@lang('app.help')</span>
                                    </a>
                                </li>
                            @endif

                            <li class="{{ request()->is('dashboard/u/profile*') ? 'active' : '' }}">
                                <a href="{{ route('profile') }}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-user"></i> </span>
                                    <span class="title">@lang('app.profile')</span>
                                </a>
                            </li>


                            <li class="{{ request()->is('dashboard/account*') ? 'active' : '' }}">
                                <a href="{{ route('change_password') }}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-lock"></i> </span>
                                    <span class="title">@lang('app.change_password')</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('logout') }}" class="list-group-item-action active"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="sidebar-icon"><i class="la la-sign-out"></i> </span>
                                    <span class="title">@lang('app.logout')</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </div>

                <div class="col-md-9">
                    <div class="main-page pr-4">

                        <div class="main-page-title mt-3 mb-3 d-flex">
                            <h3 class="flex-grow-1">{!! !empty($title) ? $title : __('app.dashboard') !!}</h3>

                            <div class="action-btn-group">@yield('title_action_btn_gorup')</div>
                        </div>

                        @include('admin.flash_msg')

                        <div class="main-page-content p-4 mb-4">
                            @yield('content')
                        </div>


                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Scripts -->
    @yield('page-js')
    <script src="{{ asset('assets/js/admin.js') }}" defer></script>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TZVH8P5" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

</body>

</html>
