$( document ).ready(function() {
  var base_url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/"
 
  "use strict";
    $('#datatable').dataTable( {
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "ajax": {
        "url": base_url + "dashboard/jobs/approvedjobsajax"
      },
      'columns': [
          { data: 'job_title' },
          { data: 'status' },
          { data: 'id' },
          { data: 'id' },
        ],
        "columnDefs": [
            {
              "targets":1,
              "render": function (data, type, row, meta) {

                if(row['is_premium'])
                  return   `<p class="alert alert-success" data-toggle="tooltip" title="Premium"><i class="la la-bookmark-o"></i>Premium</p>`

              },
            },
            {
              "targets":2,
              "render": function (data, type, row, meta) {
                return `<td>` + row['company'] + `</td>`
              },
            }

            ,
            {
              "targets":3,
              "render": function (data, type, row, meta) {
               var result =  '<td>' +
                    `<a href="https://pingjob.com/${row['job_slug']}" class="btn btn-primary btn-sm" target="_blank" data-toggle="tooltip" title="View"><i class="la la-eye"></i> </a>
                    <a href="https://pingjob.com/dashboard/employer/job/edit/${row['id_job']}" class="btn btn-secondary btn-sm"><i class="la la-edit" data-toggle="tooltip" title="Edit"></i> </a>`




                   if(row['status'] != 1){
                     result =  result  + `<a href="https://pingjob.com/dashboard/jobs/status/${row['id_job']}/approve" class="btn btn-success btn-sm" data-toggle="tooltip" title="Approve"><i class="la la-check-circle-o"></i> </a>`

                   }else if(row['status'] != 2){
                     result =  result  + `<a href="https://pingjob.com/dashboard/jobs/status/${row['id_job']}/block" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Block"><i class="la la-ban"></i> </a>`
                   }



                    result =  result  + `<a href="https://pingjob.com/dashboard/jobs/status/${row['id_job']}/delete" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"><i class="la la-trash-o"></i> </a> </td>`


                    return result

              },
            }


        ]
    });

})
