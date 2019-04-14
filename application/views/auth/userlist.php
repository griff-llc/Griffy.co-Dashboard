<?php $this->load->view('html/head'); ?>
<h1 class="h3 mb-3">KEY</h1>
  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill w-100">
        <div class="card-body">
          <table id="table" class="table table-striped dataTable no-footer dtr-inline" cellspacing="0" width="100%">
            <thead>
          <tr>
            <th>User Name</th>
            <th>Email Address</th>            
            <th>Regist Date</th>
            <th style="width:35px;">Action</th>
          </tr>
          </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
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
          "url": "<?php echo site_url('user/ajax_list')?>",
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

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function delete_user(id)
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
            url : "<?php echo site_url('user/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              //if success reload ajax table
              $('#modal_form').modal('hide');
              reload_table();
              swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              );
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error delete the user');
            }
          });
        }    
      })      
    }

  </script>
<?php $this->load->view('html/footer'); ?>