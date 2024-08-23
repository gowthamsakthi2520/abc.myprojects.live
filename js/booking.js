
$('#booking_id').submit(function (e) {
    e.preventDefault();

    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

    let name = $('#name').val().trim();
    let phone = $('#phone').val().trim();
    let email = $('#email').val().trim();
    let url = $('#url').val().trim();
    let isvalid = true;
    
    var regex = /^[a-zA-Z]+$/; 
    if (name == "") {
        $('#name_err').text(' * Enter the name');
        isvalid = false;
    } else if (!regex.test(name)) {
        $('#name_err').text(' * Only letters allowed');
        isvalid = false;
    } else {
        $('#name_err').text('');
    }


    if (phone == "") {
        $('#phone_err').text(' * Enter the Phone number');
        isvalid = false;

    } else if (phone.length !== 13) {

        $('#phone_err').text(' * please Enter the valid phone number');
        isvalid = false;
    }
    else {

        $('#phone_err').text('');
    }

    if (email == "") {
        $('#email_err').text(' * Enter the Email');
        isvalid = false;

    } else if (!testEmail.test(email)) {
        $('#email_err').text(' * please enter the valid  Email');
        isvalid = false;
    }
    else {
        $('#email_err').text('');

    }

    if (url == "") {
        $('#url_err').text(' * Enter the Url');
        isvalid = false;
    } else {
        $('#url_err').text('');
    }


    if (isvalid == true) {

        var form = $('#booking_id')[0];
        var formdata = new FormData(form);
        formdata.append('add', 'add_user');

        $.ajax({

            url: 'abc_web_insert.php',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: formdata,
            success: function (res) {
                console.log(res)


                try {
                    var object = JSON.parse(res);
                    $('#exist_name_err').text("");
                    $('#phone_err').text('');
                    $('#email_err').text('');
                    $('#url_err').text('');
                    if (object.status === true) {

                        $("#booking_id")[0].reset();
                          Swal.fire({
                              title: `<strong><u>${object.message}</u></strong>`,
                              icon: "success",
                              html: `
                                <p>Click this URL:</p>
                                <a href="${object.url}" target="_blank" style="color: #000; text-decoration: underline;">${object.url}</a>
                              `,
                              showCloseButton: true,
                              showCancelButton: true,
                              focusConfirm: false,
                              confirmButtonText: `
                                <i class="fa fa-thumbs-up"></i> Great!
                              `,
                              confirmButtonAriaLabel: "Thumbs up, great!",
                              cancelButtonText: `
                                <i class="fa fa-thumbs-down"></i>
                              `,
                              cancelButtonAriaLabel: "Thumbs down"
                            });

                    } else {
                            
                         if(object.name_error === "Please enter letters only"){
                                    $('#exist_name_err').text('Please enter letters only');
                                }
                        
                        if (object.message === "Name is already exists") {
                            $('#exist_name_err').text("Name is already exists");
                        }

                        if (object.message === "phone is already exists") {
                            $('#phone_err').text('* Number is Already exists');
                        }

                        if (object.message === "email is already exists") {
                            $('#email_err').text('* Email is Already exists');
                        }

                        if (object.message === "url is already exists") {
                            $('#url_err').text('* Url is Already exists');
                        }
                    }

                } catch (e) {
                    console.error('Error parsing JSON:', e);

                }


            },
            error: function (xhr) {
                console.log(xhr)

            }


        })

    }

})



function OnlyStringValidate(event) {
    var regex = /^[a-zA-Z]+$/;

    if (!regex.test(event.key)) {
        event.preventDefault();
        return false;
    }
}

function sanitizeAndValidatePhone(input) {
    input.value = input.value.replace(/[^+\d]+$/g, '');

    if (input.value.length > 13) {
        input.value = input.value.substring(0, 13);
    }
}






