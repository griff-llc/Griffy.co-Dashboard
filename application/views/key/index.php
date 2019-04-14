   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

    <div class = "row">
      <br />
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>User Name</th>
            <th>Email Address</th>
            <th>Regist Date</th>
            <th style='width:100px;'>Key</th>
            <th style="width:35px;">Action</th>
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
      table = $('#table').DataTable({         
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('key/ajax_list')?>",
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

    function edit_user(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('key/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {         
          $('[name="id"]').val(data.id);
          $('[name="key"]').val(data.key);
          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Show Key Info'); // Set title to Bootstrap modal title            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get user info');
        }
      });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function save()
    {
      var url = "<?php echo site_url('key/ajax_update')?>";

       // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          //if success close modal and reload ajax table
          $('#modal_form').modal('hide');
          reload_table();
          swal(
            '',
            'Key has been save!',
            'success'
          )
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error update key');
        }
      });
    }

  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">User Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Key</label>
                <div class="col-md-9">
                  <input name="key" placeholder="X1-ZWz1gwqfbx13ij_76gmj" class="form-control" type="text">
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
</body>
</html>