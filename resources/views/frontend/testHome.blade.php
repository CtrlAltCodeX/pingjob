<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PingJob | Empowering the job seeker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

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

    <style type='text/css'>
        .navbar-right .row li {
            margin-right: 15px;
        }

        /*.col-sm-6 li{
         list-style: none;
         display: inline-block;
         }*/
        footer {
            background: #efefef;
        }

        footer .row {
            padding: 10px;
        }

        .alpha-bit-href {
            color: #000;
        }

        .alpha-bit-href:hover {
            color: #777;
        }
    </style>
</head>

<body style="margin:0px;padding:0px;">
    <section id="top-nav" class="mainTopHeader">
        <div class="container-fluid">


            <nav
                class="navbar navbar-expand-md navbar-light navbar-laravel {{ request()->routeIs('home') ? 'transparent-navbar' : '' }}">
                <div class="container-fluid">


                    <div class="headerContent">
                        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button> -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <h2><img src="{{ asset('assets/images/logo.png') }}"></h2>
                        </a>

                        <div class="headerList" style="margin-left: 20px;">
                            <!-- <ul class="list-unstyled topnav">
                           <li><a href="#">Find only Client Jobs, Fast</a></li>
                           <li><a href="#">Search by skills</a></li>
                           <li><a href="#">View Vendors & Job history</a></li>
                           <li><a href="#">One-click apply</a></li>
                        </ul> -->
                            <p class="navbar-find-heading">Find only Client Jobs, Fast</h2>
                            <p class="navbar-find-heading-subtitle">Search by skills. View Vendors & Job history.
                                One-click apply.
                            <p>
                        </div>
                        <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                            class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
                    </div>



                    <div class="collapse navbar-collapse" id="navbarSupportedContent">


                        <!-- Right Side Of Navbar -->
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
                                        <a class="nav-link" href="{{ route('new_register') }}"><i
                                                class="la la-user-plus"></i> {{ __('app.register') }}</a>
                                    @endif
                                </li>
                            @else
                                <a class="nav-link btn btn-dark  text-white ml-lg-2" s href="{{ route('dashboard') }}"><i
                                        class="la la-dashboard"></i>{{ __('app.dashboard') }} </a>



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
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </section>
    <div class="container-fluid">
        <div class="row mainRow">
            <div class="col-sm-12 col-md-6 col-lg-3 col-xs-12 pr-0 pr-15-m">
                <!-- <div class="container">
                  <div class="row"> -->
                <div class=" market-overview-wrapper padding-zero mb-3 h-20">
                    <div class=" market-overview searchCont h-100">
                        <h2 class="card-title"><i class="fa fa-search mr-1"></i> Search</h2>
                        <form action="jobs" name="myForm" class="" method="get" id="search_form">
                            <div class="custom-control custom-radio m-2 pl-0">
                                <style>
                                    input::-webkit-input-placeholder {
                                        font-size: 10px;
                                    }
                                </style>
                                <div class="d-inline-block radio-item" style="margin-right: 10px;">
                                    <input class="form-check-input radio_val" type="radio" name="search_category"
                                        id="customRadio1" value="job" checked>
                                    <label class="form-check-label" for="customRadio1">JOB</label>
                                </div>
                                <div class="d-inline-block radio-item">
                                    <input class="form-check-input radio_val" type="radio" name="search_category"
                                        id="customRadio2" value="client">
                                    <label class="form-check-label" for="customRadio2">CLIENT</label>
                                </div>
                            </div>
                            <div class="input-group mb-3 mt-4">
                                <input type="text" class="form-control" name="q"
                                    placeholder="@lang('app.job_title_placeholder')">
                                <input type="text" class="form-control" name="location"
                                    placeholder="@lang('app.job_location_placeholder')">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="submit"> @lang('app.search')</button>
                                </div>
                            </div>
                        </form>
                        <p class="m-3 search-alphabets">
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=@'; ?>" class="alpha-bit-href">@</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=#'; ?>" class="alpha-bit-href">#</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=a'; ?>" class="alpha-bit-href">A</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=b'; ?>" class="alpha-bit-href">B</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=c'; ?>" class="alpha-bit-href">C</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=d'; ?>" class="alpha-bit-href">D</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=e'; ?>" class="alpha-bit-href">E</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=f'; ?>" class="alpha-bit-href">F</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=g'; ?>" class="alpha-bit-href">G</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=h'; ?>" class="alpha-bit-href">H</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=i'; ?>" class="alpha-bit-href">I</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=j'; ?>" class="alpha-bit-href">J</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=k'; ?>" class="alpha-bit-href">K</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=l'; ?>" class="alpha-bit-href">L</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=m'; ?>" class="alpha-bit-href">M</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=n'; ?>" class="alpha-bit-href">N</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=o'; ?>" class="alpha-bit-href">O</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=p'; ?>" class="alpha-bit-href">P</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=q'; ?>" class="alpha-bit-href">Q</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=r'; ?>" class="alpha-bit-href">R</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=s'; ?>" class="alpha-bit-href">S</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=t'; ?>" class="alpha-bit-href">T</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=u'; ?>" class="alpha-bit-href">U</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=v'; ?>" class="alpha-bit-href">V</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=w'; ?>" class="alpha-bit-href">W</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=x'; ?>" class="alpha-bit-href">X</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=y'; ?>" class="alpha-bit-href">Y</a></b>
                            <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=z'; ?>" class="alpha-bit-href">Z</a></b>
                        </p>
                    </div>
                </div>

                <div class=" market-overview-wrapper padding-zero mb-4 h-40">
                    <div class="card1 market-overview h-100" id="cityBlockCard">
                        <div class="card-body1 plrtb-5">
                            <h2 class="card-title">States</h2>
                            <div class="table-responsive mt-2">
                                <table class="table" id="statesTable">

                                    <thead>

                                        <tr>

                                            <th>States</th>

                                            <th>Job(S)</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php  foreach ($total_state_job as $t_states) { ?>

                                        <tr>

                                            <td class="dataportal"><span
                                                    class="table-text-dark">{{ preg_replace('/[0-9\@\#\.\;]+/', '', $t_states->state_name) }}</span>
                                            </td>

                                            <td><a id="jobapplytxt"
                                                    style="text-decoration:none;color:#165c98;font-size: small;"
                                                    target="_blank"
                                                    href="{{ route('jobs_by_state_or_city', $t_states->state_name) }}">{{ $t_states->numberOfSales }}</a>
                                            </td>

                                        </tr>

                                        <?php } ?>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" market-overview-wrapper padding-zero mb-3 h-40">
                    <div class=" market-overview h-100" id="cityBlockCard">
                        <div class=" plrtb-5">
                            <h2 class="">Cities</h2>
                            <div class="table-responsive mt-2">
                                <table class="table dataTables" id="citiesTable">
                                    <thead>
                                        <tr>
                                            <th>Cities</th>
                                            <th>Job(S)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach ($total_city_jobe as $t_city) { ?>
                                        <tr>
                                            <td><span
                                                    class="table-text-dark">{{ preg_replace('/[0-9\@\#\.\;]+/', '', $t_city->city_name) }}</span>
                                            </td>
                                            <td><a id="jobapplytxt"
                                                    style="text-decoration:none;color:#165c98;font-size: small;"
                                                    target="_blank"
                                                    href="{{ route('jobs_by_state_or_city', str_replace(' ', ' ', $t_city->city_name)) }}">{{ $t_city->numberOfcities }}</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <!-- </div> -->

                <!-- <div class="container"> -->

                <!-- </div> -->
            </div>
            <!-- col-3 -->
            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 pr-0 pl-0">
                <div class="row h-100">
                    @include('admin.flash_msg')
                    @if ($premium_jobs->count())
                        <div class="col-12 market-overview-wrapper padding-zero h-100">
                            <div class=" market-overview mb-3 h-100" id="newJobPostedCard">
                                <div class="plrtb-5">
                                    <div class="market-heading mb-2">
                                        <h2 class="">Newest Jobs</h2>
                                    </div>
                                    <table class="table-responsive table newestJobs" id="example">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Title</th>
                                                <th>Client</th>
                                                <th>Vendor</th>
                                                <th>Resumes </th>
                                                <th>Location </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody id="mypost">
                                            @foreach ($premium_jobs as $job)
                                                <tr>
                                                    <td style="width:60px;height:27px">
                                                        {{ date('M-d', strtotime($job->created_at)) }}</td>
                                                    <td>
                                                        <a class="text-dark"
                                                            href="{{ route('job_view', $job->job_slug) }}">{!! $job->job_title !!}</a>
                                                    </td>
                                                    <td> <a class="text-dark"
                                                            href="{{ route('clients_details', $job->user_id) }}">
                                                            <b> {!! $job->company !!}</b></a>
                                                    </td>
                                                    <td>{{ $job->vendor_count }}</td>
                                                    <td>{!! $job->job_applications_count !!}</td>
                                                    <td>
                                                        @if ($job->city_name)
                                                            {!! $job->city_name !!},
                                                        @endif
                                                        @if ($job->state_name)
                                                            {!! $job->state_name !!}
                                                        @endif
                                                    </td>
                                                    <td><button class="btn btn-success btn-sm" data-toggle="modal"
                                                            data-jobid=' {!! $job->id !!}'
                                                            data-target="#applyJobModal">Apply</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <!-- col-6 -->
            <div class="col-sm-12 col-md-12 col-lg-3 col-xs-12 pl-0 pl-15-m">
                <div class="row h-100">
                    <div
                        class=" col-sm-6 col-md-6 col-lg-12 col-xs-12 market-overview-wrapper padding-zero  h-50 h-m-100-50">
                        <div class="card1 market-overview-wrapper padding-zero mb-2 h-100" id="topCLientCard">
                            <div class="card-body1 plrtb-5 topClient h-100">
                                <h2 class="card-title">Top Clients</h2>
                                <table class="table topClientTab" id="example1">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Job(S)</th>
                                            <th>Vendor(S)</th>
                                            <th>Resume(S)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myclient">
                                        @if ($top_clients->isNotEmpty())
                                            @foreach ($top_clients as $top_client)
                                                <tr>
                                                    <td><span
                                                            class="table-text-dark">{{ str_limit($top_client->company, 15) }}</span>
                                                    </td>
                                                    <td><a id="jobapplytxt"
                                                            style="text-decoration:none;color:#165c98;font-size: small;"
                                                            target="_blank"
                                                            href="{{ route('jobs_by_employer', $top_client->company_slug) }}">{{ $top_client->job_count }}</a>
                                                    </td>
                                                    <td style="font-size: small;">{{ $top_client->vendor_count }}</td>
                                                    <td style="font-size: small;">
                                                        {{ $top_client->applications_count }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-sm-6 col-md-6 col-lg-12 col-xs-12 market-overview-wrapper padding-zero h-50 h-m-100-50">
                        <div class="card1 market-overview top-vendors h-100 mb-3">
                            <div class="card-body1 plrtb-5">
                                <h2 class="card-title mb-2">Top Vendors</h2>
                                <table class="table table-responsive dataTable topVendor" id="example5">
                                    <thead>
                                        <tr>
                                            <th>Vendors</th>
                                            <th>Total</th>

                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <?php
                                    foreach ($total_vendors_job as $total_vendors) { ?>
                                        <tr>
                                            <td>{{ preg_replace('/[0-9\@\#\.\;]+/', '', $total_vendors->name) }}</td>
                                            <td>
                                                <a class="text-info"
                                                    href="{{ route('topclients_details', $total_vendors->id) }}">
                                                    {!! $total_vendors->numberOfclient !!}</a>
                                            </td>


                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <!-- col-3 -->
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-3 order-sm-12 order-lg-1 market-overview-wrapper padding-zero pr-0">
                <div class="card1 market-overview">
                    <div class="card-body1 plrtb-5">
                        <ul class="list-unstyled aboutList">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Pricing</a></li>
                            <li><a href="#">How does it work?</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- categories -->
            <div class="col-sm-12 col-lg-6 col-md-12 order-1 order-sm-10 categoryMainRow pl-0 pr-0">
                <div class=" market-overview-wrapper padding-zero mb-3">
                    <div class="card1 market-overview">
                        <div class="plrtb-5">
                            @if ($categories->count())
                                <h2 class="card-title">CATEGORY</h2>
                                <!-- <hr> -->
                                <!-- <div class="container"> -->
                                <div class="row pl-15">
                                    @foreach ($categories as $category)
                                        <div class="col-md-3">
                                            <p class="mt-3">
                                                <a style="font-size:12px;"
                                                    href="{{ route('jobs_listing', ['category' => $category->id]) }}"
                                                    class="text-dark text-decoration-none"><i
                                                        class="la la-th-large"></i>
                                                    {{ $category->category_name }}
                                                    <span class="text-muted">({{ $category->job_count }})</span> </a>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- </div> -->
                            @endif
                            <div class="float-right category-pagination">{!! $categories->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-sm-6 col-md-6 col-lg-3 order-sm-11 order-1  market-overview-wrapper padding-zero pl-0">
                <div class="market-overview statsCont">
                    <div class="plrtb-5" id="statesCardBlock">
                        <h2>Stats</h2>
                        <div class="table-responsive1">
                            <table class="table statTab">
                                <thead class="">
                                    <!-- <tr>
                                 <th>City</th>

                                 <th>Top Client(S)</th>

                                 <th>Job(S)</th>

                                 </tr> -->
                                </thead>
                                <tbody class="">
                                    <?php
                                    $clients = config('clients');
                                    $vendors = config('vendors');
                                    $jobs = config('jobs');
                                    $contacts = config('contacts');
                                    $reviews = config('reviews');
                                    $job_applications = config('job_applications');
                                    ?>
                                    <tr>
                                        <td class="top-vendors">@lang('app.clients')</td>
                                        <td style="font-size: small; font-weight:500;">({{ $clients->count() }})</td>
                                    </tr>
                                    <tr>
                                        <td class="top-vendors">@lang('app.approve_vendor')</td>
                                        <td style="font-size: small; font-weight:500;">({{ $vendors->count() }})</td>
                                    </tr>
                                    <tr>
                                        <td class="top-vendors">@lang('app.jobs')</td>
                                        <td style="font-size: small; font-weight:500;">({{ $jobs->count() }})</td>
                                    </tr>
                                    <tr>
                                        <td class="top-vendors">@lang('app.approve_contacts')</td>
                                        <td style="font-size: small; font-weight:500;">({{ $contacts->count() }})</td>
                                    </tr>
                                    <tr>
                                        <td class="top-vendors">@lang('app.approve_review')</td>
                                        <td style="font-size: small; font-weight:500;">({{ 777 + $reviews->count() }})
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="top-vendors">@lang('app.resumes')</td>
                                        <td style="font-size: small; font-weight:500;">
                                            ({{ 3906 + $job_applications->count() }})</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <footer>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="copyright mb-0">Copyright <span>©</span> 2021 : Connect with PingJob, all rights
                            reserved</p>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled mb-0 mediaLinks">
                            <li>
                                <button onclick="location.href='https://www.facebook.com/PingJob/';" type="button"
                                    class="btn btn-social-icon btn-outline-facebook"><i
                                        class="fab fa-facebook"></i></button>
                            </li>
                            <li>
                                <button onclick="location.href='https://www.instagram.com/pingjob/';" type="button"
                                    class="btn btn-social-icon btn-outline-instagram"><i
                                        class="fab fa-instagram"></i></button>
                            </li>
                            <li>
                                <button onclick="location.href='https://twitter.com/pingjob';" type="button"
                                    class="btn btn-social-icon btn-outline-twitter"><i
                                        class="fab fa-twitter"></i></button>
                            </li>
                            <li>
                                <button onclick="location.href='https://www.linkedin.com/company/pingjob';"
                                    type="button" class="btn btn-social-icon btn-outline-linkedin"><i
                                        class="fab fa-linkedin"></i></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- container-fluid -->
    <!-- apply job modala -->
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
                            <input type="text" class="form-control {{ e_form_invalid_class('name', $errors) }}"
                                id="name" name="name"
                                value="@if (Auth::check()) {{ $name = Auth::user()->name }} @else
                           {{ old('name') }} @endif"
                                placeholder="@lang('app.your_name')">
                            {!! e_form_error('name', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control {{ e_form_invalid_class('email', $errors) }}"
                                id="email" name="email"
                                value="@if (Auth::check()) {{ $email = Auth::user()->email }} @else
                           {{ old('email') }} @endif"
                                placeholder="@lang('app.email_ie')">
                            {!! e_form_error('email', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                            <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                            <input type="text"
                                class="form-control {{ e_form_invalid_class('phone_number', $errors) }}"
                                id="phone_number" name="phone_number"
                                value="@if (Auth::check()) {{ $phone = Auth::user()->phone }} @else
                           {{ old('phone_number') }} @endif"
                                placeholder="@lang('app.phone_number')">
                            {!! e_form_error('phone_number', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control {{ e_form_invalid_class('message', $errors) }}" id="message" name="message"
                                placeholder="@lang('app.your_message')">{{ old('message') }}</textarea>
                            {!! e_form_error('message', $errors) !!}
                        </div>
                        <div class="form-group {{ $errors->has('resume') ? 'has-error' : '' }}">
                            <label for="resume" class="control-label">@lang('app.resume'):</label>
                            <input type="file" class="form-control {{ e_form_invalid_class('resume', $errors) }}"
                                id="resume" name="resume">
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
    <!-- @section('page-js') -->
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
                    // responsive: true,
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
                    // responsive: true

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
    </body>

    </html>
