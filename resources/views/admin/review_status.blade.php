@extends('layouts.dashboard')



@section('title_action_btn_gorup')



@endsection



@section('content')

    <div class="row">

        <div class="col-md-12">

            <form method="POST" action="{{ route('dashboard_reviews_update') }}" enctype="multipart/form-data">

                @csrf

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>

                        <tr class="text-center">

                            <th><input type="checkbox" id="selectAll" name="header_check"/></th>

                            <th>Company</th>

                            <th>Username</th>

                            <th>Ratings</th>

                            <th>Reviews</th>

                            <th>Status</th>

                        </tr>

                        </thead>

                        <tbody>

                        @if($reviews->isNotEmpty())

                        @foreach($reviews as $review)

                            <tr class="text-center">

                                <td><input type="checkbox" name="reviews[]" value="{{ $review->id }}"/></td>

                                <td>{{ $review->company }}</td>

                                <td>{{ $review->name }}</td>

                                <td>{{ $review->ratings }}</td>

                                <td class="text-left">{{  App\Helper\Functions::str_limit($review->comments, $limit = 50, $end = '...') }}</td>

                                <td>@if($review->approve_status == 1) <span class="badge badge-success">Approved</span> @elseif($review->approve_status == 2)

                                     <span class="badge badge-danger">Reject</span>@else <span class="badge badge-warning">Pending</span> @endif</td>

                            </tr>

                        @endforeach

                        @else

                        <tr>

                            <td colspan="6" class="text-center"> No Reviews</td>

                        </tr>

                        @endif

                        </tbody>

                    </table>

                </div>

                @if($reviews->isNotEmpty())

                <button type="submit" class="btn btn-primary" id="btn_submit" name="status" value="1"><i

                            class="la la-th-list"></i> @lang('app.btn_approve')</button>

                <button type="submit" class="btn btn-danger" id="btn_submit" name="status" value="2"><i

                            class="la la-th-list"></i> @lang('app.btn_reject')</button>

                @endif

            </form>

        </div>

    </div>







@endsection





@section('page-js')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"

            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script type="text/javascript">

      $(document).ready(function () {

        $('#selectAll').click(function (e) {

          $(this).closest('table').find('tbody td input:checkbox').prop('checked', this.checked);

        });



        $('#btn_submit').click(function(){



        });

      });





    </script>



@endsection
