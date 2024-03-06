@extends('layouts.dashboard')

@section('title_action_btn_gorup')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('dashboard_client_update') }}" enctype="multipart/form-data">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="text-center">
                            <th><input type="checkbox" id="selectAll" name="header_check"/></th>
                            <th>Company</th>
                            <th>Address</th>
                            <th>Website</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($clients->isNotEmpty())
                        @foreach($clients as $client)
                            <tr class="text-center">
                                <td><input type="checkbox" name="clients[]" value="{{ $client->id }}"/></td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->address }}</td>
                                <td class="text-left">{{  \App\Helper\Functions::str_limit($client->website, $limit = 50, $end = '...') }}</td>
                                <td>@if($client->active_status == 1) <span class="badge badge-success">Approved</span> @elseif($client->active_status == 2)
                                     <span class="badge badge-danger">Reject</span>@else <span class="badge badge-warning">Pending</span> @endif</td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center"> No Clients</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($clients->isNotEmpty())
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary" id="btn_submit" name="status" value="1"><i
                                    class="la la-th-list"></i> @lang('app.btn_approve')</button>
                        <button type="submit" class="btn btn-danger" id="btn_submit" name="status" value="2"><i
                                    class="la la-th-list"></i> @lang('app.btn_reject')</button>
                    </div>
                </div>
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

      });


    </script>

@endsection
