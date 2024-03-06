@extends('layouts.dashboard')

@section('title_action_btn_gorup')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <a href="{{route('client_add_view')}}" type="submit" class="btn btn-success">
                <i class="la la-save"></i> Register
            </a>

            <br>
            <br>

            <form method="POST" action="{{ route('dashboard_client_update') }}" enctype="multipart/form-data">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="text-center">
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
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->address }}</td>
                                <td class="text-left">{{  \App\Helper\Functions::str_limit($client->website, $limit = 50, $end = '...') }}</td>
                                <td>
                                  @if($client->active_status == 1)
                                     <span class="badge badge-success">Approved</span>
                                  @elseif($client->active_status == 2)
                                     <span class="badge badge-danger">Reject</span>
                                  @else
                                     <span class="badge badge-warning">Pending</span>
                                  @endif
                              </td>
                              <td style='display: flex;justify-content: space-between;'>
                                @if(auth()->user()->is_admin())

                                    @if($client->active_status != 0)
                                        <a href="{{route('client_status_change', [$client->id, 'block'])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="@lang('app.block')">
                                            <i class="la la-ban"></i>
                                        </a>
                                    @endif

                                    <a href="{{route('client_status_change', [$client->id, 'delete'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.delete')">
                                        <i class="la la-trash-o"></i>
                                    </a>

                                    <a href="{{route('client_edit', [$client->id])}}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="@lang('app.edit')">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endif
                              </td>
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
               {!! $clients->links() !!}


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
