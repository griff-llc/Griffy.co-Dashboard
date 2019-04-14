
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>      
<link rel="stylesheet" href="<?php echo site_url('assets/css/auth.css');?>">

<div class="container" id="main" style="margin:0;width:100%;">    
    <div id="loginbox" class="mainbox col-md-3 col-md-offset">                    
        <div class="panel panel-primary" >
            <div class="panel-heading">
                <div class="panel-title">Reset Password</div>
            </div>     
            <div style="padding-top:30px" class="panel-body" >                
                <form action="#" id="form" class="form-horizontal">
                    <div style="margin-bottom:7px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <div style="margin-bottom:7px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="confirm-password" type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                    </div>                   

                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <input type="button" class="btn btn-primary" value="Reset" onclick="javascript:save()">
                        </div>
                    </div>                    
                </form>
            </div>                     
        </div>  
    </div>

    <div id="loginbox" class="mainbox col-md-8">
        <div class="panel panel-primary" >
            <div class="panel-heading">
                <div class="panel-title">User Info</div>                        
            </div>     
            <div style="padding-top:30px" class="panel-body" >
                
                <form method="post" action="" class="form-horizontal" role="form">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span style="width:100px;">UserName : <?php echo $username;?></span>
                        
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span style="width:100px;text-align:right;">Email :  <?php echo $email;?></span>
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span style="width:100px;text-align:right;">Key :  <?php echo $key;?></span>                        
                    </div>
                </form>     
                
            </div>                     
        </div>  
    </div>
</div>

<script type="text/javascript">
    function save()
    {
      var url = "<?php echo site_url('user/ajax_save')?>";

       // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          //if success close modal and reload ajax table
          swal(
            '',
            data.notif.message,
            data.notif.type
          )
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          swal(
            '',
            'Error reset the password',
            'Error'
          )
        }
      });
    }
</script>