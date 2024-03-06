@extends('layouts.theme')

@section('assets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@endsection

@section('content')


    <div class="blog-listing-header ">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h1>@lang('app.search_clients')</h1>

                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="widget-box bg-white p-3 mt-3 mb-3 box-shadow">
                    <div class="employer-job-listing mt-4">

                        <table id="example" class="table table-striped responsive table-bordered nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th>Company</th>
                                    <th>Vendor(s)</th>
                                    <th>Rating(s)</th>
                                    <th>Contact(s)</th>
                                    <th>Job(s)</th>
                                    <th>Comments(s)</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($search_clients->isNotEmpty())
                                    @foreach ($search_clients as $search_client)
                                        <tr class="text-center">
                                            <td><a
                                                    href="{{ route('clients_details', $search_client->id) }}">{{ $search_client->company }}</a>
                                            </td>
                                            <td>{{ $search_client->vendor_count }}</td>
                                            <td>{{ $search_client->review_rating > 0 ? $search_client->review_rating : 0 }}
                                            </td>
                                            <td>{{ $search_client->contact_count }}</td>
                                            <td><a
                                                    href="{{ route('jobs_by_employer', $search_client->company_slug) }}">{{ $search_client->job_count }}</a>
                                            </td>
                                            <td>{{ $search_client->review_count }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


@section('page-js')
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection
