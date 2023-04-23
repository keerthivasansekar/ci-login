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
                    $('#formRegister').each(function(){
                        this.reset();
                    });
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location= $(location).attr('origin') + '/auth/login';
                        }
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

    $('#btnReqNewPass').click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(location).attr('origin') + '/auth/forgot-password',
            type: 'post',
            dataType: 'json',
            data: $('#formForgotPassword').serialize(),
            success: function(data){
                if (data.status == 'success') {
                    $('#formForgotPassword').each(function(){
                        this.reset();
                    });
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location= $(location).attr('origin') + '/auth/verify-otp';
                        }
                    });
                } else {
                    Swal.fire(
                        'Failed',
                        'Somthing Went wrong',
                        'error'
                    );
                    if (data.error) {
                        $('#email').addClass('is-invalid');
                        $('#InputEmail-error').addClass('error invalid-feedback').text(data.error);
                    }
                }
            }
        });
    });

    $('#btnVerifyOtp').click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(location).attr('origin') + '/auth/verify-otp',
            type: 'post',
            dataType: 'json',
            data: $('#formVerifyOtp').serialize(),
            success: function(data){
                if (data.status == 'success') {
                    $('#formVerifyOtp').each(function(){
                        this.reset();
                    });
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location= $(location).attr('origin') + '/auth/reset-password';
                        }
                    });
                } else {
                    Swal.fire(
                        'Failed',
                        'Somthing Went wrong',
                        'error'
                    );
                    if (data.error) {
                        $('#otp').addClass('is-invalid');
                        $('#InputOtp-error').addClass('error invalid-feedback').text(data.error);
                    }
                }
            }
        });
    });

    $('#btnResetPassword').click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(location).attr('origin') + '/auth/reset-password',
            type: 'post',
            dataType: 'json',
            data: $('#formResetPassword').serialize(),
            success: function(data){
                if (data.status == 'success') {
                    $('#formResetPassword').each(function(){
                        this.reset();
                    });
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location= $(location).attr('origin') + '/auth/login';
                        }
                    });
                } else {
                    Swal.fire(
                        'Failed',
                        'Somthing Went wrong',
                        'error'
                    );
                    if (data.errors.errPassword) {
                        $('#password').addClass('is-invalid');
                        $('#InputPassword-error').addClass('error invalid-feedback').text(data.errors.errPassword);
                    }
                    if (data.errors.errConfirmPass) {
                        $('#confirmpass').addClass('is-invalid');
                        $('#InputConfirmPass-error').addClass('error invalid-feedback').text(data.errors.errConfirmPass);
                    }
                }
            }
        });
    });

    $('#btnLogin').click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(location).attr('origin') + '/auth/login',
            type: 'post',
            dataType: 'json',
            data: $('#formLogin').serialize(),
            success: function(data){
                if (data.status == 'success') {
                    $('#formLogin').each(function(){
                        this.reset();
                    });
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location= $(location).attr('origin');
                        }
                    });
                } else {
                    Swal.fire(
                        'Failed',
                        'Somthing Went wrong',
                        'error'
                    );
                    if (data.errors.errEmail) {
                        $('#email').addClass('is-invalid');
                        $('#InputEmail-error').addClass('error invalid-feedback').text(data.errors.errEmail);
                    }
                    if (data.errors.errPassword) {
                        $('#password').addClass('is-invalid');
                        $('#InputPassword-error').addClass('error invalid-feedback').text(data.errors.errPassword);
                    }
                }
            }
        });
    });

    $('#logout').click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(location).attr('origin') + '/auth/logout',
            dataType: 'json',
            success: function(data){
                if (data.status == 'success') {
                    Swal.fire(
                        'Success',
                        data.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location= $(location).attr('origin')+'/auth/login';
                        }
                    });
                }
            }
        });
    });
});