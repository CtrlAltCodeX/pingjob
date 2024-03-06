$( document ).ready(function() {
"use strict";
 var base_url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/"

    $("#clients_admin_dashboard").autocomplete({
            source: function( request, response ) {

            // Fetch data
                $.ajax({
                  url:  base_url + 'dashboard/employer/search-client-by-name' ,
                  type: 'get',
                  dataType: "json",
                  data: {
                   search: request.term
                  },
                  success: function( data ) {
                   response( data );
                  }
                });
            },
            select: function (event, ui) {

              $('#client_admin_dashboard_id').val(ui.item.id)

            }
    })

  })
