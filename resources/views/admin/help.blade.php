@extends('layouts.dashboard')

@section('title_action_btn_gorup')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="text-center">
                            <th>Id</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($help_entries->isNotEmpty())
                        @foreach($help_entries as $help)
                            <tr class="text-center">
                                <td>{{ $help->id }}</td>
                                <td>{{ $help->subject }}</td>
                                <td class="text-left">{{  \App\Helper\Functions::str_limit($help->message, $limit = 50, $end = '...') }}</td>
                                <td><button data-toggle="modal" data-target="#helpModal" class='btn btn-info open' data-id='{{$help->id}}' data-subject='{{$help->subject}}' data-message='{{$help->message}}'>Open</button></td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center"> No help asked</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

        </div>
    </div>

    <div class="modal fade" id="helpModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title" id='modal_help'>Help #</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                           >
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>

              <div class="modal-body">

                  <div class="col-12">
                      <label for="name" class="control-label">Subject:</label>
                      <p type="text" class="form-control" id="help_subject" ></p>
                  </div>

                  <div class="col-12">
                      <label for="name" class="control-label">Message:</label>
                      <p type="text"  id="help_message" ></p>
                  </div>


              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"
                         >Close
                  </button>
              </div>
            </div>
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

        $('.open').click(function(){
          var id = $(this).data('id');
          var subject = $(this).data('subject');
          var message = $(this).data('message');

          $('#modal_help').text('Help #' +id)
          $('#help_subject').text(subject)
          $('#help_message').text(message)

        })


      });



    </script>

@endsection
