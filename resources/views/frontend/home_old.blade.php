@extends('layouts.theme')


@section('content')

    <div class="home-hero-section">


        <div class="job-search-bar">

            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2 style="font-weight:bold;">Find the job that you deserve</h2>
                        <p class="mt-4 mb-4 job-search-sub-text">Search For</p>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-12">


                        <form action="#" name="myForm"  class="form-inline" method="get" id="search_form">
                            <div class="form-row">
                                <div class="col-auto">
                                    <div class="custom-control custom-radio custom-control-inline"><input type="radio"
                                                                                                          id="customRadio1"
                                                                                                          checked="checked"
                                                                                                          name="search_category"
                                                                                                          class="custom-control-input search_type"
                                                                                                          value="job">
                                        <label for="customRadio1" class="custom-control-label">Jobs</label></div>
                                    <div class="custom-control custom-radio custom-control-inline"><input type="radio"
                                                                                                          id="customRadio2"
                                                                                                          name="search_category"
                                                                                                          class="custom-control-input search_type"
                                                                                                          value="client">
                                        <label for="customRadio2" class="custom-control-label">Clients</label></div>
                                    <div class="mt-4">
                                        <input type="text" required name="q" class="form-control mb-2"
                                               style="min-width: 300px;border: 1px solid #38c172;"
                                               placeholder="@lang('app.job_title_placeholder')">
                                        <input type="text" required name="location" class="form-control"
                                               style="min-width: 300px;border: 1px solid #38c172;"
                                               placeholder="@lang('app.job_location_placeholder')">
                                        <button type="button" class="btn btn-success mb-2 search_submit"><i
                                                    class="la la-search"></i> @lang('app.search')
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>



    <div class="regular-jobs-wrap bg-white pb-5 pt-5">
        <div class="container">
            <div class="regular-job-container p-3">
                <div class="row">


                    @include('admin.flash_msg')
                    @if($premium_jobs->count())
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-5">
                            <table id="example" class="table table-striped responsive  table-bordered  nowrap" style="    width: 100%!important;">
                                <div class="pricing-section-heading mb-5 text-center">

                        <h1 style="font-weight:bold;">Newest jobs</h1>

                    </div>

                                <thead>
                                <tr>
                                    <th>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                      <th>Title</th>


                                    <th>Client</th>
                              <th>Resume</th>

                                    <th>Location</th>
                                   <th>Apply</th>



                                </tr>
                                </thead>
                                <tbody>
                                @foreach($premium_jobs as $job)
                                    <tr>
                                        <td>

                                        {{ date('M-d', strtotime($job->created_at)) }}

                                       </td>


                                         <td><a style="color:#000; font-size:18px;"
                                               href="{{route('job_view', $job->job_slug)}}">{!! $job->job_title !!}</a>
                                        </td>



                                        <td>

                                              <a  style="font-size:18px;"href="{{ route('clients_details', ['employer_id' => $job->user_id]) }}">

                                     {!! $job->company !!}</a>
                                            </td>

                                           <td>{!! $job->job_applications_count !!}</td>




                                        <td>@if($job->city_name)
                                                {!! $job->city_name !!},
                                            @endif
                                            @if($job->state_name)
                                                {!! $job->state_name !!}
                                            @endif
                                        </td>

                                            <td>
                                            <button class="btn btn-success" data-toggle="modal"
                                                    data-jobid=' {!! $job->id !!}' data-target="#applyJobModal">Apply
                                            </button>

                                        </td>


                                    </tr>

                                @endforeach

                                </tbody>
                            </table>

                        </div>
             @endif


