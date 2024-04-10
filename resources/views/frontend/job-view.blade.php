@extends('layouts.theme')
@section('assets')
    <link rel="stylesheet" href="{{ asset('assets/plugins/awsomplete/css/awesomplete.css') }}">
@endsection
<style>
    .display-comment .display-comment {
        margin-left: 40px
    }
</style>
@section('content')

    @php
        $employer = $job->employer;
    @endphp

    <div class="job-view-lead-head py-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="la la-home"></i>
                                    @lang('app.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{!! $job->job_title !!}</li>
                        </ol>
                    </nav>
                </div>
            </div>


            <!-- apply Vendor modala -->
            <div class="modal fade" id="addVendorModal" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">


                        <form method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="company" class="company" id="company" value="">
                            <input type="hidden" name="employer_id" class="employer_id" id="employer_id"
                                value="{{ $employer?->id }}">
                            <div class="modal-header">
                                <h5 class="modal-title">@lang('app.add_vendor')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    onclick="clearFields();">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                    style="display:none;" id="alert_success">
                                    <span id="vendor_success_msg"></span>
                                    <button type="button" class="close" onclick="close_alert('alert_success')">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                    style="display:none;" id="alert_danger">
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
                                    <input type="text" class="form-control " id="first_name" required
                                        name="first_name" value="" placeholder="First Name">

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


                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="job_id" value={{ $employer?->id }} />
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">@lang('app.close')</button>
                                <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.btn_submit')</button>
                            </div>


                        </form>
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-md-8">
                    <h1 class="text-success">{!! $job->job_title !!}</h1>
                    <div class="reviews mb-1">
                        <h4> {{ $employer?->company }}

                            @php $review_total = 5 - round($review_ratings); @endphp
                            @for ($i = 0; $i < round($review_ratings); $i++)
                                <span><i class="checked la la-star"></i></span>
                            @endfor
                            @for ($i = 0; $i < $review_total; $i++)
                                <span><i class="unchecked la la-star"></i></span>
                            @endfor

                            @if ($review_count != 0)
                                <a href="{{ route('user_reviews', ['job_id' => $job->id, 'employer_id' => $employer->id]) }}"
                                    class="ml-2" style="font-size: 16px; color: rgb(0, 0, 0);">{{ $review_count }}
                                    Reviews</a>
                        </h4>
                        @endif


                    </div>
                    <p class="text-muted">
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

                        <i class="la la-clock-o"></i> @lang('app.posted') {{ $job->created_at->diffForHumans() }}
                    </p>

                    <p>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#applyJobModal">
                            <i class="la la-calendar-plus-o"></i> @lang('app.apply_online') </button>


                        <a href="{{ route('reviews', ['job_id' => $job->id, 'employer_id' => $employer?->id]) }}"
                            class="btn btn-success"><i class="la la-star"></i>&nbsp;Write a Review</a>

                        <a data-toggle="modal" href="#" style="color:#fff;" data-target="#addVendorModal"
                            class="btn btn-success"><i class="la la-plus"></i>Add Vendor&nbsp;&nbsp;</a>

                        <a data-toggle="modal" href="#" style="color:#fff;" data-target="#addContactModal"
                            class="btn btn-success"><i class="la la-plus"></i>Add Contact&nbsp;&nbsp;</a>
                        @php
                            $currentUser = auth()->user();
                        @endphp

                        @if ($currentUser && $currentUser->premium_jobs_balance)
                            <a href="{{ route('employer_applicant_resumes_by_job_id', $job->id) }}" style="color:#fff;"
                                class="btn btn-success"><i class="la la-eye"></i> @lang('app.resumes')
                                ({{ $job->application->count() }})&nbsp;&nbsp;</a>
                        @endif
                        {{-- <a href="{{ route('employer_applicant_resumes_by_job_id', $job->id) }}"></a> --}}
                    </p>
                </div>

                <div class="col-md-4">
                    <div class="job-view-lead-position-box">
                        <p class="text-muted"><strong>@lang('app.about_position')</strong></p>
                        <h5>{{ $job->position }} <span class="text-muted text-small">(@lang('app.' . $job->job_type))</span>
                        </h5>
                        <p class="m-0">
                            <i class="la la-money"></i> {!! get_amount($job->salary, $job->salary_currency) !!} @if ($job->salary_upto)
                                - {!! get_amount($job->salary_upto, $job->salary_currency) !!}
                            @endif
                            / @lang('app.' . $job->salary_cycle)
                        </p>
                        <p class="m-0">
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

                            @if ($job->is_any_where)
                                (@lang('app.anywhere'))
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-md-8">

                @include('admin.flash_msg')


                @if (!$job->is_active() && $job->can_edit())
                    <div class="alert alert-warning">
                        <i class="la la-warning"></i> You are currently viewing this job in private mode. Public will
                        not be able to see this until publish.
                    </div>
                @endif


                <div class="job-view-container box-shadow bg-white p-4 mb-4">

                    <h4 class="text-success">{!! $job->job_title !!}</h4>

                    <p class="text-muted">
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

                        <i class="la la-clock-o"></i> @lang('app.posted') {{ $job->created_at->diffForHumans() }}
                    </p>

                    @if ($job->skills)
                        <div class="job-view-single-section my-4">
                            <h5 class="mb-4">@lang('app.skills')</h5>
                            @php
                                $skills = explode(',', $job->skills);
                            @endphp

                            @if (is_array($skills) && count($skills))
                                @foreach ($skills as $skill)
                                    <span class="single-skill"><i class="la la-lightbulb-o"></i>
                                        {{ $skill }}</span>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    @if ($job->description)
                        <div class="job-view-single-section my-4">
                            <h5 class="mb-4">@lang('app.description')</h5>
                            <p>
                                {!! nl2br($job->description) !!}
                            </p>
                        </div>
                    @endif

                    @if ($job->responsibilities)
                        <div class="job-view-single-section my-4">
                            <h5 class="mb-4">@lang('app.responsibilities')</h5>
                            {!! $job->nl2ulformat($job->responsibilities) !!}
                        </div>
                    @endif

                    @if ($job->educational_requirements)
                        <div class="job-view-single-section my-4">
                            <h5 class="mb-4">@lang('app.educational_requirements')</h5>
                            {!! $job->nl2ulformat($job->educational_requirements) !!}
                        </div>
                    @endif

                    @if ($job->experience_requirements)
                        <div class="job-view-single-section my-4">
                            <h5 class="mb-4">@lang('app.experience_requirements')</h5>
                            {!! $job->nl2ulformat($job->experience_requirements) !!}
                        </div>
                    @endif

                    @if ($job->additional_requirements)
                        <div class="job-view-single-section my-4">
                            <h5 class="mb-4">@lang('app.additional_requirements')</h5>
                            {!! $job->nl2ulformat($job->additional_requirements) !!}
                        </div>
                    @endif

                    @if ($job->benefits)
                        <div class="job-view-single-section my-4">
                            <h5 class="mb-4">@lang('app.benefits')</h5>
                            {!! $job->nl2ulformat($job->benefits) !!}
                        </div>
                    @endif


                    @if ($job->apply_instruction)
                        <div class="alert bg-light mt-4 mb-4">
                            <h5>@lang('app.apply_instruction')</h5>
                            {!! nl2br($job->apply_instruction) !!}

                        </div>
                    @endif


                    <div class="terms-msg mt-5 mb-3">
                        <p class="text-small text-muted font-italic">By applying to a job
                            using {{ get_option('site_name') }} you are agreeing to comply with and be subject to
                            the {{ get_option('site_name') }} <a href="">Terms and Conditions</a> for use of our
                            website.
                            To use our website, you must agree with the <a href="">Terms and Conditions</a> and both
                            meet and comply with their provisions.
                        </p>
                    </div>


                </div>
                <div class="card">
                    <div class="card-body">


                        <h4 class="mb-3">Questions / Comments:</h4>
                        <form method="post" action="{{ route('comment.add') }}">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="comment_body" required type="text" rows="4"
                                    placeholder="Enter your message here"></textarea>

                                <input type="hidden" name="id" value="{{ $job->id }}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Add Comment" />
                            </div>
                        </form>
                        <h4 class="mb-4 mt-5">Display Questions / Comments:</h4>

                        @if ($job->comments->isNotEmpty())
                            @include('partials._comment_replies', [
                                'comments' => $job->comments,
                                'id' => $job->id,
                            ])
                        @else
                            <h5>No Questions / comments</h5>
                        @endif
                        <hr />
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                @if ($vendors->isNotEmpty())
                    <div class="widget-box bg-white p-3 mb-3 box-shadow">
                        <h3>{{ $employer->company }} Vendors</h3>
                        @guest
                            @if (count($vendors) > 2)
                                <h5>( <a
                                        href="{{ route('redirect-login', ['slug' => $job->job_slug, 'page' => 'job_view']) }}">Login</a>
                                    to see
                                    all the {{ $vendors->total() }} vendors)</h5>
                            @endif
                        @endguest
                        <div class="employer-job-listing mt-4">

                            @foreach ($vendors as $vendor)
                                @if (Auth::check())
                                    <div class="employer-job-listing-single box-shadow bg-white mb-4 p-3">
                                        <h5><a href="#">{{ $vendor->company }}</a>

                                            @php
                                                $review_ratings = !empty($vendor->review_rating) ? $vendor->review_rating : 0.0;
                                                $review_total = 5 - round($review_ratings);
                                            @endphp
                                            @for ($i = 0; $i < round($review_ratings); $i++)
                                                <span><i class="checked la la-star"></i></span>
                                            @endfor
                                            @for ($i = 0; $i < $review_total; $i++)
                                                <span><i class="unchecked la la-star"></i></span>
                                            @endfor

                                            <a href="{{ route('reviews', ['employer_id' => $employer->id]) }}"
                                                class="float-right mt-3 writeReview">Write a Review</a>
                                        </h5>
                                        <p class="text-muted">
                                            {{ $vendor->address }}</br>
                                            {{ $vendor->city }}</br>
                                            {{ $vendor->state_name }}</br>
                                            {{ $vendor->website }}
                                            @if ($vendor->vendor_count > 0)
                                                <span class="float-right">( {{ $vendor->vendor_count }} vendors)</span>
                                            @else
                                                <span class="float-right">( No vendors )</span>
                                            @endif
                                        </p>
                                    </div>
                                @else
                                    @if ($loop->index < 3)
                                        <div class="employer-job-listing-single box-shadow bg-white mb-4 p-3">
                                            <h5><a href="#">{{ $vendor->company }}</a>
                                                @php
                                                    $review_ratings = !empty($vendor->review_rating) ? $vendor->review_rating : 0.0;
                                                    $review_total = 5 - round($review_ratings);
                                                @endphp
                                                @php $review_total = 5 - round($review_ratings); @endphp
                                                @for ($i = 0; $i < round($review_ratings); $i++)
                                                    <span><i class="checked la la-star"></i></span>
                                                @endfor
                                                @for ($i = 0; $i < $review_total; $i++)
                                                    <span><i class="unchecked la la-star"></i></span>
                                                @endfor
                                                <br />
                                                <a href="{{ route('reviews', ['employer_id' => $employer->id]) }}"
                                                    class="float-right mt-2 writeReview">Write a Review</a>
                                            </h5>
                                            <p class="text-muted">
                                                {{ $vendor->address }}</br>
                                                {{ $vendor->city }}</br>
                                                {{ $vendor->state_name }}</br>
                                                {{ $vendor->website }}
                                                @if ($vendor->vendor_count > 0)
                                                    <span class="float-right">( {{ $vendor->vendor_count }}
                                                        vendors)</span>
                                                @else
                                                    <span class="float-right">( No vendors )</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            @endforeach

                        </div>
                        <div class="row col">
                            @if (Auth::check())
                                {{ $vendors->links() }}
                            @endif
                        </div>
                    </div>
                @endif




                <div class="widget-box bg-white p-3 mb-3 box-shadow">
                    <h5>@lang('app.job_summery')</h5>

                    @if ($job->vacancy)
                        <p><i class="la la-user"></i> @lang('app.vacancy') : {{ $job->vacancy }} </p>
                    @endif

                    @if ($job->salary)
                        <p>
                            <i class="la la-money"></i> {!! get_amount($job->salary, $job->salary_currency) !!} @if ($job->salary_upto)
                                - {!! get_amount($job->salary_upto, $job->salary_currency) !!}
                            @endif
                            / @lang('app.' . $job->salary_cycle)
                        </p>
                    @endif

                    <p>
                        <i class="la la-briefcase"></i> @lang('app.' . $job->job_type)
                    </p>

                    <p>
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

                        @if ($job->is_any_where)
                            (@lang('app.anywhere'))
                        @endif
                    </p>

                    @if ($job->exp_level)
                        <p><i class="la la-th-list"></i> @lang('app.exp_level') : @lang('app.' . $job->exp_level)</p>
                    @endif

                    @if ($job->experience_required_years)
                        <p>
                            <i class="la la-circle-thin"></i> @lang('app.experience_required')
                            : {{ $job->experience_required_years }}@if ($job->experience_plus)
                                +
                            @endif @lang('app.years')
                        </p>
                    @endif


                    @if ($job->gender)
                        <p>
                            @if ($job->gender != 'any')
                                <i class="la la-arrow-circle-o-right"></i>

                                @lang('app.gender') :

                                <i class="la la-male"></i>
                                <i class="la la-female"></i>
                                <i class="la la-transgender"></i>
                                <span class="text-muted">(@lang('app.' . $job->gender))</span>
                            @else
                                <i class="la la-{{ $job->gender }}"></i> @lang('app.only') @lang('app.' . $job->gender)
                            @endif
                        </p>
                    @endif


                    <p>
                        <i class="la la-clock-o"></i> @lang('app.posted') : {{ $job->created_at->diffForHumans() }}
                    </p>

                    <p>
                        <i class="la la-calendar-times-o"></i> @lang('app.deadline')
                        : {{ Carbon\Carbon::parse($job->deadline)->format(get_option('date_format')) }} <span
                            class="text-small text-muted">{{ Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</span>
                    </p>

                    <p><i class="la la-tag"></i> @lang('app.job_id') : {{ $job->job_id }}</p>

                    <p>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#applyJobModal">
                            <i class="la la-calendar-plus-o"></i> @lang('app.apply_online') </button>
                    </p>

                </div>


                <div class="widget-box bg-white p-3 mb-3 box-shadow">

                    <div class="job-view-company-logo mb-3">
                        <img src="{{ $employer?->logo_url }}" class="img-fluid" />
                    </div>

                    <h5>{{ $employer?->company }}</h5>

                    <p class="text-muted">
                        <i class="la la-map-marker"></i>

                        @if ($employer?->address)
                            {!! $employer?->address !!}
                            @if ($employer?->address_2)
                                , {!! $employer?->address_2 !!}
                            @endif
                        @else
                            @if ($employer?->city)
                                {!! $employer?->city !!},
                            @endif
                            @if ($employer?->state_name)
                                {!! $employer?->state_name !!},
                            @endif
                            @if ($employer?->state_name)
                                {!! $employer?->country_name !!}
                            @endif
                        @endif
                    </p>

                    @if ($employer?->company_size)
                        <p>
                            <i class="la la-building"></i> {{ company_size($employer?->company_size) }} @lang('app.employees')
                        </p>
                    @endif

                    @if ($employer?->phone)
                        <p class="phone"><i class="la la-phone"></i> {{ $employer?->phone }} </p>
                    @endif

                    @if ($employer?->about_company)
                        <p>{{ $employer?->about_company }}</p>
                    @endif

                    @if ($employer?->website)
                        <p><a href="{{ $employer?->website }}"><i class="la la-globe"></i> {{ $employer?->website }}</a>
                        </p>
                    @endif

                    {{--
                                        <p>
                                            @if ($job->employer->followable)
    @if (auth()->check() &&
    auth()->user()->isEmployerFollowed($job->employer->id))
    <button type="button" class="btn btn-success employer-follow-button"
                                                            data-employer-id="{{ $job->employer->id }}"><i
                                                                class="la la-minus-circle"></i> @lang('app.unfollow') {{ $employer->company }}
                                                    </button>
@else
    <button type="button" class="btn btn-success employer-follow-button"
                                                            data-employer-id="{{ $job->employer->id }}"><i
                                                                class="la la-plus-circle"></i> @lang('app.follow') {{ $employer->company }}
                                                    </button>
    @endif
    @endif
                                        </p>

                    --}}
                </div>


                <div class="widget-box bg-white p-3 box-shadow">

                    <div class="additional-job-action-box">

                        <p><a href="javascript:;" data-toggle="modal" data-target="#shareByEMail"><i
                                    class="la la-envelope"></i> @lang('app.share_by_email') </a></p>
                        <p><a href="{{ route('jobs_by_employer', $job->employer->company_slug ?? 0) }}"><i
                                    class="la la-list-ul"></i> @lang('app.check_all_job_employer') </a></p>
                        <p><a href="javascript:;" data-toggle="modal" data-target="#jobFlagModal"><i
                                    class="la la-flag"></i> @lang('app.flag_this_job') </a></p>

                    </div>
                </div>

                <div class="widget-box bg-white p-3 mb-3 box-shadow">
                    <div class="modern-social-share-wrap">
                        <a href="#" class="btn btn-primary share s_facebook"><i class="la la-facebook"></i> </a>

                        <a href="#" class="btn btn-info share s_twitter"><i class="la la-twitter"></i> </a>
                        <a href="#" class="btn btn-primary share s_linkedin"><i class="la la-linkedin"></i> </a>
                    </div>
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

                        <input type="hidden" name="job_id" value="{{ $job->id }}" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.apply_online')</button>
                    </div>


                </form>
            </div>

        </div>
    </div>



    <div class="modal fade" id="jobFlagModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('flag_job_post', $job->id) }}" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">@lang('app.flag_this_job')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">@lang('app.reason'):</label>
                            <select class="form-control  {{ e_form_invalid_class('reason', $errors) }}" name="reason">
                                <option value="">@lang('app.select_a_reason')</option>
                                <option value="applying_problem">@lang('app.applying_problem')</option>
                                <option value="fraud">@lang('app.fraud')</option>
                                <option value="duplicate">@lang('app.duplicate')</option>
                                <option value="spam">@lang('app.spam')</option>
                                <option value="wrong_category">@lang('app.wrong_category')</option>
                                <option value="offensive">@lang('app.offensive')</option>
                                <option value="other">@lang('app.other')</option>
                            </select>
                            {!! e_form_error('reason', $errors) !!}
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control  {{ e_form_invalid_class('email', $errors) }}"
                                name="email">
                            {!! e_form_error('email', $errors) !!}
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control  {{ e_form_invalid_class('message', $errors) }}" name="message"></textarea>
                            {!! e_form_error('message', $errors) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-success"><i class="la la-flag-o"></i>
                            @lang('app.flag_this_job')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="shareByEMail" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">@lang('app.share_by_email')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('share_by_email') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">@lang('app.receiver_name'):</label>
                            <input type="text"
                                class="form-control {{ e_form_invalid_class('receiver_name', $errors) }}"
                                name="receiver_name">
                            {!! e_form_error('receiver_name', $errors) !!}
                        </div>

                        <div class="form-group">
                            <label class="control-label">@lang('app.receiver_email'):</label>
                            <input type="text"
                                class="form-control {{ e_form_invalid_class('receiver_email', $errors) }}"
                                name="receiver_email">
                            {!! e_form_error('receiver_email', $errors) !!}
                        </div>

                        <div class="form-group">
                            <label class="control-label">@lang('app.your_name'):</label>
                            <input type="text" class="form-control {{ e_form_invalid_class('your_name', $errors) }}"
                                name="your_name">
                            {!! e_form_error('your_name', $errors) !!}
                        </div>

                        <div class="form-group">
                            <label class="control-label">@lang('app.your_email'):</label>
                            <input type="text" class="form-control {{ e_form_invalid_class('your_email', $errors) }}"
                                name="your_email">
                            {!! e_form_error('your_email', $errors) !!}
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="job_id" value="{{ $job->id }}" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary"
                            id="reply_by_email_btn">@lang('app.send_email')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






@endsection


@section('page-js')
    <script src="{{ asset('assets/plugins/SocialShare/SocialShare.js') }}" defer></script>


    <script src="{{ asset('assets/plugins/awsomplete/js/awesomplete.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var input = document.getElementById("vendor");
            var jsonfile = <?php echo json_encode($company); ?>;
            var as = $.makeArray(jsonfile);
            listArray = [];
            $.each(as, function(key, data) {
                if (data['company']) {
                    listArray.push(data['company']);
                }
            });

            new Awesomplete(input, {
                list: listArray
            });

            $("#vendor").on('awesomplete-selectcomplete', function() {
                $('.company').val(this.value);
            });
        });
    </script>

    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', function() {
            (function($) {
                $('.share').ShareLink({
                    title: '{{ $job->job_title }}', // title for share message
                    text: '{{ substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($job->description))), 0, 160) }}', // text for share message
                    url: '{{ route('job_view', $job->job_slug) }}', // link on shared page
                    class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
                    width: 640, // optional popup initial width
                    height: 480 // optional popup initial height
                })

            })(jQuery);
        });
    </script>

    <script>
        $(".phone").text(function(i, text) {
            text = text.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/, "$1-$2-$3");
            return text;
        });
    </script>
@endsection
