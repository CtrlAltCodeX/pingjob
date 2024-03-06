@extends('layouts.dashboard')



@section('title_action_btn_gorup')



@endsection



@section('content')

    <div class="row">

        <div class="col-md-12">



            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                    <tr class="text-center">

                        <th>Company</th>

                        <th>Ratings</th>

                        <th>Comments</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    @if($reviews->isNotEmpty())

                        @foreach($reviews as $review)

                            <tr class="text-center">

                                <td>{{ $review->company }}</td>

                                <td>{{ $review->ratings }}</td>

                                <td class="text-left">{{  App\Helper\Functions::str_limit($review->comments, $limit = 50, $end = '...') }}</td>

                                <td>@if($review->approve_status == 1) <span

                                            class="badge badge-success">Approved</span> @elseif($review->approve_status == 2)

                                        <span class="badge badge-danger">Reject</span>@else <span

                                                class="badge badge-warning">Pending</span> @endif</td>

                            </tr>

                        @endforeach

                    @else

                        <tr>

                            <td colspan="4" class="text-center"> No Reviews</td>

                        </tr>

                    @endif



                    </tbody>

                </table>

            </div>



        </div>

    </div>







@endsection





@section('page-js')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"

            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>





@endsection
