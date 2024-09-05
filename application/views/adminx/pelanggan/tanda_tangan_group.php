<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Ticketing Apps - <?php echo $perusahaan->nama; ?>">
    <meta name="author" content="IT Department - <?php echo $perusahaan->nama; ?>">
    <meta name="keywords" content="Ticketing Apps - <?php echo $perusahaan->nama; ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->icon_name; ?>" />
    <link rel="canonical" href="<?php echo base_url(); ?>" />
    <title><?php echo $nama_halaman; ?> | <?php echo $perusahaan->nama; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <link class="js-stylesheet" href="<?php echo base_url(); ?>assets/css/light.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/customs.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
    <style>
      body {
        opacity: 0;
      }
    </style>
    <!-- END SETTINGS -->
  </head>
  <body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
      
      <?php $this->load->view('adminx/components/sidebar'); ?>

      <div class="main">
        <?php $this->load->view('adminx/components/navbar'); ?>

        <main class="content">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-12">
                <div class="card table">
                  <div class="card-header">
                    <h5 class="card-title text-center">
                      <?php echo $nama_halaman; ?>
                      <span>
                        <button type="button" class="btn btn-primary pull-right text-white btn-sm me-2" onclick="openModal();">
                          <i class="align-middle me-1" data-feather="plus-circle"></i>
                          CREATE GROUP
                        </button>
                      </span>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="datatables-reponsive" class="table table-striped table-bordered" width="150%">
                        <thead>
                          <tr class="bg-primary">
                            <th class="text-center text-white" width="5%">No</th>
                            <th class="text-center text-white" width="7%">#</th>
                            <th class="text-center text-white">Status</th>
                            <th class="text-center text-white">Perusahaan</th>
                            <th class="text-center text-white">Dibuat oleh</th>
                            <th class="text-center text-white">Diperiksa oleh</th>
                            <th class="text-center text-white">Disetujui oleh</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>

        <?php $this->load->view('adminx/components/footer'); ?>
      </div>
    </div>

    <!-- MODAL FORM GROUP -->
    <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Default modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="registerForm">
              <input type="hidden" value="" name="kode" >
              <div class="form-group row mb-3">
                <label class="col-sm-4 col-form-label">Perusahaan</label>
                <div class="col-sm-8">
                  <select id="perusahaan" name="perusahaan" class="form-select" onchange="get_signatory();">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                    <?php foreach ($perusahaan_all as $key => $value): ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>
                    <?php endforeach ?>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-4 col-form-label">Dibuat oleh</label>
                <div class="col-sm-8">
                  <select id="dibuat_oleh" name="dibuat_oleh" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-4 col-form-label">Diperiksa oleh</label>
                <div class="col-sm-8">
                  <select id="diperiksa_oleh" name="diperiksa_oleh" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-4 col-form-label">Disetujui oleh</label>
                <div class="col-sm-8">
                  <select id="disetujui_oleh" name="disetujui_oleh" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                  <select id="status" name="status" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                    <option value="AKTIF">AKTIF</option>
                    <option value="TIDAK">TIDAK</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="btnSave" class="btn btn-primary" onclick="save();">Save</button>
          </div>
        </div>
      </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      var save_method;
      var url;

      //FUNGSI GET NOMOR DOCUMENT
      function get_signatory() {
        var company_id = $("#perusahaan :selected").val();
        $.ajax({
          url : '<?php echo base_url(); ?>signaturegroup/get_signature',
          type: "POST",
          data: {id: company_id},
          dataType: "JSON",
          success: function(data)
          {
            const dibuat    = data.data_level_1.filter(x => x.Title == 'Dibuat');
            const diperiksa = data.data_level_2.filter(x => x.Title == 'Diperiksa');
            const disetujui = data.data_level_2.filter(x => x.Title == 'Disetujui');

            //UNTUK DI DIBUAT
            var i;
            var html  = '';
            html      = '<option disabled>-- Pilih --</option>';
            for(i = 0; i < dibuat.length; i++){
              html += '<option selected value="'+ dibuat[i].Nip +'">' +  dibuat[i].Nip + ' - ' + dibuat[i].nama_pegawai + ' - ' + dibuat[i].nama_dept + '</option>';
            }
            $('#dibuat_oleh').html(html);

            //UNTUK DICEK
            var j;
            var html2 = '';
            html2     = '<option disabled>-- Pilih --</option>';
            for(j = 0; j < diperiksa.length; j++){
              html2 += '<option selected value="'+ diperiksa[j].Nip +'">' +  diperiksa[j].Nip + ' - ' + diperiksa[j].nama_pegawai + ' - ' + diperiksa[j].nama_dept + '</option>';
            }
            $('#diperiksa_oleh').html(html2);
            
            //UNTUK DISETUJUI
            var k;
            var html2 = '';
            html2     = '<option disabled>-- Pilih --</option>';
            for(k = 0; k < disetujui.length; k++){
              html2 += '<option selected value="'+ disetujui[k].Nip +'">' +  disetujui[k].Nip + ' - ' + disetujui[k].nama_pegawai + ' - ' + disetujui[k].nama_dept + '</option>';
            }
            $('#disetujui_oleh').html(html2);

            $('.form-group').find(".has-error").removeClass("has-error");
            $('.help-block').empty();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error adding / update data');
            $('#btnSave').text('Save');
            $('#btnSave').attr('disabled',false);
          }
        });
      }

      function get_signatory2(CompanyID, DibuatOleh, DiperiksaOleh, DisetujuiOleh) {
        $.ajax({
          url : '<?php echo base_url(); ?>signaturegroup/get_signature',
          type: "POST",
          data: {id: CompanyID},
          dataType: "JSON",
          success: function(data)
          {
            const dibuat    = data.data_level_1.filter(x => x.Title == 'Dibuat');
            const diperiksa = data.data_level_2.filter(x => x.Title == 'Diperiksa');
            const disetujui = data.data_level_2.filter(x => x.Title == 'Disetujui');

            //UNTUK DI DIBUAT
            var i;
            var html  = '';
            html      = '<option disabled>-- Pilih --</option>';
            for(i = 0; i < dibuat.length; i++){
              if (DibuatOleh == dibuat[i].Nip) {
                html += '<option selected value="'+ dibuat[i].Nip +'">' +  dibuat[i].Nip + ' - ' + dibuat[i].nama_pegawai + ' - ' + dibuat[i].nama_dept + '</option>';
              } else {
                html += '<option value="'+ dibuat[i].Nip +'">' +  dibuat[i].Nip + ' - ' + dibuat[i].nama_pegawai + ' - ' + dibuat[i].nama_dept + '</option>';
              }
            }
            $('#dibuat_oleh').html(html);

            //UNTUK DICEK
            var j;
            var html2 = '';
            html2     = '<option disabled>-- Pilih --</option>';
            for(j = 0; j < diperiksa.length; j++){
              if (DiperiksaOleh == diperiksa[j].Nip) {
                html2 += '<option selected value="'+ diperiksa[j].Nip +'">' +  diperiksa[j].Nip + ' - ' + diperiksa[j].nama_pegawai + ' - ' + diperiksa[j].nama_dept + '</option>';
              } else {
                html2 += '<option value="'+ diperiksa[j].Nip +'">' +  diperiksa[j].Nip + ' - ' + diperiksa[j].nama_pegawai + ' - ' + diperiksa[j].nama_dept + '</option>';
              }
            }
            $('#diperiksa_oleh').html(html2);
            
            //UNTUK DISETUJUI
            var k;
            var html2 = '';
            html2     = '<option disabled>-- Pilih --</option>';
            for(k = 0; k < disetujui.length; k++){
              if (DisetujuiOleh == disetujui[k].Nip) {
                html2 += '<option selected value="'+ disetujui[k].Nip +'">' +  disetujui[k].Nip + ' - ' + disetujui[k].nama_pegawai + ' - ' + disetujui[k].nama_dept + '</option>';
              } else {
                html2 += '<option value="'+ disetujui[k].Nip +'">' +  disetujui[k].Nip + ' - ' + disetujui[k].nama_pegawai + ' - ' + disetujui[k].nama_dept + '</option>';
              }
            }
            $('#disetujui_oleh').html(html2);

            $('.form-group').find(".has-error").removeClass("has-error");
            $('.help-block').empty();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error adding / update data');
            $('#btnSave').text('Save');
            $('#btnSave').attr('disabled',false);
          }
        });
      }

      //FUNCTION OPEN MODAL CABANG
      function openModal() {
        save_method = 'add';
        $("#pass_div").show();
        $('#btnSave').text('Save');
        $('#registerForm')[0].reset();
        $('.form-group').find(".has-error").removeClass("has-error");
        $('.help-block').empty();
        $('#modalForm').modal('show');
        $('.modal-title').text('Tambah Group Tanda Tangan');

        $('#dibuat_oleh').empty().append('<option selected="selected" disabled="disabled">-- Pilih --</option>');
        $('#diperiksa_oleh').empty().append('<option selected="selected" disabled="disabled">-- Pilih --</option>');
        $('#disetujui_oleh').empty().append('<option selected="selected" disabled="disabled">-- Pilih --</option>');
      };

      //FUNCTION CLOSE MODAL
      function closeModal(){
        $('#registerForm')[0].reset();
        $('#modalForm').modal('hide');
        $('.modal-title').text('Tambah Group Tanda Tangan');
      };

      //FUNCTION RESET
      function reset() {
        $('#registerForm')[0].reset();
        $('.modal-title').text('Tambah Group Tanda Tangan');
      };

      //FUNCTION RELOAD TABLE
      function reload_table(){
        table.ajax.reload(null,false);
      };

      //VALIDATION AND ADD USER
      function save()
      {
        $("#btnSave").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        $("#btnSave").attr('disabled', true);
        var url;

        if(save_method == 'add') {
          $("#pass_div").show();
          url = "<?php echo base_url(); ?>signaturegroup/signature_group_add";
        } else {
          $("#pass_div").hide();
          url = "<?php echo base_url(); ?>signaturegroup/signature_group_update";
        }
        
        var data_save = $('#registerForm').serializeArray();
        $.ajax({
            url : url,
            type: "POST",
            data: data_save,
            dataType: "JSON",
            success: function(data)
            {
              if(data.status == 'ok')
              {
                $('#modalForm').modal('hide');
                reload_table();
              } else if (data.status == 'forbidden') {
                Swal.fire(
                  'FORBIDDEN',
                  'Access Denied',
                  'info',
                )
              } else {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
              }
              $('#btnSave').text('Save');
              $('#btnSave').attr('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error adding / update data');
              $('#btnSave').text('Save');
              $('#btnSave').attr('disabled',false);
            }
        });

      };

      //FUNCTION EDIT
      function edit(id) {
        save_method = 'update';
        $('#registerForm')[0].reset();
        $('.form-group').removeClass('has-error');
        $(".form-group>div").removeClass("has-error");
        $('.help-block').empty();
        //Ajax Load data from ajax
        $.ajax({
          url : "<?php echo base_url(); ?>signaturegroup/signature_group_edit/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            if (data.status == 'forbidden'){
              Swal.fire(
                'FORBIDDEN',
                'Access Denied',
                'info',
              )
            } else {
              let CompanyID     = data.CompanyID;
              let DibuatOleh    = data.DibuatOleh;
              let DiperiksaOleh = data.DiperiksaOleh;
              let DisetujuiOleh = data.DisetujuiOleh;

              get_signatory2(CompanyID, DibuatOleh, DiperiksaOleh, DisetujuiOleh);

              $('[name="kode"]').val(data.id);
              $('[name="perusahaan"]').val(data.CompanyID);
              $('[name="status"]').val(data.Status);
              $('#modalForm').modal('show');
              $('.modal-title').text('Edit Group Tanda Tangan');
              $('#btnSave').text('Update');
            }
            
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
      };

      //FUNCTION HAPUS
      function openModalDelete(id) {
      	Swal.fire({
				  title: 'Apakah anda yakin?',
				  text: "Data yang dihapus tidak bisa dikembalikan!",
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, hapus',
				  cancelButtonText: 'Tidak, Batal'
				}).then((result) => {
				  if (result.isConfirmed) {
				    $.ajax({
              url: '<?php echo base_url(); ?>signaturegroup/signature_group_deleted/' + id,
              type: 'DELETE',
              error: function() {
                alert('Something is wrong');
              },
              success: function(data) {
                var result = JSON.parse(data);
                if (result.status == 'forbidden'){
                  Swal.fire(
                    'FORBIDDEN',
                    'Access Denied',
                    'info',
                  )
                } else {
                  $("#"+id).remove();
                  reload_table();
                }
              }
            });
				  }
				})
      };

      document.addEventListener("DOMContentLoaded", function(event) {
        table = $('#datatables-reponsive').DataTable({ 
	      		"pagingType": "full_numbers",
	      		"lengthMenu": [
		          [10, 25, 50, -1],
		          [10, 25, 50, "All"]
		        ],
		        responsive: false,
		        language: {
		          search: "_INPUT_",
		          searchPlaceholder: "Search records",
		        },
            "processing": true,
            "serverSide": false,
            "order": [],
            "ajax": {
              "url": "<?php echo base_url(); ?>signaturegroup/signature_group_list",
              "type": "POST",
            },

            "aoColumns": [
              { "No": "No" , "sClass": "text-end"},
              { "#": "#" , "sClass": "text-center" },
              { "Status": "Status" , "sClass": "text-center" },
              { "Perusahaan": "Perusahaan" , "sClass": "text-start" },
              { "Dibuat oleh": "Dibuat oleh" , "sClass": "text-start" },
              { "Diperiksa oleh": "Diperiksa oleh" , "sClass": "text-start" },
              { "Disetujui oleh": "Disetujui oleh" , "sClass": "text-start" }
            ],

            "columnDefs": [
              { 
                "targets": [ 0 ],
                "orderable": false,
                className: 'text-right'
              },
            ]
        });

        $("#perusahaan").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#dibuat_oleh").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#diperiksa_oleh").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#disetujui_oleh").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#status").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

       
      });
    </script>
  </body>
</html>