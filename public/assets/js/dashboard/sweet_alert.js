$( document ).ready(function() {


    $(document).on('click','#submit_button',function(event){

      event.preventDefault()
        Swal.fire({title:"Send Email to Applicants?",text:"Do you want to send the email of this job to applicants?",icon:"warning",showCancelButton:!0,confirmButtonColor:"#28bb4b",cancelButtonColor:"#f34e4e",confirmButtonText:"Yes!",cancelButtonText:'No'})
            .then(function(e){

                  e.value&&Swal.fire("Processing!","Sending emails in process","success")

                  if(e.value){

                      $('#email_send_to_applicants').val('yes')
                      $('#form_edit_job').submit();

                  }else{
                    $('#email_send_to_applicants').val('no')
                    $('#form_edit_job').submit();
                  }
            });
    })

})
