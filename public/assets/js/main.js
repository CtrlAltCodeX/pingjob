(function ($) {
    "use strict";

    $(document).on('change', '.country_to_state', function(e){
        e.preventDefault();

        var country_id = $(this).val();
        $.ajax({
            type : 'POST',
            url : page_data.routes.get_state_option_by_country,
            data : {country_id : country_id, _token : page_data.csrf_token},
            success: function(data){
                $('.state_options').html(data.state_options);
            }
        });
    });
    
      $(document).on('change', '.state_to_city', function(e){
        e.preventDefault();

        var state_id = $(this).val();
        $.ajax({
            type : 'POST',
            url : page_data.routes.get_city_option_by_state,
            data : {state_id : state_id, _token : page_data.csrf_token},
            success: function(data){
                $('.city_options').html(data.city_options);
            }
        });
    });

    if (page_data.jobModalOpen) {
        $('#applyJobModal').modal('show');
    }
    
    if (page_data.flag_job_validation_fails){
        $('#jobFlagModal').modal('show');
    }
    
    if (page_data.share_job_validation_fails){
        $('#shareByEMail').modal('show');
    }

    $(document).on('click', '.employer-follow-button', function(e){
        e.preventDefault();

        var $that = $(this);
        var employer_id = $that.attr('data-employer-id');

        $.ajax({
            type : 'POST',
            url : page_data.routes.follow_unfollow,
            data : {employer_id : employer_id, _token : page_data.csrf_token},
            beforeSend: function () {
                $that.addClass('updating-btn');
            },
            success: function(data){
                if (data.success){
                    if(typeof data.btn_text !== 'undefined'){
                        $that.html(data.btn_text);
                    }
                }else{
                    if(typeof data.login_url !== 'undefined'){
                        location.href = data.login_url;
                    }
                }
            },
            complete:function () {
                $that.removeClass('updating-btn');
            }
        });
    });

  $(document).on('click', '.vendor_submit_btn', function (e) {
    e.preventDefault();

    var company = $('#company').val();
    var employer_id = $('#employer_id').val();
    if (company != '') {
      $.ajax({
        url: page_data.routes.add_vendor,
        type: "POST",
        data: {'company': company, 'employer_id': employer_id, _token: page_data.csrf_token},
        success: function (result) {
          if (result.status == true) {
            $('#vendor_success_msg').html(result.message);
            $('.alert-success').show();
            $('.company').val('');
          } else {
            $('#vendor_error_msg').html(result.message);
            $('.alert-danger').show();
            $('.company').val('');
          }
          $('#vendor').val('');

        }
      });
    } else {
      alert('Please select vendor');
    }
  });

})( jQuery );

function close_alert(id) {
  $('#' + id).hide();
}
function clearFields() {
  $('#vendor').val('');
}