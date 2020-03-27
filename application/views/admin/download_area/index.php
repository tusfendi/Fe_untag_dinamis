

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="<?php echo site_url('admin/home') ?>">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">File di Download Area</li>
</ol>
<div class="col-xs-12">

  <div class="box">
    <div class="box-header">
      <h2 class="page-header" style="display: initial;">File di Download Area</h2>
      <a href="<?php echo site_url('admin/download_area/tambah')?> " class="btn btn-success" style="float: right;">Tambah File Baru</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="table" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                <th>No</th>
                <th>Judul</th>
                <th>File</th>
                <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
    </div>

  <script type="text/javascript">
    var table;
    $(document).ready( function () {

        //datatables
        table = $('#table').DataTable({ 

            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo site_url('admin/download_area/get_data')?>",
                "type": "POST"
            },

            
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],

        });

    });
  </script>