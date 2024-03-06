@extends('layouts.theme')

@section('content')

    @php
        $employer = $job->employer;
    @endphp

    <div class="main-container">
        <div class="job-view-lead-head  py-4 mb-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">

                        <div class="reviews">
                            <h4> {{ $employer->company }}
                                @php $review_total = 5 - round($review_ratings); @endphp
                                @for ($i = 0; $i < round($review_ratings); $i++)
                                    <span><i class="checked la la-star"></i></span>
                                @endfor
                                @for ($i = 0; $i < $review_total; $i++)
                                    <span><i class="unchecked la la-star"></i></span>
                                @endfor

                                <a style="font-size: 16px; color:#ccccb1;"
                                    href="{{ route('reviews', ['job_id' => $job->id, 'employer_id' => $employer->id]) }}"
                                    class="ml-2">Write a Review</a>
                            </h4>

                        </div>
                        <p class="text-muted mt-2">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mb-3">
                    <div class="card">
                        @if ($review_comments->isNotEmpty())
                            <div class="card-body">
                                @foreach ($review_comments as $comment)
                                    <div class="card card-inner mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>
                                                        <a class="float-left"
                                                            style="color: #38c172; font-size:24px;"><strong>{{ $comment->name }}</strong></a>
                                                        @php $comments_total = 5 - $comment->ratings; @endphp
                                                        @for ($i = 0; $i < $comments_total; $i++)
                                                            <span class="float-right"><i
                                                                    class="unchecked la la-star"></i></span>
                                                        @endfor
                                                        @for ($i = 0; $i < $comment->ratings; $i++)
                                                            <span class="float-right"><i
                                                                    class="checked la la-star"></i></span>
                                                        @endfor
                                                        <br />
                                                        <span class="float-right"> Posted Date:
                                                            {{ date('d-m-Y', strtotime($comment->created_at)) }}</span>
                                                    </p>

                                                    <div class="clearfix"></div>
                                                    <p class="pt-2">{{ $comment->comments }}</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-center p-3"> No Reviews </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endsection


    @section('page-js')
    @endsection
