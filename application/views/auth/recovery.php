<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('html/head/include'); ?>
    </head>
    <body>
        <main class="main h-100 w-100">
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                        <div class="d-table-cell align-middle">

                            <div class="text-center mt-4">
                                <h1 class="h2">Reset password</h1>
                                <p class="lead">
                                    Enter your email to reset your password.
                                </p>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <form>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="dashboard-default.html" class="btn btn-lg btn-primary">Reset password</a>
                                                <!-- <button type="submit" class="btn btn-lg btn-primary">Reset password</button> -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php $this->load->view('html/footer/contect');?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="<?php echo site_url('assets/js/settings.js');?>"></script>
        <script src="<?php echo site_url('assets/js/app-stack.js');?>"></script>
    </body>
</html>