<hr>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="pricing-section-heading mb-5 text-center">

                        <h1 style="font-weight:bold;">Top Clients</h1>

                    </div>
                        <table id="example1" class="table table-striped responsive ordering table-bordered nowrap ">

                            <thead>
                            <tr>
                                <th>Client</th>
                                 <th>Job(s)</th>
                                 <th>Vendor(s)</th>
                                <th>Ratings(s)</th>

            <th>Resume</th>


                            </tr>
                            </thead>
                            <tbody>


                            @if($top_clients->isNotEmpty())
                                @foreach($top_clients as $top_client)
                                    <tr>
                                        <td>
                                            <a  style="font-size:18px;" href="{{ route('clients_details', ['employer_id' =>$top_client->id]) }}">{{ $top_client->company }}</a>
                                        </td>
                                             <td><a id="jobapplytxt" style="text-decoration:none;color:#165c98;"
                                               target="_blank"
                                               href="{{route('jobs_by_employer', $top_client->company_slug)}}">{{ $top_client->job_count }}</a>


                                        </td>
                                         <td>{{ $top_client->vendor_count }}</td>

                                                <td>{{ !empty($top_client->review_rating) ? round($top_client->review_rating) : 0 }}</a></td>



                                   <td>{{ $top_client -> applications_count }}</td>
                                    </tr>
                                @endforeach
                            @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <div class="new-registration-page  pb-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="home-register-account-box">
                        <h4>@lang('app.job_seeker')</h4>
                        <p class="box-icon"><img src="{{asset('assets/images/employee.png')}}"/></p>
                        <p>@lang('app.job_seeker_new_desc')</p>
                        <a href="{{route('register_job_seeker')}}" class="btn btn-success"><i
                                    class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="home-register-account-box">
                        <h4>@lang('app.employer')</h4>
                        <p class="box-icon"><img src="{{asset('assets/images/enterprise.png')}}"/></p>
                        <p>@lang('app.employer_new_desc')</p>
                        <a href="{{route('register_employer')}}" class="btn btn-success"><i
                                    class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="home-register-account-box">
                        <h4>@lang('app.agency')</h4>
                        <p class="box-icon"><img src="{{asset('assets/images/agent.png')}}"/></p>
                        <p>@lang('app.agency_new_desc')</p>
                        <a href="{{route('register_agent')}}" class="btn btn-success"><i
                                    class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="pricing-section bg-white pb-5 pt-5">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <div class="pricing-section-heading mb-5 text-center">

                        <h1 style="font-weight:bold;">Pricing</h1>
                        <h5 class="text-muted">Choose a package to unlock Job Posting ability.</h5>
                        <h5 class="text-muted">To get a large amount of quality application, choose the premium package</h5>
                    </div>

                </div>
            </div>


            <div class="row">



                @foreach($packages as $package)
                    <div class="col-xs-12 col-md-4">
                        <div class="pricing-table-wrap bg-light pt-5 pb-5 text-center">
                            <h1 class="display-4">{!! get_amount($package->price) !!}</h1>
                            <h3>{{$package->package_name}}</h3>
                            <div class="pricing-package-ribbon pricing-package-ribbon-green">Premium</div>

                            <p class="mb-2 text-muted"> {{$package->premium_job}} Jobs Post</p>

                            <p class="mb-2 text-muted"> Unlimited Applicants</p>
                            <p class="mb-2 text-muted"> Dashboard access to manage application</p>
                            <p class="mb-2 text-muted"> E-Mail support available</p>
                            <a href="{{route('checkout', $package->id)}}" class="btn btn-success mt-4"> <i class="la la-shopping-cart"></i> Purchase Package</a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>



    @if($categories->count())
        <div class="home-categories-wrap pb-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-3">Categories</h4>
                    </div>
                </div>

                <div class="row">

                    @foreach($categories as $category)
                        <div class="col-md-4">

                            <p>
                                <a href="{{route('jobs_listing', ['category' => $category->id])}}"
                                   class="category-link"><i class="la la-th-large"></i> {{$category->category_name}}
                                    <span class="text-muted">({{$category->job_count}})</span> </a>
                            </p>

                        </div>

                    @endforeach

                </div>

            </div>
        </div>
    @endif


    <!-- apply job modala -->
    <div class="modal fade" id="applyJobModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form action="{{route('apply_job')}}" method="post" id="applyJob" enctype="multipart/form-data">
                    @csrf


                    <div class="modal-header">
                        <h5 class="modal-title">@lang('app.online_job_application_form')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">


                        @if(session('error'))
                            <div class="alert alert-warning">{{session('error')}}</div>
                        @endif

                        <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
                            <label for="name" class="control-label">@lang('app.name'):</label>
                            <input type="text" class="form-control {{e_form_invalid_class('name', $errors)}}" id="name"
                                   name="name" value="@if(Auth::check()) {{ $name = Auth::user()->name}} @else
    {{old('name') }}
@endif" placeholder="@lang('app.your_name')">
                            {!! e_form_error('name', $errors) !!}
                        </div>

                        <div class="form-group {{ $errors->has('email')? 'has-error':'' }}">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control {{e_form_invalid_class('email', $errors)}}"
                                   id="email" name="email" value="@if(Auth::check()) {{ $email = Auth::user()->email}} @else
    {{old('email') }}
@endif"   placeholder="@lang('app.email_ie')">
                            {!! e_form_error('email', $errors) !!}
                        </div>

                        <div class="form-group {{ $errors->has('phone_number')? 'has-error':'' }}">
                            <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                            <input type="text" class="form-control {{e_form_invalid_class('phone_number', $errors)}}"
                                   id="phone_number" name="phone_number" value="@if(Auth::check()) {{ $phone = Auth::user()->phone}} @else
    {{old('phone_number') }}
@endif"
                                   placeholder="@lang('app.phone_number')">
                            {!! e_form_error('phone_number', $errors) !!}
                        </div>

                        <div class="form-group {{ $errors->has('message')? 'has-error':'' }}">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control {{e_form_invalid_class('message', $errors)}}" id="message"
                                      name="message"
                                      placeholder="@lang('app.your_message')">{{old('message')}}</textarea>
                            {!! e_form_error('message', $errors) !!}
                        </div>

                        <div class="form-group {{ $errors->has('resume')? 'has-error':'' }}">
                            <label for="resume" class="control-label">@lang('app.resume'):</label>
                            <input type="file" class="form-control {{e_form_invalid_class('resume', $errors)}}"
                                   id="resume" name="resume">
                            <p class="text-muted">@lang('app.resume_file_types')</p>
                            {!! e_form_error('resume', $errors) !!}
                        </div>


                        <input type="hidden" name="job_id" id="job_id" value="">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.apply_online')</button>
                    </div>


                </form>

            </div>

        </div>
    </div>




@endsection

@section('page-js')




    <script type="text/javascript">

      $(document).ready(function () {


        $('.search_submit').on('click', function () {

          if (document.getElementById('customRadio1').checked) {
            search_type = document.getElementById('customRadio1').value;
          } else {
            search_type = document.getElementById('customRadio2').value;
          }

          if (search_type == 'job') {
            $('#search_form').attr('action', '{{ route('jobs_listing') }}');
            $('#search_form').submit();
          } else {
            $('#search_form').attr('action', '{{ route('clients_listing') }}');
            $('#search_form').submit();
          }


        });
      });

    </script>




@endsection
