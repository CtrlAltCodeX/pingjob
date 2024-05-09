@php
use App\Helper\Functions;
@endphp
@extends('frontend.layout.app')

@push('css')
<style>
    .input {
        border-radius: 15px;
        box-shadow: 0px 0px 15px #eee;
        border: none;
    }

    .input input {
        border-radius: 10px;
    }

    .input input::placeholder {
        font-size: 16px;
    }
</style>
@endpush

@section('content')
<div class="row mainRow">
    <!-- col-3 -->
    <div class="col-sm-12 col-md-12 col-lg-9 col-xs-12">
        <div class="row">

            @include('admin.flash_msg')

            @if ($premium_jobs->count())

            <div class="col-12 col-md-12 market-overview-wrapper ">
                <div class=" market-overview mb-3 " id="newJobPostedCard" style="box-shadow: inherit !important;background:inherit !important;">
                    <div class="plrtb-5">
                        <!-- <div class="market-heading mb-2">
                            <h2 class="">Newest Jobs</h2>
                        </div> -->
                        <div style="width: 100%;">
                            <div class="row row justify-content-center">
                                @foreach ($premium_jobs as $job)
                                @php
                                $getState = \App\Models\State::find($job->state_id);
                                $count = DB::table('job_applications')
                                ->select(DB::raw('DISTINCT email'))
                                ->where('category_id', '=', $job->category_id)
                                ->get()->count();
                                @endphp
                                <div class="col-md-10 mt-4" style="background-color: white;padding: 20px;box-shadow: 0px 0px 10px #eee;border-radius: 10px;">
                                    <div class='d-flex' style="grid-gap: 30px;">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $job->logo ? asset('storage/uploads/images/logos/' . $job->logo) : asset('assets/images/company.png') }}" width=100 />
                                        </div>
                                        <div class="d-flex flex-column w-100" style="font-size: 16px;">
                                            <div class="d-flex flex-column">
                                                <div class="d-flex justify-content-between">

                                                    <a href="{{ route('job_view', $job->job_slug) }}" class='text-dark'>{!! $job->job_title !!}</a>
                                                    <a href="{{ route('clients_details', $job->user_id) }}" style='font-size:20px;'><b>{!! $job->company !!}</b></a>

                                                    <div class="d-flex flex-column">
                                                        <span class='bg-warning p-2'>{{ date('M-d', strtotime($job->created_at)) }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <b>@if ($job->city_name)
                                                        {!! $job->city_name !!},
                                                        @endif
                                                        @if ($getState->state_id)
                                                        {{ $getState->state_id }}
                                                        @endif
                                                    </b>
                                                    <div class='d-flex align-items-end flex-column'>
                                                        <span>Vendor - {{ $job->vendor_count }}</span>
                                                        <span>Applicants - {{ $count }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <button class="btn btn-success mt-4 btn-sm" data-toggle="modal" data-jobid=' {!! $job->id !!}' data-target="#applyJobModal">Apply</button>
                                                <!-- <span>{{ date('M-d', strtotime($job->created_at)) }}</span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="mt-2">
                                    {{ $premium_jobs->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    <!-- col-6 newest job end -->
    <div class="col-sm-12 col-md-12 col-lg-3 col-xs-12 d-flex flex-column">
        <div class="row">
            {{-- alphabatic search --}}
            <div class="col-sm-12 col-md-12 col-lg-12 market-overview-wrapper mb-3 ">
                <div class=" market-overview searchCont " style="background:inherit !important;box-shadow:inherit !important;">
                    <!-- <h2 class="card-title"><i class="fa fa-search mr-1"></i> Search</h2> -->
                    <form action="jobs" name="myForm" class="" method="get" id="search_form">
                        <div class="custom-control custom-radio m-2 pl-0">
                            <style>
                                input::-webkit-input-placeholder {
                                    font-size: 10px;
                                }
                            </style>
                            <div class="d-inline-block radio-item" style="margin-right: 10px;">
                                <input class="form-check-input radio_val" type="radio" name="search_category" id="customRadio1" value="job" checked>
                                <label class="form-check-label" for="customRadio1">JOB</label>
                            </div>
                            <div class="d-inline-block radio-item">
                                <input class="form-check-input radio_val" type="radio" name="search_category" id="customRadio2" value="client">
                                <label class="form-check-label" for="customRadio2">CLIENT</label>
                            </div>
                        </div>
                        <div class="input-group mb-3 mt-4 input">
                            <input type="text" class="form-control" name="q" placeholder="@lang('app.job_title_placeholder')">
                            <input type="text" class="form-control" name="location" placeholder="@lang('app.job_location_placeholder')">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit" style="border-radius: 10px;"> @lang('app.search')</button>
                            </div>
                        </div>

                        <!-- <div class="input-group mb-3 mt-4">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit" style="border-radius: 10px;"> @lang('app.search')</button>
                            </div>
                        </div> -->
                    </form>
                    <p class="m-3 search-alphabets">
                        <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=@'; ?>" class="alpha-bit-href">@</a></b>
                        <b class="alpha-bit"><a href="<?php echo 'clients_alphabetic?search_category=client&q=#'; ?>" class="alpha-bit-href">#</a></b>
                        @foreach (range('A', 'Z') as $char)
                        <b class="alpha-bit"><a href="{{ 'clients_alphabetic?search_category=client&q=' . strtolower($char) }}" class="alpha-bit-href">{{ $char }}</a></b>
                        @endforeach
                    </p>
                </div>
            </div>
            {{-- alphabatic search end --}}
            {{-- Top Client --}}

            {{--
            <div class=" col-sm-6 col-md-6 col-lg-12 col-xs-12 market-overview-wrapper ">
                <div class="card1 market-overview-wrapper my-2 " id="topCLientCard">
                    <div class="card-body1 plrtb-5 topClient ">
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
                                    <td><span class="table-text-dark">{{ Functions::str_limit($top_client->company, 15) }}</span>
            </td>
            <td><a id="jobapplytxt" style="text-decoration:none;color:#165c98;font-size: small;" target="_blank" href="{{ route('jobs_by_employer', $top_client->company_slug ?? 0) }}">{{ $top_client->job_count }}</a>
            </td>
            <td style="font-size: small;">{{ $top_client->vendor_count }}</td>
            <td style="font-size: small;">
                {{ $top_client->applications_count }}
            </td>
            </tr>
            @endforeach
            @endif
            </tbody>
            </table>
            <h2 class="card-title mb-2">Top Vendors</h2>
            <table class="table table-responsive dataTable topVendor" id="example5">
                <thead>
                    <tr>
                        <th>Vendors</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($total_vendors_job as $total_vendors)
                    <tr>
                        <td>{{ preg_replace('/[0-9\@\#\.\;]+/', '', $total_vendors->name) }}
                        </td>
                        <td>
                            <a class="text-info" href="{{ route('topclients_details', $total_vendors->id) }}">
                                {!! $total_vendors->numberOfclient !!}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-sm-6 col-md-6 col-lg-12 col-xs-12 market-overview-wrapper ">
    <div class="card1 market-overview top-vendors  my-3">
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
                    @foreach ($total_vendors_job as $total_vendors)
                    <tr>
                        <td>{{ preg_replace('/[0-9\@\#\.\;]+/', '', $total_vendors->name) }}</td>
                        <td>
                            <a class="text-info" href="{{ route('topclients_details', $total_vendors->id) }}">
                                {!! $total_vendors->numberOfclient !!}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
--}}
<div class="market-overview plrtb-5 flex-grow-1 mb-3">
    <div class="">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="width:max-content;">
                <a class="nav-item nav-link active" id="bj-top-clients-nav" data-toggle="tab" href="#bj-top-clients" role="tab" data-analytics-track="click" data-analytics-key="seoTabClick" data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Clients" aria-controls="bj-top-clients" aria-selected="true">Top Clients
                </a>
                <a class="nav-item nav-link" id="bj-top-vendors-nav" data-toggle="tab" href="#bj-top-vendors" role="tab" data-analytics-track="click" data-analytics-key="seoTabClick" data-analytics-set-group="click,#nav-tabContent,seoTabContent-Top Vendors" aria-controls="bj-top-vendors" aria-selected="false">Top Vendors
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" data-an-category="seoTabContent-Top Clients">
            <div class="tab-pane fade unauth-job-list active show" id="bj-top-clients" role="tabpanel" aria-labelledby="bj-top-clients-nav" data-an-category="seoTabContent-Top Clients">
                <table class="table table-responsive dataTable" id="top-clients">
                    {{-- <table class="table table-responsive dataTable topClientTab" id="top-clients"> --}}
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Job</th>
                            <th>Vendor</th>
                            <th>Resume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($top_clients->isNotEmpty())
                        @foreach ($top_clients as $top_client)
                        <tr>
                            <td style="white-space: nowrap;"><span class="table-text-dark">{{ Functions::str_limit($top_client->company, 10) }}</span>
                            </td>
                            <td><a id="jobapplytxt" style="text-decoration:none;color:#165c98;font-size: small;" target="_blank" href="{{ route('jobs_by_employer', $top_client->company_slug ?? 0) }}">{{ $top_client->job_count }}</a>
                            </td>
                            <td style="font-size: small;">
                                {{ $top_client->vendor_count }}
                            </td>
                            <td style="font-size: small;">
                                {{ $top_client->applications_count }}
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade unauth-job-list" id="bj-top-vendors" role="tabpanel" aria-labelledby="bj-top-vendors-nav" data-an-category="seoTabContent-Top Vendors">
                <table class="table table-responsive dataTable" id="top-vendors">
                    {{-- <table class="table table-responsive dataTable topVendor" id="top-vendors"> --}}
                    <thead>
                        <tr>
                            <th>Vendors</th>
                            <th style="text-align:right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($total_vendors_job as $total_vendors)
                        <tr>
                            <td style="white-space: nowrap;"><span class="table-text-dark">{{ Functions::str_limit(preg_replace('/[0-9\@\#\.\;]+/', '', $total_vendors->name), 12) }}</span>
                            </td>
                            <td style="font-size: small; text-align:right;">
                                <a class="text-info" href="{{ route('topclients_details', $total_vendors->id) }}">
                                    {!! $total_vendors->numberOfclient !!}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

@push('css')
<style>
    .loader {
        width: 48px;
        height: 48px;
        border: 5px solid #FFF;
        border-bottom-color: #FF3D00;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .package {
        box-shadow: 0px 0px 5px #ccc;
        background-color: white;
        border: none;
        border-radius: 10px !important;
    }

    .pricing-table-wrap {
        box-shadow: 0px 0px 5px #ccc;
        padding: 2.5rem;
        border-radius: 1rem
    }

    .package-container {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        margin-top: 2.5rem;
        margin-bottom: 2.5rem;
        grid-gap: 30px;
    }

    .free-package {
        background-color: #38c172 !important;
        color: white;
    }
</style>
@endpush

<div class="row">
    <div class="col-md-12">
        <div class="pricing-section bg-white pb-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pricing-section-heading mb-5 text-center">
                            <h1>Pricing</h1>
                            <h5 class="text-muted">Choose a package to unlock Job Posting ability.</h5>
                            <h5 class="text-muted">To get a large amount of quality application, choose the premium package</h5>
                        </div>

                    </div>
                </div>

                <div class="row package-container">

                    @foreach($packages as $key => $package)
                    @if($key == 1 )
                    <div style="margin-top: -20px;">
                        @else
                        <div>
                            @endif
                            <div class="pricing-table-wrap bg-light pt-5 pb-5 text-center @if($key == 0) free-package @endif">
                                <h1 class="display-4">{!! get_amount($package->price) !!}</h1>
                                <h3>{{$package->package_name}}</h3>

                                @if($key == 0)
                                <div style="display: grid;grid-gap:5px;">
                                    <!-- <p class="mb-2 text-muted">{{$package->premium_job}} Jobs Post</p> -->
                                    <p class="mb-2">Lifetime Access</p>
                                    <p class="mb-2">Manage Multiple Resumes</p>
                                    <p class="mb-2">Single User</p>
                                    <p class="mb-2">Dashboard for applied Jobs</p>
                                    <p class="mb-2">Social Google/Facebook Login</p>
                                    <p class="mb-2">Daily email</p>
                                    <p class="mb-2">Social App for direct client interaction</p>
                                    <p class="mb-2">Automatic Assignment to Jobs</p>
                                    <a class="btn btn-success mt-4 package" style="color: #38c172;" id="{{$package->id}}" href='{{ route("new_register") }}'>
                                        <i class="la la-shopping-cart"></i> Sign for free</a>
                                </div>
                                @endif

                                @if($key == 1)

                                <div style="display: grid;grid-gap:15px;">
                                    <p class="mb-2 text-muted">Access Resumes with Score</p>
                                    <p class="mb-2 text-muted">10 Jobs Post</p>
                                    <p class="mb-2 text-muted">Instant Display of Candidates with score (NLP feature)</p>
                                    <p class="mb-2 text-muted">Dashboard Management</p>
                                    <p class="mb-2 text-muted">Social Google/Facebook Login</p>
                                    <p class="mb-2 text-muted">Social App for direct interaction</p>
                                    <p class="mb-2 text-muted">No subscription, cancel anytime</p>
                                    <a class="btn btn-success mt-4 package" data-toggle="modal" data-target="#myModal{{$key}}" id="{{$package->id}}">
                                        <i class="la la-shopping-cart"></i> Go Pro</a>
                                </div>
                                @endif

                                @if($key == 2)
                                <div style="display: grid;">
                                    <p class="mb-2 text-muted">Unlimited Access Resumes with Score</p>
                                    <p class="mb-2 text-muted">Unlimited Jobs Post</p>
                                    <p class="mb-2 text-muted">Single User</p>
                                    <p class="mb-2 text-muted">Instant Display of Candidates with score (NLP feature)</p>
                                    <p class="mb-2 text-muted">Dashboard Management</p>
                                    <p class="mb-2 text-muted">Social Google/Facebook Login</p>
                                    <p class="mb-2 text-muted">Social App for direct interaction</p>
                                    <p class="mb-2 text-muted">E-Mail support.</p>
                                    <p class="mb-2 text-muted">No subscription, cancel anytime</p>
                                    <a class="btn btn-success mt-4 package" data-toggle="modal" data-target="#myModal{{$key}}" id="{{$package->id}}">
                                        <i class="la la-shopping-cart"></i> Go to Business</a>
                                </div>
                                @endif
                            </div>

                            <div id="myModal{{$key}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="modal-body" id="body{{$package->id}}">
                                            <div id="loader{{$package->id}}" class="text-center"></div>
                                        </div>
                                        <!-- <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $(".package").click(function() {
            var id = $(this).attr("id");
            $.ajax({
                type: 'GET',
                url: "/checkout/" + id,
                beforeSend: function() {
                    $("#loader" + id).html('<div class="loader" ></div>');
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#body" + id).html(data);
                }
            });
        })
    })
</script>
@endpush

{{-- col-3 left bar end --}}
{{-- mainfilter --}}
<div class="col-12 my-3">
    <div class="market-overview plrtb-5">
        <div class="card-title mb-2">
            <h2 class="text-center">Trending Searches</h2>
        </div>
        <div class="search-section m-auto" style="width: 90% !important;">
            <div>
                <form action="jobs" name="search_filter" class="" method="get" id="search_filter">
                    <div class="input-group mb-3 mt-4">
                        <input type="text" class="form-control" name="q" placeholder="Job title, keywords or client name">
                        <input type="text" class="form-control" name="location" placeholder="City or state or Zip Code  (optional)">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit"> <i class="fa fa-search"></i>@lang('app.search')</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mat-chip-list layout-row layout-wrap layoutalign-center-center">
                <div class="keyword-btn container">
                    <div class="d-flex justify-content-center mb-2 flex-wrap">
                        @php
                        $i = 0;
                        @endphp
                        @if ($categories->count())
                        @foreach ($categories as $category)
                        <a class="btn btn-success m-1" style="border-radius: 20px;" href="{{ route('jobs_listing', ['category' => $category->id]) }}">
                            {{ $category->category_name }}
                            <span class="text-muted">({{ $category->job_count }})</span>
                        </a>
                        @php
                        if ($i >= 5) {
                        $i = 0;
                        break;
                        } else {
                        $i++;
                        }
                        @endphp
                        @endforeach
                        @endif
                    </div>
                    <div class="d-flex justify-content-center mb-2 flex-wrap">
                        @if ($top_clients->isNotEmpty())
                        @foreach ($top_clients as $top_client)
                        <a class="btn btn-success  m-1" style="border-radius: 20px;" target="_blank" href="{{ route('jobs_by_employer', $top_client->company_slug ?? 0) }}">
                            {{ Functions::str_limit($top_client->company, 15) }} <span class="text-muted">({{ $top_client->job_count }})</span></a>
                        @php
                        if ($i >= 5) {
                        $i = 0;
                        break;
                        } else {
                        $i++;
                        }
                        @endphp
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- mainfilter end --}}
</div>
@endsection