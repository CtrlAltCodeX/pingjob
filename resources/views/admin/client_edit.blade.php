@extends('layouts.dashboard')

@section('title_action_btn_gorup')

@endsection

@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('app.company_register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('client_edit_post')}}">
                            @csrf

                            <div class="form-group row">
                              <input type='hidden' name='client_id' value='{{ $client_id }}' />
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} <span class="mendatory-mark">*</span></label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $employer->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('app.company') }} <span class="mendatory-mark">*</span></label>
                                <div class="col-md-6">
                                    <input id="company" type="text" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="company" value="{{ $employer->company }}" required autofocus>

                                    @if ($errors->has('company'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="website" class="col-md-4 col-form-label text-md-right">{{ __('app.website') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="website" type="text" class="form-control" name="website" value="{{ $employer->website }}" autofocus>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} <span class="mendatory-mark">*</span></label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $employer->email }}" readonly>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} <span class="mendatory-mark">*</span></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} <span class="mendatory-mark">*</span></label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>



                            <legend>Contact Information</legend>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('app.phone') }} <span class="mendatory-mark">*</span></label>
                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ $employer->phone }}" required autofocus>

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('app.address') }} <span class="mendatory-mark">*</span></label>
                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $employer->address }}" required autofocus>

                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="address_2" class="col-md-4 col-form-label text-md-right">{{ __('app.address_2') }}</label>
                                <div class="col-md-6">
                                    <input id="address_2" type="text" class="form-control{{ $errors->has('address_2') ? ' is-invalid' : '' }}" name="address_2" value="{{ $employer->address_2 }}">

                                    @if ($errors->has('address_2'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address_2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="zip_code" class="col-md-4 col-form-label text-md-right">{{ __('app.zip_code2') }}</label>
                                <div class="col-md-6">
                                    <input id="zip_code" type="text" class="form-control" name="zip_code" value="{{ $employer->zip_code }}" autofocus>

                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('app.country') }} <span class="mendatory-mark">*</span></label>
                                <div class="col-md-6">
                                    <select name="country" class="form-control country_to_state" value='{{ $employer->country_id }}' required autofocus>
                                        <option value="">@lang('app.select_a_country')</option>
                                        @foreach($countries as $country)
                                            <option value="{!! $country->id !!}" {{selected($country->id, $employer->country_id)}}  >{!! $country->country_name !!}</option>
                                        @endforeach
                                    </select>

                                      {!! e_form_error('country', $errors) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('app.state') }} <span class="mendatory-mark">*</span></label>
                                <div class="col-md-6">
                                    <select name="state" class="form-control state_options state_to_city" value='{{ $employer->state_id }}'  required autofocus>
                                        <option value="">Select a state</option>

                                        @if($old_country)
                                            @foreach($old_country->states as $state)
                                                <option value="{{$state->id}}" {{selected($state->id, $employer->state_id)}}>{!! $state->state_name !!}</option>
                                            @endforeach
                                        @endif

                                    </select>

                                    {!! e_form_error('state', $errors) !!}
                                </div>
                            </div>


                          <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right control-label">{{ __('app.city_name') }} <span class="mendatory-mark">*</span></label> </label>
                                <div class="col-md-6">
                                    <select name="city" value='{{ $employer->city_id }}' required class="form-control city_options">
                                        <option value="">Select a City</option>

                                        @if($cities)
                                            @foreach($cities as $city)
                                                <option value="{{$city['id']}}" {{selected($city['id'], $employer->city_id)}}>{!! $city['name'] !!}</option>
                                            @endforeach
                                        @endif

                                    </select>

                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="la la-save"></i> {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
