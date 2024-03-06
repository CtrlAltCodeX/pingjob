@extends('layouts.theme')



@section('assets')
    <link rel="stylesheet" href="{{ asset('assets/plugins/awsomplete/css/awesomplete.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@endsection



@section('content')



    <div class="job-view-lead-head bg-light py-4 mb-4">

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="https://pingjob.com"><i class="la la-home"></i> Home</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">{{ $employer->company }}</li>

                        </ol>

                    </nav>

                </div>

            </div>



            <div class="row">

                <div class="col-md-8">
                    <div class="d-flex mb-2">
                        <img src="{{ $employer->logo ? asset('storage/uploads/images/logos/' . $employer->logo) : asset('assets/images/company.png') }}"
                            style="display: inline-block; width:100px;">
                        <div class="ml-2 align-self-end">
                            <h4> {{ $employer->company }}



                                @php $review_total = 5 - round($review_ratings); @endphp

                                @for ($i = 0; $i < round($review_ratings); $i++)
                                    <span><i class="checked la la-star"></i></span>
                                @endfor

                                @for ($i = 0; $i < $review_total; $i++)
                                    <span><i class="unchecked la la-star"></i></span>
                                @endfor



                                @if ($review_count != 0)
                                    <a href="{{ route('user_reviews', ['job_id' => $employer->id, 'employer_id' => $employer->id]) }}"
                                        class="ml-2" style="font-size: 16px; color: rgb(0, 0, 0);">{{ $review_count }}

                                        Reviews</a>
                                @endif

                            </h4>
                            <p class="text-muted">

                                <i class="la la-map-marker"></i>



                                @if ($employer->address)
                                    {!! $employer->address !!}
                                @endif

                                @if ($employer->city)
                                    , {!! $employer->city !!}
                                @endif

                                @if ($employer->state_name)
                                    , {!! $employer->state_name !!}
                                @endif

                                @if ($employer->zip_code)
                                    - {!! $employer->zip_code !!}
                                @endif



                            </p>
                        </div>
                    </div>









                    <p>





                        <a href="{{ route('reviews', ['employer_id' => $employer->id]) }}" class="btn btn-success"><i
                                class="fa fa-star"></i>&nbsp;&nbsp;Write a Review</a>

                        <a data-toggle="modal" style="color:#fff;" data-target="#addVendorModal" class="btn btn-success"><i
                                class="la la-plus"></i>Add Vendor&nbsp;&nbsp;</a>



                        <a data-toggle="modal" style="color:#fff;" data-target="#addContactModal" class="btn btn-success"><i
                                class="la la-plus"></i>Add Contact&nbsp;&nbsp;</a>





                    </p>



                </div>





            </div>

        </div>

    </div>







    <div class="container">

        @include('admin.flash_msg')

        <div class="row">



            @if ($employer->jobs->count())
                <div class="col-md-8">

                    <h3> {{ $employer->company }} Jobs</h3>

                    <div class="employer-job-listing mt-4">
                        {{-- add dedline in place of updated_at if you want to sort according to deadline base --}}
                        @php
                            $jobss = $employer->jobs()->paginate(10);
                        @endphp

                        @foreach ($jobss as $job)
                            <div class="employer-job-listing-single box-shadowco bg-white mb-4 p-3">



                                <h5><a href="{{ route('job_view', $job->job_slug) }}">{!! $job->job_title !!}</a> </h5>



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



                                    <i class="la la-calendar-times-o"></i> @lang('app.deadline') :
                                    {{ Carbon\Carbon::parse($job->deadline)->format(get_option('date_format')) }} <span
                                        class="text-small text-muted">{{ Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</span>

                                </p>









                            </div>
                        @endforeach





                        {{ $jobss->links() }}





                    </div>







                </div>
            @endif

            <div class="col-md-4">

                <div class="row">

                    <div class="col-md-12">

                        @if ($vendors->isNotEmpty())
                            <h3 class="mb-4">{{ $employer->company }} <?php

                            if (request()->segment(1) == 'top-clients') {
                                echo '';
                            } else {
                                echo 'Vendors';
                            }

                            ?> </h3>



                            <div class="widget-box bg-white  mb-4 p-3 box-shadow">



                                @guest

                                    @if (count($vendors) > 2)
                                        <h5>(

                                            <a
                                                href="{{ route('redirect-login', ['slug' => $employer->id, 'page' => 'client_details']) }}">Login</a>

                                            to see

                                            all the {{ $vendors->total() }}

                                            <?php

                                            if (request()->segment(1) == 'top-clients') {
                                                echo 'Clients';
                                            } else {
                                                echo 'vendors';
                                            }

                                            ?> )
                                        </h5>
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
                                                        <span class="float-right">( {{ $vendor->vendor_count }}
                                                            vendors)</span>
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



                    </div>



                    @if ($contacts->isNotEmpty())
                        <div class="col-md-12">





                            <h3 class="mtb-4"> {{ $employer->company }} Contacts</h3>



                            <div class="widget-box bg-white p-3 mb-3 box-shadow">





                                @guest

                                    @if (count($contacts) > 2)
                                        <h5>(

                                            <a
                                                href="{{ route('redirect-login', ['slug' => $employer->id, 'page' => 'client_details']) }}">Login</a>

                                            to see all the {{ count($contacts) }} contacts)
                                        </h5>
                                    @endif

                                @endguest



                                <div class="employer-job-listing mt-4">





                                    <table id="example" class="table table-striped responsive table-bordered nowrap">

                                        <thead>

                                            <tr>

                                                <th>Title</th>

                                                <th>Name</th>

                                                <th>Department</th>

                                                <th>Phone No.</th>

                                                <th>CellPhone No.</th>

                                                <th>Details</th>

                                            </tr>

                                        </thead>

                                        <tbody>



                                            @foreach ($contacts as $contact)
                                                @if (Auth::check())
                                                    <tr class="text-center">

                                                        <th>{{ $contact->title }}</th>

                                                        <th>{{ $contact->first_name }} {{ $contact->middle_name }}
                                                            {{ $contact->last_name }}</th>

                                                        <th>{{ $contact->department }}</th>

                                                        <th>
                                                            <p class="phone">{{ $contact->primary_phone }}</p>
                                                        </th>

                                                        <th>
                                                            <p class="phone">{{ $contact->cell_phone }}</p>
                                                        </th>

                                                        <th>{{ $contact->details }}</th>

                                                    </tr>
                                                @else
                                                    @if ($loop->index < 3)
                                                        <tr class="text-center">

                                                            <th>{{ $contact->title }}</th>

                                                            <th>{{ $contact->first_name }} {{ $contact->middle_name }}
                                                                {{ $contact->last_name }}</th>

                                                            <th>{{ $contact->department }}</th>

                                                            <th>
                                                                <p class="phone">{{ $contact->primary_phone }}</p>
                                                            </th>

                                                            <th>
                                                                <p class="phone">{{ $contact->cell_phone }}</p>
                                                            </th>

                                                            <th>{{ $contact->details }}</th>

                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach





                                        </tbody>

                                    </table>





                                </div>

                            </div>

                        </div>
                    @endif





                </div>

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
                            value="{{ $employer->id }}">

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





                        </div>

                        <div class="modal-footer">

                            <input hidden name="job_id" value="{{ $employer->id }}" />

                            <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('app.close')</button>

                            <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.btn_submit')</button>

                        </div>





                    </form>

                </div>



            </div>

        </div>



    @endsection





    @section('page-js')
        <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

        <script src="{{ asset('assets/plugins/awsomplete/js/awesomplete.js') }}"></script>
        <script type="text/javascript">
            $(function() {



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



        <script>
            $(document).ready(function() {

                $('#example').DataTable();

            });
        </script>



        <script>
            $(".phone").text(function(i, text) {

                text = text.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/, "$1-$2-$3");

                return text;

            });
        </script>
    @endsection
