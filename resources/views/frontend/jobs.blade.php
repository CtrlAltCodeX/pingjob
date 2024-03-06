@extends('layouts.theme')
@section('assets')
    <link rel="stylesheet" href="{{ asset('assets/plugins/awsomplete/css/awesomplete.css') }}">
@endsection
@section('content')


    <div class="blog-listing-header ">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h1>@lang('app.search_jobs')</h1>
                    <h5>Filter from the left sidebar to find your desired job</h5>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">

            <div class="col-md-4">


                <div class="jobs-filter-form-wrap bg-white p-4 mt-4 mb-4">

                    <h4 class="mb-4">@lang('app.filter_jobs')</h4>

                    <form action="" method="get">

                        <div class="form-group">
                            <p class="text-muted mb-1">@lang('app.keywords')</p>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                style="min-width: 300px;" placeholder="@lang('app.job_title_placeholder')">
                        </div>




                        <div class="form-group">
                            <p class="text-muted mb-1">@lang('app.job_type')</p>

                            <select class="form-control" name="job_type" id="job_type">
                                <option value="">@lang('app.select_job_type')</option>
                                <option value="full_time" {{ request('job_type') == 'full_time' ? 'selected' : '' }}>
                                    @lang('app.full_time')</option>
                                <option value="internship" {{ request('job_type') == 'internship' ? 'selected' : '' }}>
                                    @lang('app.internship')</option>
                                <option value="part_time" {{ request('job_type') == 'part_time' ? 'selected' : '' }}>
                                    @lang('app.part_time')</option>
                                <option value="contract" {{ request('job_type') == 'contract' ? 'selected' : '' }}>
                                    @lang('app.contract')</option>
                                <option value="temporary" {{ request('job_type') == 'temporary' ? 'selected' : '' }}>
                                    @lang('app.temporary')</option>
                                <option value="commission" {{ request('job_type') == 'commission' ? 'selected' : '' }}>
                                    @lang('app.commission')</option>
                                <option value="internship" {{ request('job_type') == 'internship' ? 'selected' : '' }}>
                                    @lang('app.internship')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <p class="text-muted mb-1">@lang('app.category')</p>

                            <select class="form-control" name="category" id="category">
                                <option value="">@lang('app.select_category')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ selected($category->id, request('category')) }}>
                                        {{ $category->category_name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <p class="text-muted mb-1">@lang('app.country')</p>

                            <select name="country"
                                class="form-control {{ e_form_invalid_class('country', $errors) }} country_to_state">
                                <option value="">@lang('app.select_a_country')</option>
                                @foreach ($countries as $country)
                                    <option value="{!! $country->id !!}"
                                        @if (request('country') && $country->id == request('country')) selected="selected" @endif>{!! $country->country_name !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <p class="text-muted mb-1">@lang('app.state')</p>

                            <select name="state"
                                class="form-control {{ e_form_invalid_class('state', $errors) }} state_options">
                                <option value="">Select a state</option>

                                @if ($old_country)
                                    @foreach ($old_country->states as $state)
                                        <option value="{{ $state->id }}"
                                            @if (request('state') && $state->id == request('state')) selected="selected" @endif>
                                            {!! $state->state_name !!}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <p class="text-muted mb-1">@lang('app.location')</p>
                            <input type="text" name="location" value="{{ request('location') }}" class="form-control"
                                style="min-width: 300px;" placeholder="@lang('app.job_location_placeholder')">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="la la-search"></i>
                                @lang('app.filter_jobs')</button>
                            <a href="{{ route('jobs_listing') }}" class="btn btn-info text-white"><i
                                    class="la la-eraser"></i> @lang('app.clear_filter')</a>
                        </div>
                    </form>

                </div>

            </div>

            <div class="col-md-8">

                <div class="employer-job-listing mt-4">

                    @include('admin.flash_msg')

                    @if ($jobs->count())
                        <div class="job-search-stats bg-white mb-3 p-4">
                            {!! sprintf(__('app.job_search_stats'), '<strong>', $jobs->total(), '</strong>') !!}
                        </div>

                        @foreach ($jobs as $job)
                            <div
                                class="employer-job-listing-single {{ $job->is_premium ? ' premium-job ' : '' }} box-shadow bg-white mb-3 p-3">

                                @if ($job->is_premium)
                                    <div class="job-listing-company-logo">
                                        <a href="{{ route('job_view', $job->job_slug) }}">
                                            <img src="{{ $job?->employer?->logo_url }}" class="img-fluid" />
                                        </a>
                                    </div>
                                @endif

                                <div class="listing-job-info">

                                    <h5><a href="{{ route('job_view', $job->job_slug) }}">{!! $job->job_title !!}</a></h5>
                                    <p class="text-muted mb-1 mt-1">

                                        <i class="la la-clock-o"></i> @lang('app.posted')
                                        {{ $job->created_at->diffForHumans() }}

                                        <i class="la la-calendar-times-o"></i> @lang('app.deadline')
                                        : {{ Carbon\Carbon::parse($job->deadline)->format(get_option('date_format')) }}
                                        <span
                                            class="text-small text-muted">{{ Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</span>
                                    </p>

                                    @if ($job->is_premium)
                                        @if ($job->salary)
                                            <p class="text-muted mb-1 mt-1">
                                                <i class="la la-money"></i>


                                                {!! get_amount($job->salary, $job->salary_currency) !!} @if ($job->salary_upto)
                                                    - {!! get_amount($job->salary_upto, $job->salary_currency) !!}
                                                @endif




                                                / @lang('app.' . $job->salary_cycle)
                                        @endif

                                        @if ($job->exp_level)
                                            <i class="la la-th-list"></i> @lang('app.exp_level')
                                            : @lang('app.' . $job->exp_level)
                                            </p>
                                        @endif
                                    @endif


                                    <p class="text-muted">
                                        <i class="la la-building-o"></i> {{ $job?->employer?->company }}
                                        <i class="la la-briefcase"></i> @lang('app.' . $job->job_type)
                                        <i class="la la-map-marker"></i>
                                        @if ($job->city_name)
                                            {!! $job->city_name !!},
                                        @endif
                                        @if ($job->state_name)
                                            {!! $job->state_name !!},
                                        @endif
                                        @if ($job->country_name)
                                            {!! $job->country_name !!}
                                        @endif
                                    </p>
                                    <button class="btn btn-success" data-toggle="modal"
                                        data-jobid=' {!! $job->id !!}' data-target="#applyJobModal">Apply
                                    </button>


                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <a
                                                href="{{ route('reviews', ['job_id' => $job->id, 'employer_id' => $job?->employer?->id]) }}"><i
                                                    class="la la-star"></i>&nbsp;Write a Review</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a data-toggle="modal" href="#"
                                                data-employerid="{{ $job?->employer?->id }}"
                                                data-target="#addVendorModal"><i class="la la-plus"></i>Add
                                                Vendor&nbsp;&nbsp;</a>
                                        </div>



                                        <div class="col-md-4">

                                            <a data-toggle="modal" href="#"
                                                data-catid='{{ $job?->employer?->id }}' data-target="#addContactModal"><i
                                                    class="la la-plus"></i> Add Contact
                                            </a>


                                        </div>



                                    </div>


                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-search-results-wrap text-center">

                            <p class="p-4">
                                <img src="{{ asset('assets/images/no-search.png') }}" />
                            </p>

                            <h3>Whoops, no matches</h3>
                            <h5 class="text-muted">We couldn't find any search results. </h5>
                            <h5 class="text-muted">Give it another try</h5>

                        </div>
                    @endif


                    {{ $jobs->appends(request()->except('page'))->links() }}





                </div>

            </div>
        </div>
    </div>


    <!-- apply job modala -->
    <div class="modal fade" id="applyJobModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form action="{{ route('apply_job') }}" method="post" id="applyJob" enctype="multipart/form-data">
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.apply_online')</button>
                    </div>


                </form>

            </div>

        </div>
    </div>



    <!-- apply Vendor modala -->
    <div class="modal fade" id="addVendorModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <form method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="modal-header">
                        <h5 class="modal-title">@lang('app.add_vendor')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="clearFields();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="company" class="company" id="company" value="">
                        <input type="hidden" name="employer_id" class="employer_id" id="employer_id" value="">

                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;"
                            id="alert_success">
                            <span id="vendor_success_msg"></span>
                            <button type="button" class="close" onclick="close_alert('alert_success')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;"
                            id="alert_danger">
                            <span id="vendor_error_msg"></span>
                            <button type="button" class="close" onclick="close_alert('alert_danger')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">Vendor Name:</label>
                            <input type="text" class="form-control" id="vendor" name="vendor" value=""
                                placeholder="Vendor name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            onclick="clearFields();">Close
                        </button>
                        <button type="button" class="btn btn-primary vendor_submit_btn" id="report_ad">Submit
                        </button>
                    </div>


                </form>
            </div>

        </div>
    </div>


    <!-- apply contact modala -->
    <div class="modal fade" id="addContactModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('add_contact') }}" method="post">
                    @csrf


                    <div class="modal-header">
                        <h5 class="modal-title">@lang('app.add_contact_info')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">


                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.title')*</label>
                            <input type="text" class="form-control " id="title" name="title" required
                                value="" placeholder="Title">

                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.first_name')*</label>
                            <input type="text" class="form-control " id="first_name" required name="first_name"
                                value="" placeholder="First Name">

                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.middle_name')</label>
                            <input type="text" class="form-control " id="middle_name" name="middle_name"
                                value="" placeholder="Middle Name">

                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.last_name')</label>
                            <input type="text" class="form-control " id="last_name" name="last_name"
                                placeholder="Last Name">

                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.department')</label>
                            <input type="text" class="form-control " id="department" name="department"
                                placeholder="Department">

                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.phone')</label>
                            <input type="number" class="form-control " id="primary_phone" name="primary_phone"
                                value="" placeholder="Primary Phone">

                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.cell_phone')</label>
                            <input type="number" class="form-control " id="cellphone" name="cell_phone"
                                placeholder="Cellphone">

                        </div>


                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.email')*</label>
                            <input type="email" class="form-control " id="email" name="email" required
                                placeholder="Email">

                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label">@lang('app.details')</label>
                            <textarea type="text" class="form-control " id="details" name="details" placeholder="Details"></textarea>



                        </div>

                        <input type="hidden" name="job_id" id="cat_id" value="">


                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.btn_submit')</button>
                    </div>


                </form>
            </div>

        </div>
    </div>


@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/awsomplete/js/awesomplete.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var input = document.getElementById("vendor");
            var jsonfile = <?php echo json_encode($company); ?>;
            var as = $.makeArray(jsonfile);

            listArray = [];
            $.each(as, function(key, data) {
                listArray.push(data['company']);
            });

            new Awesomplete(input, {
                list: listArray
            });

            $("#vendor").on('awesomplete-selectcomplete', function() {
                $('.company').val(this.value);
            });

            $('#addVendorModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);

                console.log(button);

                var employer_id = button.data('employerid');
                var modal = $(this);
                modal.find('.modal-body #employer_id').val(employer_id);
            })


        });
    </script>
@endsection
