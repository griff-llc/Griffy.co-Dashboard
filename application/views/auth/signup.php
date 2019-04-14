<!DOCTYPE html>
<html>
    <head>
        <title><?php echo isset($title) ? $title : 'CodeIgniter Login'; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="<?=base_url().'images/zillow-icon.png';?>" type="image/png">
        <!-- CSS -->    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">  
        <link rel="stylesheet" href="<?php echo site_url('assets/css/classic.css');?>">
        <style>
            html { font-size: 16px; }
        </style>
    </head>
    <body>
        <main class="main h-100 w-100">
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                        <div class="d-table-cell align-middle">

                            <div class="text-center mt-4">
                                <h1 class="h2">Get started</h1>
                                <p class="lead">
                                    Start creating the best possible user experience for you customers.
                                </p>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                    <form method="post" action="" class="form-horizontal" role="form">
                                            <?php if (!empty(@$notif)): ?>
                                                <div class="alert alert-<?php echo @$notif['type']; ?> alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <div class="alert-message">
                                                        <?php echo @$notif['message'];?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input class="form-control form-control-lg" type="text" name="username" placeholder="Enter your username" />
                                            </div>
                        
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" />
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control form-control-lg" type="password" name="confirm_password" placeholder="Repeat password" />
                                            </div>

                                            <div class="form-group">
                                                <div>
                                                    Already have an account? <a href="<?php echo site_url('auth/login'); ?>">Sign in</a>
                                                </div>
                                            </div>
                                            
                                            <div class="text-center mt-3">
                                                <button href="dashboard-default.html" class="btn btn-lg btn-primary">Sign up</button>
                                                <!-- <button type="submit" class="btn btn-lg btn-primary">Sign up</button> -->
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
        <!--JS-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
