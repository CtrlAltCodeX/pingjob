@extends('layouts.dashboard')

@section('page-css')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">


            <form action="" method="post" enctype="multipart/form-data">
                @csrf



                <h4 style="margin-top:20px;margin-bottom:20px;color:#38c172;"> Personal Information</h4>
                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name" class="col-sm-4 control-label">@lang('app.name')<span class="mendatory-mark"
                            style="color:red;">&nbsp;*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name"
                            value="{{ old('name') ? old('name') : $user->name }}" name="name"
                            placeholder="@lang('app.name')">
                        {!! e_form_error('name', $errors) !!}
                    </div>
                </div>

                @if ($user->is_user())
                    <div class="form-group row {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label for="first_name" class="col-sm-4 control-label">@lang('app.first_name')<span class="mendatory-mark"
                                style="color:red;">&nbsp;*</span></label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control" id="first_name"
                                value="{{ !empty($user->first_name) ? $user->first_name : '' }}" name="first_name"
                                placeholder="@lang('app.first_name')">
                            {!! e_form_error('first_name', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label for="last_name" class="col-sm-4 control-label">@lang('app.last_name')<span class="mendatory-mark"
                                style="color:red;">&nbsp;*</span></label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control" id="last_name"
                                value="{{ !empty($user->last_name) ? $user->last_name : '' }}" name="last_name"
                                placeholder="@lang('app.last_name')">
                            {!! e_form_error('first_name', $errors) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group row {{ $errors->has('gender') ? 'has-error' : '' }}">
                    <label for="gender" class="col-sm-4 control-label">@lang('app.gender')<span class="mendatory-mark"
                            style="color:red;">&nbsp;*</span></label>
                    <div class="col-sm-8">
                        <select id="gender" required name="gender" class="form-control select2">
                            <option value="">Select Gender</option>
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Fe-Male</option>


                        </select>
                        {!! e_form_error('gender', $errors) !!}
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="col-sm-4 control-label">@lang('app.email')</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email"
                            value="{{ old('email') ? old('email') : $user->email }}" name="email"
                            placeholder="@lang('app.email')">
                        {!! e_form_error('email', $errors) !!}
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone" class="col-sm-4 control-label">@lang('app.phone_no')</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="phone"
                            value="{{ !empty($user->phone) ? $user->phone : '' }}" name="phone"
                            placeholder="@lang('app.phone_no')">
                        {!! e_form_error('phone', $errors) !!}
                    </div>
                </div>

                @if ($user->is_user())
                    <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                        <label for="mobile_no" class="col-sm-4 control-label">@lang('app.mobile_no')</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="mobile_no"
                                value="{{ !empty($user->mobile_no) ? $user->mobile_no : '' }}" name="mobile_no"
                                placeholder="@lang('app.mobile_no')">
                            {!! e_form_error('mobile_no', $errors) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address" class="col-sm-4 control-label">@lang('app.address')<span class="mendatory-mark"
                            style="color:red;">&nbsp;*</span></label>
                    <div class="col-sm-8">
                        <input type="text" required class="form-control" id="address"
                            value="{{ !empty($user->address) ? $user->address : '' }}" name="address"
                            placeholder="@lang('app.address')">
                        {!! e_form_error('address', $errors) !!}
                    </div>
                </div>

                @if ($user->is_user())
                    <div class="form-group row {{ $errors->has('address_2') ? 'has-error' : '' }}">
                        <label for="address_2" class="col-sm-4 control-label">@lang('app.address_2')</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="address_2"
                                value="{{ !empty($user->address_2) ? $user->address_2 : '' }}" name="address_2"
                                placeholder="@lang('app.address_2')">
                            {!! e_form_error('address_2', $errors) !!}
                        </div>
                    </div>
                @endif


                <div class="form-group row {{ $errors->has('country') ? 'has-error' : '' }}">
                    <label for="country" class="col-md-4 control-label">{{ __('app.country') }} </label>
                    <div class="col-md-8">
                        <select required name="country"
                            class="form-control {{ e_form_invalid_class('country', $errors) }} country_to_state">
                            <option value="">@lang('app.select_a_country')</option>
                            @foreach ($countries as $country)
                                <option value="{!! $country->id !!}" {{ selected($country->id, $user->country_id) }}>
                                    {!! $country->country_name !!}</option>
                            @endforeach
                        </select>

                        {!! e_form_error('country', $errors) !!}
                    </div>
                </div>


                @if ($user->is_user())
                    <div class="form-group row {{ $errors->has('zip_code') ? 'has-error' : '' }}">
                        <label for="zip_code" class="col-sm-4 control-label">@lang('app.zip_code')</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="zip_code"
                                value="{{ !empty($user->zip_code) ? $user->zip_code : '' }}" name="zip_code"
                                placeholder="@lang('app.zip_code')">
                            {!! e_form_error('zip_code', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('desired_position') ? 'has-error' : '' }}">
                        <label for="desired_position" class="col-sm-4 control-label">@lang('app.desired_position')<span
                                class="mendatory-mark" style="color:red;">&nbsp;*</span></label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control" id="desired_position"
                                value="{{ !empty($user->desired_position) ? $user->desired_position : '' }}"
                                name="desired_position" placeholder="@lang('app.desired_position')">
                            {!! e_form_error('desired_position', $errors) !!}
                        </div>
                    </div>


                    <div class="form-group row {{ $errors->has('date_available') ? 'has-error' : '' }}">
                        <label for="date_available" class="col-sm-4 control-label">@lang('app.date_available')<span
                                class="mendatory-mark" style="color:red;">&nbsp;*</span></label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control date_picker" id="date_available"
                                value="{{ !empty($user->date_available) ? $user->date_available : '' }}"
                                name="date_available" placeholder="@lang('app.date_available')">
                            {!! e_form_error('date_available', $errors) !!}
                        </div>
                    </div>



                    <h4 style="margin-top:20px;margin-bottom:20px;color:#38c172;"> Employment Type</h4>


                    <div class="form-group row {{ $errors->has('annual_salary') ? 'has-error' : '' }}">
                        <label for="mobile_no" class="col-sm-4 control-label">@lang('app.annual_salary')<span
                                class="mendatory-mark" style="color:red;">&nbsp;*</span></label>
                        <div class="col-sm-8">

                            <select name="annual_salary" required id="annual_salary" required
                                class="form-control select2">
                                <option value="">-Ex 9000-</option>
                                <option value="<5000" {{ $user->annual_salary == '<5000' ? 'selected' : '' }}>
                                    <5000< /option>
                                <option value="5000-10000" {{ $user->annual_salary == '5000-10000' ? 'selected' : '' }}>
                                    5000-10000</option>
                                <option value="10000-20000" {{ $user->annual_salary == '10000-20000' ? 'selected' : '' }}>
                                    10000-20000
                                </option>

                                <option value="20000-30000" {{ $user->annual_salary == '20000-30000' ? 'selected' : '' }}>
                                    20000-30000
                                </option>
                                <option value="30000-40000" {{ $user->annual_salary == '30000-40000' ? 'selected' : '' }}>
                                    30000-40000
                                </option>
                                <option value="40000-50000" {{ $user->annual_salary == '40000-50000' ? 'selected' : '' }}>
                                    40000-50000
                                </option>
                                <option value="50000-60000" {{ $user->annual_salary == '50000-60000' ? 'selected' : '' }}>
                                    50000-60000
                                </option>
                                <option value="60000-70000" {{ $user->annual_salary == '60000-70000' ? 'selected' : '' }}>
                                    60000-70000
                                </option>

                                <option value="70000-80000" {{ $user->annual_salary == '70000-80000' ? 'selected' : '' }}>
                                    70000-80000
                                </option>

                                <option value="80000-90000" {{ $user->annual_salary == '80000-90000' ? 'selected' : '' }}>
                                    80000-90000
                                </option>

                                <option value="90000-100000"
                                    {{ $user->annual_salary == '90000-100000' ? 'selected' : '' }}>
                                    90000-100000
                                </option>
                                <option value=">100000" {{ $user->annual_salary == '>100000' ? 'selected' : '' }}>>100000
                                </option>
                            </select>

                            {!! e_form_error('annual_salary', $errors) !!}
                        </div>
                    </div>



                    <div class="form-group row {{ $errors->has('hourly_per_rate') ? 'has-error' : '' }}">
                        <label for="hourly_per_rate" class="col-sm-4 control-label">@lang('app.hourly_per_rate')<span
                                class="mendatory-mark" style="color:red;">&nbsp;*</span></label>
                        <div class="col-sm-8">

                            <select name="hourly_per_rate" required id="hourly_per_rate" required
                                class="form-control select2">
                                <option value="">-Ex $25/hour-</option>
                                <option value="$20 / hour" {{ $user->hourly_per_rate == '$20 / hour' ? 'selected' : '' }}>
                                    $20
                                    / hour</option>
                                <option value="$25 / hour" {{ $user->hourly_per_rate == '$25 / hour' ? 'selected' : '' }}>
                                    $25
                                    / hour</option>
                                <option value="$30 / hour" {{ $user->hourly_per_rate == '$30 / hour' ? 'selected' : '' }}>
                                    $30
                                    / hour
                                </option>

                                <option value="$35 / hour" {{ $user->hourly_per_rate == '$35 / hour' ? 'selected' : '' }}>
                                    $35
                                    / hour
                                </option>
                                <option value="$40 / hour" {{ $user->hourly_per_rate == '$40 / hour' ? 'selected' : '' }}>
                                    $40
                                    / hour
                                </option>
                                <option value="$45 / hour" {{ $user->hourly_per_rate == '$45 / hour' ? 'selected' : '' }}>
                                    $45
                                    / hour
                                </option>
                                <option value="$50 / hour" {{ $user->hourly_per_rate == '$50 / hour' ? 'selected' : '' }}>
                                    $50
                                    / hour
                                </option>
                                <option value="$60 / hour" {{ $user->hourly_per_rate == '$60 / hour' ? 'selected' : '' }}>
                                    $60
                                    / hour
                                </option>

                                <option value="$70 / hour" {{ $user->hourly_per_rate == '$70 / hour' ? 'selected' : '' }}>
                                    $70
                                    / hour
                                </option>

                                <option value="$80 / hour" {{ $user->hourly_per_rate == '$80 / hour' ? 'selected' : '' }}>
                                    $80
                                    / hour
                                </option>

                                <option value="$90 / hour"
                                    {{ $user->hourly_per_rate == '$90 / hour' ? 'selected' : '' }}$90 / hour </option>
                                <option value=">$100 / hour"
                                    {{ $user->hourly_per_rate == '$100 / hour' ? 'selected' : '' }}>
                                    $100 / hour
                                </option>
                                <option value=">$125 / hour"
                                    {{ $user->hourly_per_rate == '$125 / hour' ? 'selected' : '' }}>
                                    $125 / hour
                                </option>
                                <option value=">$150 / hour"
                                    {{ $user->hourly_per_rate == '$150 / hour' ? 'selected' : '' }}>
                                    $150 / hour
                                </option>
                                <option value=">$175 / hour"
                                    {{ $user->hourly_per_rate == '$175 / hour' ? 'selected' : '' }}>
                                    $175 / hour
                                </option>
                                <option value=">$200 / hour"
                                    {{ $user->hourly_per_rate == '>$200 / hour' ? 'selected' : '' }}>
                                    $200 / hour
                                </option>
                                <option value=">$250 / hour"
                                    {{ $user->hourly_per_rate == '$250 / hour' ? 'selected' : '' }}$250 / hour </option>
                                <option value=">$300 / hour"
                                    {{ $user->hourly_per_rate == '$300 / hour' ? 'selected' : '' }}>
                                    $300 / hour
                                </option>
                                <option value="Negotiable Preferred"
                                    {{ $user->hourly_per_rate == 'Negotiable Preferred' ? 'selected' : '' }}>Negotiable
                                    Preferred
                                </option>
                            </select>


                            {!! e_form_error('hourly_per_rate', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('willing_to_relocate') ? 'has-error' : '' }}">
                        <label for="willing_to_relocate" class="col-sm-4 control-label">@lang('app.willing_to_relocate')</label>
                        <div class="col-sm-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio1"
                                    {{ !empty($user->willing_to_relocate) && $user->willing_to_relocate == 'yes' ? 'checked="checked' : '' }}
                                    name="willing_to_relocate" class="custom-control-input" value="yes">
                                <label for="customRadio1" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio2" name="willing_to_relocate"
                                    {{ !empty($user->willing_to_relocate) && $user->willing_to_relocate == 'no' ? 'checked="checked' : '' }}
                                    class="custom-control-input" value="no">
                                <label for="customRadio2" class="custom-control-label">No</label>
                            </div>
                            {!! e_form_error('willing_to_relocate', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('willing_to_travel') ? 'has-error' : '' }}">
                        <label for="willing_to_travel" class="col-sm-4 control-label">@lang('app.willing_to_travel')</label>
                        <div class="col-sm-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio3"
                                    {{ !empty($user->willing_to_travel) && $user->willing_to_travel == 'yes' ? 'checked="checked' : '' }}
                                    name="willing_to_travel" class="custom-control-input" value="yes">
                                <label for="customRadio3" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio4" name="willing_to_travel"
                                    {{ !empty($user->willing_to_travel) && $user->willing_to_travel == 'no' ? 'checked="checked' : '' }}
                                    class="custom-control-input" value="no">
                                <label for="customRadio4" class="custom-control-label">No</label>
                            </div>
                            {!! e_form_error('willing_to_travel', $errors) !!}
                        </div>
                    </div>


                    <div class="form-group row {{ $errors->has('willing_to_telecommute') ? 'has-error' : '' }}">
                        <label for="willing_to_telecommute" class="col-sm-4 control-label">@lang('app.willing_to_telecommute')</label>
                        <div class="col-sm-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio5"
                                    {{ !empty($user->willing_to_telecommute) && $user->willing_to_telecommute == 'yes' ? 'checked="checked' : '' }}
                                    name="willing_to_telecommute" class="custom-control-input" value="yes">
                                <label for="customRadio5" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio6" name="willing_to_telecommute"
                                    {{ !empty($user->willing_to_telecommute) && $user->willing_to_telecommute == 'no' ? 'checked="checked' : '' }}
                                    class="custom-control-input" value="no">
                                <label for="customRadio6" class="custom-control-label">No</label>
                            </div>
                            {!! e_form_error('willing_to_telecommute', $errors) !!}
                        </div>
                    </div>


                    <div class="form-group row {{ $errors->has('job_classification') ? 'has-error' : '' }}">
                        <label for="job_classification" class="col-sm-4 control-label">@lang('app.job_classification')</label>
                        <div class="col-sm-8">

                            <select id="job_classification" required name="job_classification"
                                class="form-control select2">
                                <option value="">-Ex Full Time -</option>
                                <option value="Full Time"
                                    {{ $user->job_classification == 'Full Time' ? 'selected' : '' }}>
                                    Full Time</option>
                                <option value="Part Time"
                                    {{ $user->job_classification == 'Part Time' ? 'selected' : '' }}>
                                    Part Time</option>
                                <option value="Contract" {{ $user->job_classification == 'Contract' ? 'selected' : '' }}>
                                    Contract
                                </option>
                                <option value="Corp to Corp Contract"
                                    {{ $user->job_classification == 'Corp to Corp Contract' ? 'selected' : '' }}>Corp to
                                    Corp
                                    Contract
                                </option>
                                <option value="Independent Contract"
                                    {{ $user->job_classification == 'Independent Contract' ? 'selected' : '' }}>Independent
                                    Contract
                                </option>
                                <option value="W2 Contract to Hire"
                                    {{ $user->job_classification == 'W2 Contract to Hire' ? 'selected' : '' }}>W2 Contract
                                    to
                                    Hire
                                </option>
                                <option value="Corp-to-Corp Contract to Hire"
                                    {{ $user->job_classification == 'Corp-to-Corp Contract to Hire' ? 'selected' : '' }}>
                                    Corp-to-Corp Contract to Hire
                                </option>
                                <option value="Independent Contract to Hire"
                                    {{ $user->job_classification == 'Independent Contract to Hire' ? 'selected' : '' }}>
                                    Independent Contract to Hire
                                </option>
                                <option value="W2" {{ $user->job_classification == 'W2' ? 'selected' : '' }}>W2
                                </option>
                            </select>




                            {!! e_form_error('job_classification', $errors) !!}
                        </div>
                    </div>




                    <div class="form-group row {{ $errors->has('skills') ? 'has-error' : '' }}">
                        <label for="skills" class="col-sm-4 control-label">@lang('app.skills')</label>
                        <div class="col-sm-8">
                            <select class="form-control  {{ e_form_invalid_class('category', $errors) }} required"
                                name="skills" id="skills">
                                <option value="">@lang('app.select_category')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ selected($category->id, $user->skills) }}>
                                        {{ $category->category_name }}</option>
                                @endforeach
                            </select>

                            {!! e_form_error('category', $errors) !!}
                        </div>
                    </div>


                    <div class="form-group row {{ $errors->has('years_of_experience') ? 'has-error' : '' }}">
                        <label for="years_of_experience" class="col-sm-4 control-label">@lang('app.years_of_experience')</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="skills"
                                value="{{ !empty($user->years_of_experience) ? $user->years_of_experience : '' }}"
                                name="years_of_experience" placeholder="@lang('app.years_of_experience')">
                            {!! e_form_error('years_of_experience', $errors) !!}
                        </div>
                    </div>

                    <h4 style="margin-top:20px;margin-bottom:20px;color:#38c172;"> Education History</h4>


                    <div class="form-group row {{ $errors->has('high_degree') ? 'has-error' : '' }}">
                        <label for="high_degree" class="col-sm-4 control-label">@lang('app.high_degree')</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="high_degree"
                                value="{{ !empty($user->high_degree) ? $user->high_degree : '' }}" name="high_degree"
                                placeholder="@lang('app.high_degree')">
                            {!! e_form_error('high_degree', $errors) !!}
                        </div>
                    </div>






                    <div class="form-group row {{ $errors->has('last_employer_information') ? 'has-error' : '' }}">
                        <label for="last_employer_information" class="col-sm-4 control-label">@lang('app.last_employer_information')</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="last_employer_information"
                                value="{{ !empty($user->last_employer_information) ? $user->last_employer_information : '' }}"
                                name="last_employer_information" placeholder="@lang('app.last_employer_information')">
                            {!! e_form_error('last_employer_information', $errors) !!}
                        </div>
                    </div>



                    <div class="form-group row {{ $errors->has('job_title') ? 'has-error' : '' }}">
                        <label for="job_title" class="col-sm-4 control-label">@lang('app.job_title')</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="job_title"
                                value="{{ !empty($user->job_title) ? $user->job_title : '' }}" name="job_title"
                                placeholder="@lang('app.job_title')">
                            {!! e_form_error('job_title', $errors) !!}
                        </div>
                    </div>


                    <div class="form-group row {{ $errors->has('job_responsibilities') ? 'has-error' : '' }}">
                        <label for="job_responsibilities" class="col-sm-4 control-label">@lang('app.job_responsibilities')</label>
                        <div class="col-sm-8">

                            <textarea class="form-control" placeholder="Enter up to maximum 300 characters " id="job_responsibilities"
                                name="job_responsibilities">{{ !empty($user->job_responsibilities) ? $user->job_responsibilities : '' }}</textarea>

                            {!! e_form_error('job_responsibilities', $errors) !!}
                        </div>
                    </div>


                    <div class="form-group row {{ $errors->has('resume') ? 'has-error' : '' }}">
                        <label for="resume" class="col-sm-4 control-label">@lang('app.resume')</label>
                        <div class="col-sm-8">
                            <input type="file" class="" id="resume" name="resume"
                                placeholder="Upload your Resume">
                            @if ($user->resume)
                                <a href="{{ $user->resume_url }}"> View Resume</i></a>
                            @endif
                            {!! e_form_error('resume', $errors) !!}

                        </div>

                    </div>
                @endif

                <hr />

                <div class="form-group row">
                    <div class="col-sm-8 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary">@lang('app.edit')</button>
                    </div>
                </div>

            </form>


        </div>
    </div>



@endsection


@section('page-js')
    <script src="{{ asset('assets/js/jquery-3.4.1.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js') }}" defer></script>

    <script>
        $(document).ready(function() {
            $('.country_to_state').trigger('change')
        });
    </script>
@endsection
