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
  <link rel="shortcut icon"
    href="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->icon_name; ?>" />
  <link rel="canonical" href="<?php echo base_url(); ?>" />
  <title><?php echo $nama_halaman; ?> | <?php echo $perusahaan->nama; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
  <!-- BEGIN SETTINGS -->
  <!-- Remove this after purchasing -->
  <link class="js-stylesheet" href="<?php echo base_url(); ?>assets/css/light.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/customs.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
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
                  <h5 class="card-title text-left">
                    No. Document : <?= $no_document ?>
                  </h5>
                  <h5 class="card-title text-center">
                    <?php echo $nama_halaman; ?>
                    <span>
                      <button type="button" class="btn btn-primary pull-right text-white" onclick="openModal();">
                        <i class="align-middle me-1" data-feather="plus-circle"></i>
                        TAMBAH
                      </button>
                    </span>
                  </h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="datatables-reponsive" class="table table-striped" width="150%">
                      <thead>
                        <tr class="bg-primary">
                          <th class="text-center text-white" width="2%">No</th>
                          <th class="text-center text-white" width="12%">#</th>
                          <th class="text-center text-white">No History</th>
                          <th class="text-center text-white">Nama Perangkat</th>
                          <th class="text-center text-white">Keterangan</th>
                          <th class="text-center text-white">Created</th>
                          <th class="text-center text-white">Created Date</th>
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

  <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Default modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="" method="post" id="registerForm">
            <input type="hidden" value="" name="kode">
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">No History</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="no_history" name="no_history" disabled>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">kode Perangkat</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="kode_perangkat_2" name="kode_perangkat_2">
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Spesifikasi</label>
              <div class="col-sm-8">
                <textarea id="summernote" name="spesifikasi" class="form-control" disabled></textarea>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Comment</label>
              <div class="col-sm-8">
                <textarea class="form-control" name="comment_2" id="comment_2" rows="3"></textarea>
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

  <div class="modal fade" id="modalFormIT" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="modalContent">
          <!-- Konten formulir akan ditampilkan di sini -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="btnSave" class="btn btn-primary" onclick="saveIT();">Save</button>
        </div>
      </div>
    </div>
  </div>


  <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/datatables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  <script>
  var save_method;
  var url

  function getNamaPerangkat(id_perangkat) {
    $.ajax({
      url: '<?php echo base_url(); ?>user_request/getNamaPerangkat',
      method: 'POST',
      data: {
        kode_perangkat: id_perangkat
      },
      success: function(response) {
        // Set nilai nama perangkat yang diterima dari server ke input nama_perangkat_2
        let data = JSON.parse(response);
        if (response == "null") {
          Swal.fire(
            'FORBIDDEN',
            'Nama Perangkat tidak ditemukan!',
            'info',
          );
          $('#kode_perangkat_2').val('');
          // $('#nama_perangkat_2').val('');
        } else {
          $('#summernote').summernote('code', data.spesifikasi);
          $('#summernote').summernote('disable');
          // $("#nama_perangkat_2").val(data.id_perangkat);
        }
      },
      error: function() {
        // Handle kesalahan jika permintaan AJAX gagal
        alert('kode perangkat tidak ada.');
      }
    });
  }

  function getNoHistory(callback) {
    $.ajax({
      url: '<?php echo base_url(); ?>riwayat_perangkat/getNoHistory',
      type: 'POST',
      success: function(response) {
        let noHistory = response.replace(/"/g, '');
        // Panggil fungsi callback dan kirimkan respons sebagai argumen
        callback(noHistory);
      },
      error: function(xhr, status, error) {
        console.error('Terjadi kesalahan:', error);
        // Anda dapat menangani kesalahan di sini
      }
    });
  }

  function openModal() {
    // Panggil getNoRequest dengan sebuah fungsi callback
    getNoHistory(function(noHistory) {

      save_method = 'add';
      $('#registerForm')[0].reset();
      $("#pass_div").show();
      $('#btnSave').text('Save');
      // $('#registerForm')[0].reset();
      $('.form-group').find(".has-error").removeClass("has-error");
      $('.help-block').empty();
      $('#modalForm').modal('show');
      $('[name="kode_perangkat_2"]').prop('disabled', false);
      $('.modal-title').text('Tambah History');
      $('#no_history').val(noHistory);


      $("#kode_perangkat_2").on("keydown", function(event) {
        if (event.key === "Enter") {
          var kode_perangkat = $("#kode_perangkat_2").val();
          event.preventDefault(); // Menghentikan perilaku asli tombol Enter (misalnya, submit form)
          getNamaPerangkat(kode_perangkat);
        }
      });

      $('#summernote').summernote('reset');
    });
  }
  //FUNCTION CLOSE MODAL
  function closeModal() {
    $('#registerForm')[0].reset();
    $('#modalForm').modal('hide');
    $('.modal-title').text('Tambah Request');
  };

  //FUNCTION RESET
  function reset() {
    $('#registerForm')[0].reset();
    $('.modal-title').text('Tambah Request');
  };

  //FUNCTION RELOAD TABLE
  function reload_table() {
    table.ajax.reload(null, false);
  };

  //VALIDATION AND ADD USER
  function save() {
    $("#btnSave").html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
    $("#btnSave").attr('disabled', true);
    var url;

    if (save_method == 'add') {
      $("#pass_div").show();
      url = "<?php echo base_url(); ?>riwayat_perangkat/add_data";
    } else {
      $("#pass_div").hide();
      url = "<?php echo base_url(); ?>riwayat_perangkat/update_data";
    }
    $('#no_history').prop('disabled', false);
    $('[name="kode_perangkat_2"]').prop('disabled', false);
    var data_save = $('#registerForm').serializeArray();
    $.ajax({
      url: url,
      type: "POST",
      data: data_save,
      dataType: "JSON",
      success: function(data) {
        if (data.status == 'ok') {
          $('#modalForm').modal('hide');
          reload_table();
        } else if (data.status == 'forbidden') {
          Swal.fire(
            'FORBIDDEN',
            'Access Denied',
            'info',
          )
        } else {
          for (var i = 0; i < data.inputerror.length; i++) {
            $
            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
          }
        }
        $('#btnSave').text('Save');
        $('#btnSave').attr('disabled', false);
        $('#norequest').prop('disabled', true);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        $('#btnSave').text('Save');
        $('#btnSave').attr('disabled', false);
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
      url: "<?php echo base_url(); ?>riwayat_perangkat/edit_data/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 'forbidden') {
          Swal.fire(
            'FORBIDDEN',
            'Access Denied',
            'info',
          )
        } else {
          // $('#summernote').summernote('code', data.spesifikasi);
          $('#summernote').summernote('disable');
          $('[name="kode"]').val(data.id);
          $('[name="no_history"]').val(data.no_history);
          $('[name="kode_perangkat_2"]').val(data.nama_perangkat);
          $('[name="kode_perangkat_2"]').prop('disabled', true);

          getNamaPerangkat(data.nama_perangkat);
          $('[name="comment_2"]').val(data.keterangan);
          $('#no_history').prop('disabled', true);
          $('#modalForm').modal('show');
          $('.modal-title').text('Edit Perangkat');
          $('#btnSave').text('Update');
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
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
          url: '<?php echo base_url(); ?>riwayat_perangkat/delete_data/' + id,
          type: 'DELETE',
          error: function() {
            alert('Something is wrong');
          },
          success: function(data) {
            var result = JSON.parse(data);
            if (result.status == 'forbidden') {
              Swal.fire(
                'FORBIDDEN',
                'Access Denied',
                'info',
              )
            } else {
              $("#" + id).remove();
              reload_table();
            }
          }
        });
      }
    })
  };

  document.addEventListener("DOMContentLoaded", function(event) {
    $('#summernote').summernote({
      height: 150, //set editable area's height
      codemirror: { // codemirror options
        theme: 'monokai'
      }
    });

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
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?php echo base_url(); ?>riwayat_perangkat/show",
        "type": "POST",
      },

      "aoColumns": [{
          "No": "No",
          "sClass": "text-right"
        },
        {
          "#": "#",
          "sClass": "text-center"
        },
        {
          "No Request": "No Request",
          "sClass": "text-left"
        },
        {
          "Jenis Request": "Jenis Request",
          "sClass": "text-left"
        },

        {
          "Comment": "Comment",
          "sClass": "text-left"
        },
        {
          "Created": "Created",
          "sClass": "text-left"
        },
        {
          "Created Date": "Created Date",
          "sClass": "text-left"
        }
      ],
      "columnDefs": [{
        "targets": [0],
        "orderable": false,
        className: 'text-right'
      }, ]
    });

    $("#no_history").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#jenisrequest").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#keterangan").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

   
  });
  </script>
</body>

</html>