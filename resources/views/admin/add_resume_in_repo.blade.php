@extends('layouts.dashboard')


@section('page-css')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">

            <form action="{{ route('store_to_resumes_repo') }}" method="post" id="addResume" enctype="multipart/form-data">
                @csrf

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name" class="control-label">@lang('app.name'):</label>
                    <input type="text" class="form-control {{ e_form_invalid_class('name', $errors) }}" id="name"
                        name="name" value="{{ old('name') }}" placeholder="@lang('app.name')">
                    {!! e_form_error('name', $errors) !!}
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="control-label">@lang('app.email'):</label>
                    <input type="text" class="form-control {{ e_form_invalid_class('email', $errors) }}" id="email"
                        name="email" value="
{{ old('email') }}" placeholder="@lang('app.email_ie')">
                    {!! e_form_error('email', $errors) !!}
                </div>

                <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                    <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                    <input type="text" class="form-control {{ e_form_invalid_class('phone_number', $errors) }}"
                        id="phone_number" name="phone_number" value="
{{ old('phone_number') }}"
                        placeholder="@lang('app.phone_number')">
                    {!! e_form_error('phone_number', $errors) !!}
                </div>

                <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                    <label for="message-text" class="control-label">@lang('app.message'):</label>
                    <textarea class="form-control {{ e_form_invalid_class('message', $errors) }}" id="message" name="message"
                        placeholder="@lang('app.message')">{{ old('message') }}</textarea>
                    {!! e_form_error('message', $errors) !!}
                </div>

                <div class="form-group {{ $errors->has('resume') ? 'has-error' : '' }}">
                    <label for="resume" class="control-label">@lang('app.resume'):</label>
                    <input type="file" class="form-control {{ e_form_invalid_class('resume', $errors) }}" id="resume"
                        name="resume">
                    <p class="text-muted">@lang('app.resume_file_types')</p>
                    {!! e_form_error('resume', $errors) !!}
                </div>
                <div class="form-group {{ $errors->has('resume') ? 'has-error' : '' }}">
                    <label for="resume" class="control-label">@lang('app.category'):</label>
                    <select name="category_id" id="category_id"
                        class="form-control {{ e_form_invalid_class('category', $errors) }}">
                        <option value="" disabled selected>Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($category->id == old('category_id')) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    {!! e_form_error('category_id', $errors) !!}
                </div>


                <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.add_resume')</button>

            </form>


        </div>
    </div>
@endsection




@section('page-js')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js" defer></script>

    <script src="{{ asset('assets/js/dashboard/sweet_alert.js') }}" defer></script>
@endsection
