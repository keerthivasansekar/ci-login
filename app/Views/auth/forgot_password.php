<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            <form action="#" id="formForgotPassword" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <span id="InputEmail-error" class=""></span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" id="reqNewPass" class="btn btn-primary btn-block">Request new password</button>
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