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
        <link rel="stylesheet" href="<?php echo site_url('assets/css/auth.css');?>">
    </head>
    <body>
        <div class="container" id="main">    
            <div id="signupbox" style="margin-top:80px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">Sign Up</div>
                        <div style="float:right; font-size: 85%; position: relative; top:-16px"><a id="signinlink" href="<?php echo site_url('auth/login'); ?>">Sign In</a></div>
                    </div>  
                    <div class="panel-body" >
                        <form method="post" action="" class="form-horizontal" role="form">

                            <?php if(!empty(@$notif)){ ?>
                            <div id="signupalert" class="alert alert-<?php echo @$notif['type'];?>">
                                <p><?php echo @$notif['message'];?></p>
                                <span></span>
                            </div>
                            <?php } ?>
        
                            <div class="form-group">
                                <label for="lastname" class="col-md-3 control-label">User Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $this->input->post('username');?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo $this->input->post('email');?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $this->input->post('password');?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="icode" class="col-md-3 control-label">Confirmation</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" value="<?php echo $this->input->post('confirm_password');?>">
                                </div>
                            </div>                          

                            <div style="padding-top:20px"  class="form-group">
                                <div class="col-md-offset-1 col-md-10 controls">
                                    <input type="submit" class="btn btn-primary" value=" &nbsp Sign Up &nbsp" style="width:200px;">
                                </div>                                           
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                        Already have an account? <a href="<?php echo site_url('auth/login'); ?>">Sign in</a>
                                    </div>
                                </div>
                            </div>                              
                        </form>
                    </div>
                </div>

            </div> 
        </div>
        <!--JS-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
