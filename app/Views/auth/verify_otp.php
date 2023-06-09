<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Enter the code you received in email to reset your password.</p>
            <form action="#" id="formVerifyOtp" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="otp" id="otp" class="form-control" placeholder="Verification Code">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <span id="InputOtp-error" class=""></span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" id="btnVerifyOtp" class="btn btn-primary btn-block">Reset new password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mt-3 mb-1">
                <a href="<?= base_url('auth/login') ?>">Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->