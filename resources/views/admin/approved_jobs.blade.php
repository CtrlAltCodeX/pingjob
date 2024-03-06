@extends('layouts.dashboard')

@section('page-css')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <table id='datatable' class="table table-bordered">
                  <thead class="table-dark">
                    <tr>
                        <th>@lang('app.job_title')</th>
                        <th>@lang('app.status')</th>
                        <th>@lang('app.employer')</th>
                        <th>#</th>
                    </tr>
                  </thead>

                  <tbody></tbody>

                </table>


        </div>
    </div>



@endsection



@section('page-js')

    <script src="https://code.jquery.com/jquery-3.5.1.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>

    <script src="{{asset('assets/js/dashboard/job_datatable_ajax.js')}}" defer></script>

@endsection
