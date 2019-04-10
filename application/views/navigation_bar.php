<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url().'images/zillow-icon.png';?>" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>ZILLOW</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li>    
      <li class="treeview">
        <a href="#" style="text-decoration:none">
          <i class="fa fa-users"></i>
          <span >Property Information</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php if($flag == '1') { ?>
          <li>
            <a class = "ayam" href="<?php echo base_url();?>user/getuser"><i class="fa fa-circle-o"></i>User</a>
          </li>
          <li>
            <a class = "ayam" href="<?php echo base_url();?>key"><i class="fa fa-circle-o"></i>Key List</a>
          </li>
          <?php } ?>
          <?php if($flag == '0') { ?>
          <li>
            <a class = "ayam" href="<?php echo base_url();?>address"><i class="fa fa-circle-o"></i>Address</a>
          </li> 
          <?php } ?>
        </ul>
      </li>
      <li>
        <a class = "ayam" href="<?php echo base_url();?>user/setting"><i class="fa fa-key"></i>Settings</a>
      </li>
      <?php if($flag == '1') { ?>
        <li>
        <a class = "ayam" href="<?php echo base_url();?>setting"><i class="fa fa-key"></i>Header Setting</a>
      </li>
      <?php } ?>
      <li>
        <a class = "ayam" href="<?php echo base_url();?>welcome/load_Notes"><i class="fa fa-user-md"></i>Notes</a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<script type="text/javascript">

  $(document).on('click','.ayam',function(){
    var href = $(this).attr('href');
    $('#haha').empty().load(href).fadeIn('slow');
    return false;

 });

</script>

<script type="text/javascript">

  $('.apam').removeClass('active');

</script>

<script>
  $(document).ready(function(){
    $( "body" ).on( "click", ".ayam", function() {
      $('.ayam').each(function(a){
        $( this ).removeClass('selectedclass')
      });
      $( this ).addClass('selectedclass');
    });
  })
</script>


<style type="text/css">
  li a.selectedclass
  {
    color: #dd4b39 !important;
    font-weight: bold;
  }
</style>