$("#loginid").submit(function (e) {
    e.preventDefault();

    var form = $('#loginid')[0];
    var formdata = new FormData(form);
    formdata.append("login","login-form-type");

    $.ajax({
        url: 'controller.php',
        type: 'POST',
        data: formdata, // Use FormData object here
        cache: false,
        contentType: false, // Fix the camel case
        processData: false, // Fix the camel case
        success: function (res) {
            console.log(res);

            var obj =JSON.parse(res)

            if(obj.status==true){

              window.location.href = 'dashboard.php';

            }else{
                alert(obj.message);
            }
        },

        error: function (xhr) {
            console.log(xhr);
        }
    });
});


$("#log_out_id").submit(function (e) {
    e.preventDefault();

    var form = $('#log_out_id')[0];
    var formdata = new FormData(form);
    formdata.append("log_out","log_out_value");

    $.ajax({
        url: 'controller.php',
        type: 'POST',
        data: formdata, 
        cache: false,
        contentType: false, 
        processData: false, 
        success: function (res) {
            console.log(res);

            var obj =JSON.parse(res)

            if(obj.status==true){

               window.location.href = 'index.php';

            }
        },

        error: function (xhr) {
            console.log(xhr);
        }
    });
});

