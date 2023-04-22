$(document).ready(function(){
    $('#btnRegister').click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(location).attr('origin') + '/auth/register',
            type: 'post',
            dataType: 'json',
            data: $('#formRegister').serialize(),
            success: function(data){
                if (data.status == 'success') {
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    );
                    $('#formRegister').each(function(){
                        this.reset();
                    });
                } else {
                    Swal.fire(
                        'Failed',
                        'Somthing Went wrong',
                        'error'
                    );
                    if (data.messages.errName) {
                        $('#name').addClass('is-invalid');
                        $('#InputName-error').addClass('error invalid-feedback').text(data.messages.errName);
                    }
                    if (data.messages.errEmail) {
                        $('#email').addClass('is-invalid');
                        $('#InputEmail-error').addClass('error invalid-feedback').text(data.messages.errEmail);
                    }
                    if (data.messages.errPassword) {
                        $('#password').addClass('is-invalid');
                        $('#InputPassword-error').addClass('error invalid-feedback').text(data.messages.errPassword);
                    }
                    if (data.messages.errConfirmPass) {
                        $('#confirmpass').addClass('is-invalid');
                        $('#InputConfirmPass-error').addClass('error invalid-feedback').text(data.messages.errConfirmPass);
                    }
                    if (data.messages.errTerms) {
                        $('#terms').addClass('is-invalid');
                        $('#InputTerms-error').addClass('error invalid-feedback').text(data.messages.errTerms);
                    }
                }
            }
        });
    });
});