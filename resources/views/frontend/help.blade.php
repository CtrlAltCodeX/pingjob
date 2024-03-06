@extends('layouts.theme')

@section('content')
    <div class="blog-listing-header ">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h1>@lang('app.help')</h1>
                </div>
            </div>
        </div>
    </div>

    </br>
    </br>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-single-content pt-3 pb-5">


                    @include('admin.flash_msg')
                    <form method="POST" action="">
                        @csrf

                        <div class="form-group row{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="col-md-4 control-label">@lang('app.subject') <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="subject" type="text"
                                    class="form-control {{ e_form_invalid_class('subject', $errors) }}" name="subject"
                                    value="{{ old('subject') }}">
                                {!! e_form_error('subject', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 control-label">@lang('app.message')</label>
                            <div class="col-md-6">
                                <textarea name="message" class="form-control {{ e_form_invalid_class('message', $errors) }}" rows="7">{{ old('message') }}</textarea>
                                {!! e_form_error('message', $errors) !!}
                            </div>
                        </div>


                        <div class="form-group row" style="margin-top:40px;">

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="la la-envelope-o"></i> @lang('app.ask_for_help')
                                </button>
                            </div>
                        </div>
                    </form>




                </div>
            </div>

            <div class="col-md-4">
                <div class="blog-single-content pt-3 pb-5">


                    <p><span style="font-size:16pt"><span><strong>USA</strong></span></span></p>


                    <span style="    font-size: .9rem;"><span>6689 orchard lake Rd # 210</span></span></br>

                    <span style="    font-size: .9rem;"><span>West Bloomfield MI 48322</span></span></br>

                    <span style="    font-size: .9rem;"><span>Ph : (248) 274-6186</span></span></br>

                    <span style="    font-size: .9rem;"><span>Email : shankar@pingjob.com</span></span></p>

                    <hr>

                    <p><span style="font-size:18pt"><span><strong>India</strong></span></span></p>

                    <span style="    font-size: .9rem;"><span>Unit 03, First Floor, Zenith,</span></span></br>

                    <span style="    font-size: .9rem;"><span>Ascendas ITPL, Taramani</span></span></br>

                    <span style="    font-size: .9rem;"><span>Chennai – 600113</span></span></br>

                    <span style="    font-size: .9rem;"><span>Tamil Nadu India</span></span></br>

                    <span style="    font-size: .9rem;"><span>Ph:&nbsp; (91) 44 43434747</span></span></br>


                    <hr>

                    <p><span style="font-size:18pt"><span><strong>Singapore</strong></span></span></p>

                    <span style="    font-size: .9rem;"><span>100 Jalan Sultan,</span></span></br>

                    <span style="    font-size: .9rem;"><span>#03-45, Sultan Plaza,</span></span></br>

                    <span style="    font-size: .9rem;"><span>Singapore – 199001</span></span></p>
                </div>
            </div>


        </div>
    </div>
    </div>
@endsection
