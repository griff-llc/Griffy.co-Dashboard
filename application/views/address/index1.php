    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap-filestyle.min.js"> </script>
    <div class = "row">
    
      <button id="save-address" class="btn btn-success" onclick="add_address()"><i class="glyphicon glyphicon-plus"></i> Add New Address</button>
      <button id="get-address-info" class="btn btn-success" onclick="startPoint()"><i class="glyphicon glyphicon-search"></i> Get Data</button>
      <button id="get-address-info" class="btn btn-success" onclick="exportAddress()"><i class="glyphicon glyphicon-download-alt"></i> Export Data</button>
      <button id="get-address-info" class="btn btn-success" onclick="settingAddress()"><i class="glyphicon glyphicon-check"></i> Setting Grid</button>
      <br/>
      <br/>
      <div style="width:200px;">
        <form class="md-form" method="post" id="import_csv" enctype="multipart/form-data" style="display:-webkit-inline-box;">
          <div class="form-group">
              <label>Select CSV FILE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/assets/example.csv">Example CSV</a></label>
              <input type="file" name="csv_file" id="csv_file" required accept=".csv" class="filestyle" data-buttonText="CSV File">
          </div>                    
          <br />
          <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn" style="position:relative;top:5px;">Import CSV</button>
        </form>
        <div id="imported_csv_data"></div>
      </div>
      <br />
      <br/>
      <div class="progress">
        <div class="progress-bar progress-bar-danger" style="width: 0%">
            
        </div>
      </div>
      <br />
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Street Number</th>
            <th>Street Name</th>
            <th>City</th>
            <th>State</th>
            <th>zipcode</th>
            <th>Regist</th>
            <th>Start Time</th>
            <th style="width:200px;">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    

    var save_method; //for save method string
    var table;
    $(document).ready(function() {
     
      $('#import_csv').on('submit', function(event){
        event.preventDefault();
        $.ajax({
          url:"<?php echo base_url(); ?>address/import",
          method:"POST",
          data:new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            $('#import_csv_btn').attr('disabled', true);
            $('#import_csv_btn').html('Importing...');
            $('#get-address-info').prop('disabled',true);
          },
          success:function(data)
          {
            $('#import_csv')[0].reset();
            $('#import_csv_btn').attr('disabled', false);
            $('#import_csv_btn').html('Import Done');
            $('#get-address-info').prop('disabled',false);
            swal(
              '',
              'Import Done!',
              'success'
            )
            reload_table();
          }
        })
      });
      
      
      table = $('#table').DataTable({         
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "buttons" :[ 'colvis' ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('address/ajax_list')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
          { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
          },
        ],
      });
    });

    function exportAddress()
    {

    }

    var result = [];
    function getData(index,total) {      
      if(index >= total || total == 0) {
        $('.progress .progress-bar-danger').css('width','100%');
        $('.progress .progress-bar-danger')[0].innerText = ' Complete ';
        $('#get-address-info').prop('disabled',false);
        $('#save-address').prop('disabled',false);
        $('#import_csv_btn').attr('disabled', false);
      } else {
        
        $.ajax({
          url : "<?php echo site_url('address/update_address_info')?>/" + result[index],
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {         
              var idx = index + 1;
              //show progress
              $('.progress .progress-bar-danger')[0].innerText = idx + ' / ' + total;
              var dxwidth = parseInt(100/total*(idx)) + '%';
              reload_table();        
              $('.progress .progress-bar-danger').css('width',dxwidth );
              //update address
              getData(idx,total);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get address info');
          }
        });
      }
    }
    
    function startPoint()
    {
      result = [];
      $('#get-address-info').prop('disabled',true);
      $('#save-address').prop('disabled',true);
      $('#import_csv_btn').attr('disabled', true);

      $('.progress .progress-bar-danger').css('width','0%');
      $.ajax({
        url : "<?php echo site_url('address/get_address_info')?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {         
            result = data;
            var length = data.length;
            getData(0,length);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get address info');
        }
      });
    }

    function add_address()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_address').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New Address'); // Set Title to Bootstrap modal title
    }

    function view_address(id) {      
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('address/ajax_addgree_info/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {         
          $('[name="amount"]').val(data.response.results.result.zestimate.amount);
          $('[name="amount_low"]').val(data.response.results.result.zestimate.valuationRange.low);
          $('[name="amount_high"]').val(data.response.results.result.zestimate.valuationRange.high);          
          $('#modal_address_info').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Show Address Info'); // Set title to Bootstrap modal title            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get address info');
        }
      });
    }

    function edit_address(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('address/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {         
          $('[name="id"]').val(data.id);
          $('[name="street_number"]').val(data.street_number);
          $('[name="street_name"]').val(data.street_name);
          $('[name="street_suffix"]').val(data.street_suffix);
          $('[name="city"]').val(data.city);
          $('[name="state"]').val(data.state);
          $('[name="zipcode"]').val(data.zipcode);
          $('[name="full_address"]').val(data.full_address);

          $('#modal_address').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Show Address Info'); // Set title to Bootstrap modal title            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get address info');
        }
      });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function save()
    {
      if(check()) {
        var url;
        if(save_method == 'add') 
        {
          url = "<?php echo site_url('address/ajax_add')?>";
        }
        else
        {
          url = "<?php echo site_url('address/ajax_update')?>";
        }

        // ajax adding data to database
        $.ajax({
          url : url,
          type: "POST",
          data: $('#form').serialize(),
          dataType: "JSON",
          success: function(data)
          {
            //if success close modal and reload ajax table
            $('#modal_address').modal('hide');
            reload_table();
            swal(
              '',
              'Address have been save!',
              'success'
            )
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error update address');
          }
        });
      } else {
        
      }
    }

    function check() {
      if(document.getElementsByName('full_address')[0].value.length == 0) {
        alert("Input the full address.");        
        return false;
      } 
      
      if(document.getElementsByName('street_number')[0].value.length == 0) {
        alert("Input the street number.");
        return false;
      } 

      if(document.getElementsByName('street_name')[0].value.length == 0) {
        alert("Input the street name.");
        return false;
      } 

      if(document.getElementsByName('city')[0].value.length == 0) {
        alert("Input the city.");
        return false;
      } 

      if(document.getElementsByName('state')[0].value.length == 0) {
        alert("Input the state.");
        return false;
      } 

      if(document.getElementsByName('zipcode')[0].value.length == 0) {
        alert("Input the zipcode.");
        return false;
      } 
      return true;
    }
    function delete_address(id)
    {
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      }).then(function(isConfirm) {
        if (isConfirm) {

          // ajax delete data to database
          $.ajax({
            url : "<?php echo site_url('address/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              //if success reload ajax table
              $('#modal_address').modal('hide');
              reload_table();
              swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              );
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error delete the address');
            }
          });
        }    
      })      
    }

  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_address" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Address Input Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">              
                <div class="col-md-12">
                  <label class="control-label">Full Address</label>
                  <input id="autocomplete" name="full_address" placeholder="Enter your address" class="form-control" type="text" required onFocus="geolocate()">
                </div>
              </div>
              <div class="form-group">                
                <div class="col-md-3">
                  <label class="control-label">Street Number</label>
                  <input name="street_number" id="street_number" placeholder="xxxx" class="form-control" type="text" required>
                </div>
                <div class="col-md-9">
                  <label class="control-label">Street Name</label>
                  <input name="street_name" id="route" placeholder="ALAMONTE" class="form-control" type="text" required>
                </div>
              </div>           
              <div class="form-group">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom03">City</label>
                  <input type="text" name="city" id="locality" class="form-control" id="validationCustom03" placeholder="City" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="validationCustom04">State</label>
                  <input type="text" name="state" id="administrative_area_level_1" class="form-control" id="validationCustom04" placeholder="State" required>                  
                </div>
                <div class="col-md-3 mb-3">
                  <label for="validationCustom05">Zip</label>
                  <input type="text" name="zipcode" id="postal_code" class="form-control" id="validationCustom05" placeholder="Zip" required>                  
                </div>
              </div>
            </div>
          </form>
        </div>        
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="modal_address_info" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Address Info Form</h3>
        </div>
        <div class="modal-body form" style="height:100px;">
          <div class="form-group">
            <div class="col-md-4">
              <label class="control-label">Amount</label>
              <input name="amount" id="street_number" placeholder="xxxx" class="form-control" type="text">
            </div>
            <div class="col-md-4">
              <label class="control-label">Low</label>
              <input name="amount_low" id="route" placeholder="ALAMONTE" class="form-control" type="text">
            </div>
            <div class="col-md-4">
              <label class="control-label">High</label>
              <input name="amount_high" id="route" placeholder="ALAMONTE" class="form-control" type="text">
            </div>            
          </div>
        </div> 
        <div class="modal-footer">          
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>      
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</body>
<script>
  var placeSearch, autocomplete;

  var componentForm = {
    street_number: 'short_name',
    route: 'short_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    postal_code: 'short_name'
  };

  function initAutocomplete() {
    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
    document.getElementById('autocomplete'), {types: ['geocode']});

    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components.
    autocomplete.setFields(['address_component']);

    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {
    
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    for (var component in componentForm) {
      document.getElementById(component).value = '';
      document.getElementById(component).disabled = false;
    }
    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
      
      var addressType = place.address_components[i].types[0];
      
      if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        
        document.getElementById(addressType).value = val;
      }
    }
  }

  // Bias the autocomplete object to the user's geographical location,
  // as supplied by the browser's 'navigator.geolocation' object.
  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var circle = new google.maps.Circle(
            {center: geolocation, radius: position.coords.accuracy});
        autocomplete.setBounds(circle.getBounds());
      });
    }
  }
</script>
<script>
    if (typeof google === 'object' && typeof google.maps === 'object') {

      initAutocomplete();

    } else {

      var script = document.createElement("script");

      script.type = "text/javascript";

      script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBVf0m4pHn-0t4xx-x4dBK9ZzKtT-iSv_o&libraries=places&callback=initAutocomplete";

      document.body.appendChild(script);
    }
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVf0m4pHn-0t4xx-x4dBK9ZzKtT-iSv_o&libraries=places&callback=initAutocomplete" async defer></script> -->
</html>