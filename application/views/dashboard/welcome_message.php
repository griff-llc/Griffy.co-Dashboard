<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>

<html>
<head>
  <style type="text/css">

  .un {text-decoration: none; }

  </style>
  <link rel="icon" href="<?=base_url().'images/zillow-icon.png';?>" type="image/png">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"> </script>

  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"> </script>
  
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.js"> </script>

  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.css" rel="stylesheet">

  <script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.5.1/js/dataTables.colReorder.min.js"> </script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"> </script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/AdminLTE.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/skin-red.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />

  <meta charset="UTF-8">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
 
  <!-- Font Awesome Icons -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />

  <link href="https://cdn.datatables.net/colreorder/1.5.1/css/colReorder.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
  
</head>

<body class="skin-red">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">      
      <!-- Logo -->
      <a href="" style="text-decoration:none"class="un logo"><b>ZILLOW </b></a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">


            <!-- User Account Menu -->
            <li class="">
              <!-- Menu Toggle Button -->
              <a href="<?php echo site_url('welcome/logout') ?>"> <i class="fa fa-sign-out"></i>Log out </a>
              
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <?php $this->load->view('navigation_bar');?>      

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <section class="content-header">
        <h1>
          <small>REAL ESTATE</small>
        </h1>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
               <!--     <h3 class="box-title">Data Contractor</h3>-->
             </div><!-- /.box-header -->
             <div class="box-body">

              <!-- Main content -->
              <section class="content">

                <!-- Your Page Content Here -->

                <?php $this->load->view('content'); ?>


              </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">

    </div>
    <!-- Default to the left --> 
    <strong>Copyright &copy; 2019 <a href="#">ZILLOW</a>.</strong> All rights reserved.
  </footer>

</div><!-- ./wrapper -->



<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.3 -->

<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/js/app.min.js" type="text/javascript"></script>

</body>
</html>