<?php $flag = 0 ?>
<nav class="sidebar">
			<div class="sidebar-content ">
        <!-- Logo -->
        <a href="/" style="text-decoration:none"class="un logo sidebar-brand"><b>ZILLOW </b></a>


				<ul class="sidebar-nav">
					<li class="sidebar-header">
          MAIN NAVIGATION
          </li>
					<li class="sidebar-item active">
						<a href="#dashboards" class="sidebar-link">
            <i class="align-middle" data-feather="sliders"></i>
            <span class="align-middle">Dashboard</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a href="#property-information" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="home"></i>
              <span class="align-middle">Property Information</span>
            </a>
						<ul id="property-information" class="sidebar-dropdown list-unstyled collapse ">
              <?php if($flag == '1') { ?>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?php echo base_url();?>user/getuser">
                <i class="align-middle" data-feather="user"></i>
                <span class="align-middle">User</span></a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?php echo base_url();?>key">
                  <i class="align-middle" data-feather="key"></i>
                  <span class="align-middle">Key List</span></a>
                </a>
              </li>
              <?php } ?>
              <?php if ($flag == '0') { ?>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?php echo base_url();?>address">
                  <i class="align-middle" data-feather="map"></i>
                  <span class="align-middle">Address</span></a>
              </a>
              </li> 
              <?php } ?>
            </ul>
					</li>
					<li class="sidebar-item">
            <a class = "sidebar-link" href="<?php echo base_url();?>user/setting">
              <i class="align-middle" data-feather="settings"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
          <?php if($flag == '1') { ?>
          <li class="sidebar-item">
            <a class = "sidebar-link" href="<?php echo base_url();?>setting">
              <i class="align-middle" data-feather="settings"></i>
              <span class="align-middle">Header Setting</span>
          </a>
          </li>
          <?php } ?>
          <li class="sidebar-item">
            <a class = "sidebar-link" href="<?php echo base_url();?>welcome/load_Notes">
            <i class="align-middle" data-feather="book-open"></i>
            <span class="align-middle">Notes</span>
          </a>
          </li>
				</ul>

				<div class="sidebar-bottom d-none d-lg-block">
					<div class="media">
						<img class="rounded-circle mr-3" src="img/avatars/avatar.jpg" alt="Chris Wood" width="40" height="40">
						<div class="media-body">
							<h5 class="mb-1">Chris Wood</h5>
							<div>
								<i class="fas fa-circle text-success"></i> Online
							</div>
						</div>
					</div>
				</div>

			</div>
		</nav>


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