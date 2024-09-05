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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />

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
                  </h5>
                  <div class="row justify-content-end">
                    <span>
                      <button type="button" class="btn btn-primary pull-right text-white" onclick="openModal();">
                        <i class="align-middle me-1" data-feather="plus-circle"></i>
                        TAMBAH
                      </button>
                    </span>
                  </div>
                  <hr>
                  <div class="form-group row">
                    <label class="col-md-2 col-sm-12 col-form-label ">Filter data by</label>
                    <div class="col-md-4 col-sm-12 ">
                      <div id="reportrange"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>
                      </div>
                      <input type="hidden" name="start_date" id="start_date">
                      <input type="hidden" name="end_date" id="end_date">
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <select class="form-control" name="pilih_pt" id="pilih_pt" required="required">
                        <option disabled="disabled">-- Pilih --</option>
                        <option value="All" selected="selected">All</option>
                        <option value="1">PT. MULTI ARTA SEKAWAN</option>
                        <option value="2">PT. MULTI ARTA INDUSTRI</option>
                      </select>
                    </div>
                    <div class="col-md-2 col-sm-12">
                      <button id="btnCari" type="button" class="btn btn-info btn-full-mobile"
                        onclick="cari();">TAMPILKAN</button>
                    </div>
                  </div>
                  <hr>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="datatables-reponsive" class="table table-striped" width="150%">
                      <thead>
                        <tr class="bg-primary">
                          <th class="text-center text-white" width="20px">No</th>
                          <th class="text-center text-white" width="200px">#</th>
                          <th class="text-center text-white">No Request</th>
                          <th class="text-center text-white">Nama Pegawai</th>
                          <th class="text-center text-white">Department</th>
                          <th class="text-center text-white">Approve SPV User</th>
                          <th class="text-center text-white">Approve SPV IT</th>
                          <th class="text-center text-white">Status</th>
                          <th class="text-center text-white">Jenis Request</th>
                          <th class="text-center text-white" width="12%">Keterangan Request</th>
                          <th class="text-center text-white" width="12%">Keterangan IT</th>
                          <th class="text-center text-white">Created By</th>
                          <th class="text-center text-white">Created Date</th>
                          <th class="text-center text-white">Action</th>
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
              <label class="col-sm-4 col-form-label">No Request</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="norequest" name="norequest" disabled>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Jenis Request</label>
              <div class="col-sm-8">
                <select id="jenisrequest" name="jenisrequest" class="form-select">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <option value="SOFTWARE">SOFTWARE</option>
                  <option value="HARDWARE">HARDWARE</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Keterangan Request</label>
              <div class="col-sm-8">
                <!-- <textarea id="summernote" name="keterangan" class="form-control" required></textarea> -->
                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
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

  <div class="form1" id="form1">
    <div class="modal-header">
      <h5 class="modal-title">Default modal</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form action="" method="post" id="registerFormIT">
        <input type="hidden" value="" name="kode_1">
        <div class="form-group row mb-3">
          <label class="col-sm-4 col-form-label">Status</label>

          <div class="col-sm-8">
            <select id="status" name="status_1" class="form-select">
              <option selected="selected" disabled="disabled">-- Pilih --</option>
              <option value="Pending">Pending</option>
              <option value="Proses-Pengerjaan">Proses Pengerjaan</option>
              <option value="Menunggu-Sparepart">Menunggu Sparepart</option>
              <option value="Proses-Selesai">Proses Selesai</option>
              <option value="Selesai" disabled="disabled">Selesai</option>
            </select>
            <span class="help-block"></span>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label class="col-sm-4 col-form-label">Comment</label>
          <div class="col-sm-8">
            <textarea class="form-control" name="comment_1" id="comment" rows="3"></textarea>
            <span class="help-block"></span>
          </div>
        </div>
    </div>
    </form>
  </div>

  <div class="form2" id="form2">

    <div class="modal-header">
      <h5 class="modal-title">Default modal</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <form action="" method="post" id="registerFormIT">
        <div class="form-group row mb-3">
          <input type="hidden" value="" id="kode_2" name="kode_2">
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
            <textarea id="summernote" name="spesifikasi" class="form-control"></textarea>
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group row mb-3">
          <label class="col-sm-4 col-form-label">Comment</label>
          <div class="col-sm-8">
            <textarea class="form-control" name="comment_2" id="comment_2" rows="3" disabled></textarea>
            <span class="help-block"></span>
          </div>
        </div>
    </div>
    </form>
  </div>

  <div class="preview" id="preview">

    <div class="modal-header">
      <h5 class="modal-title">Default modal</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="table table-responsive">
        <div class="container">
          <div class="row">
            <div class="col-md-2">
              <h5>No. Document</h5>
            </div>
            <div class="col-md-4">
              <h5 id="nomor_document">No. Document</h5>
            </div>
            <div class="col-md-2">
              <h5>Nama Perusahaan</h5>
            </div>
            <div class="col-md-4">
              <h5 id="nama_perusahaan">Nama Perusahaan</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <h5>Nama Document</h5>
            </div>
            <div class="col-md-10">
              <h5 id="nama_document">No. Document</h5>
            </div>
          </div>
        </div>
        <table class="table table-striped table-bordered">
          <thead>
            <tr class="bg-primary">
              <th class="text-white text-center">No. Request</th>
              <th class="text-white text-center">Nama</th>
              <th class="text-white text-center">Dept / Bagian</th>
              <th class="text-white text-center">Status</th>
              <th class="text-white text-center">Jenis Request</th>
              <th class="text-white text-center">Keterangan Request</th>
              <th class="text-white text-center">Keterangan dari IT</th>
            </tr>
          </thead>
          <tbody id="isi_table"></tbody>
        </table>
        <div class="container">
          <div class="row justify-content-end">
            <div class="col-8">


              <table class="table table-striped table-bordered">
                <thead>
                  <tr class="bg-primary">
                    <thead>
                      <tr class="bg-primary">
                        <th class="text-white text-center">Approve SPV User</th>
                        <th class="text-white text-center">Aprove SPV IT</th>
                        <th class="text-white text-center">Selesai</th>
                      </tr>
                    </thead>
                  </tr>
                </thead>
                <tbody id="table_approve"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/datatables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>

  <script>
  $(document).ready(function() {
    // Sembunyikan form1 saat halaman dimuat
    $("#form1").hide();
    // Sembunyikan form2 saat halaman dimuat
    $("#form2").hide();
    // Sembunyikan preview saat halaman dimuat
    $("#preview").hide();
  });
  </script>
  <script>
  var save_method;
  var url

  function preview(id) {

    $.ajax({
      url: "<?php echo base_url(); ?>user_request/preview/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        let result = data[0];

        var rowHtml = `
            <tr>
                <td class="text-center">${result.no_request}</td>
                <td class="text-left">${result.nama_pegawai.toUpperCase()}</td>
                <td class="text-left">${result.nama_dept}</td>
                <td class="text-center">${result.status_trans}</td>  
                <td class="text-center">${result.jenis_request}</td>
                <td class="text-left">${result.keterangan} </td>
                <td class="text-left">${result.comment}</td>  
            </tr>
        `;

        var rowHtmlApprove = `
            <tr>
                <td class="text-center">${result.approve_spv_user === 'Approved' ? '<img class="img-fluid" src="<?php echo base_url(); ?>/assets/img/png/approve.png" alt="Approve">' : 'Belum Approve'}</td>
                <td class="text-center">${result.approve_spv_it === 'Approved' ? '<img class="img-fluid" src="<?php echo base_url(); ?>/assets/img/png/approve.png" alt="Approve">' : 'Belum Approve'}</td>
                <td class="text-center">${result.status_trans === 'Selesai' ? '<img class="img-fluid" src="<?php echo base_url(); ?>/assets/img/png/approve.png" alt="Approve">' : 'Belum Approve'}</td>
              
            </tr>
        `;

        var modalContent = $('#preview').html();
        $('#modalContent').html(modalContent);
        $('#modalFormIT').modal('show');
        $('#nama_perusahaan').html(result.nama.toUpperCase());
        $('#nama_document').html('FORM USER REQUEST');
        if (result.nama == "PT Multi Arta Sekawan") {
          $('#nomor_document').html('MAS/FO/IT/01');
        } else {
          $('#nomor_document').html('MAIN/FO/IT/01');
        }
        $('[name="kode"]').val(data.id);
        $('[name="norequest"]').val(data.no_request);
        $('#isi_table').html(rowHtml);
        $('#table_approve').html(rowHtmlApprove);
        $('.modal-title').text('Preview');
        $('.modal-footer').hide();

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }


  function getNamaPerangkat(id_perangkat) {
    // var kodePerangkat = $("#kode_perangkat_2").val();
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
          $('#summernote').val('');
        } else {
          $('#summernote').summernote('disable');
          $("#summernote").summernote('code', data.spesifikasi);
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

  function getNoRequest(callback) {
    $.ajax({
      url: '<?php echo base_url(); ?>user_request/getNoRequest',
      type: 'POST',
      success: function(response) {
        let norequest = response.replace(/"/g, '');
        // Panggil fungsi callback dan kirimkan respons sebagai argumen
        callback(norequest);
      },
      error: function(xhr, status, error) {
        console.error('Terjadi kesalahan:', error);
        // Anda dapat menangani kesalahan di sini
      }
    });
  }

  function openModal() {
    // Panggil getNoRequest dengan sebuah fungsi callback
    getNoRequest(function(norequest) {
      save_method = 'add';
      $("#pass_div").show();
      $('#btnSave').text('Save');
      $('#registerForm')[0].reset();
      $('.form-group').find(".has-error").removeClass("has-error");
      $('.help-block').empty();
      $('#modalForm').modal('show');
      $('.modal-title').text('Tambah Request');
      $('#norequest').val(norequest);
      $('.modal-footer').show();
    });
  }
  //FUNCTION CLOSE MODAL
  function closeModal() {
    $('#registerForm')[0].reset();
    $('#modalForm').modal('hide');
    $('.modal-title').text('Tambah Request');

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
          url: '<?php echo base_url(); ?>user_request/delete_data/' + id,
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

  //VALIDATION AND ADD USER
  function save() {
    $("#btnSave").html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
    $("#btnSave").attr('disabled', true);
    var url;

    if (save_method == 'add') {
      $("#pass_div").show();
      url = "<?php echo base_url(); ?>user_request/add_data";
    } else {
      $("#pass_div").hide();
      url = "<?php echo base_url(); ?>user_request/update_data";
    }
    $('#norequest').prop('disabled', false);
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

  //VALIDATION AND ADD USER
  function saveIT() {
    $("#btnSave").html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
    $("#btnSave").attr('disabled', true);
    var url;

    if ($('[name="status_1"]').val() === 'Proses-Selesai') {
      var waktuPenutupanOtomatis = setTimeout(function() {
        closeRequestSecaraOtomatis($('[name="kode_1"]').val());
      }, 2 * 60 * 1000);

      // Menyimpan ID timeout ke elemen HTML dengan ID tertentu
      $('[name="kode_1"]').data('timeoutId', waktuPenutupanOtomatis);
      console.log('waktuPenutupanOtomatis di berjalan');
    }


    if (save_method == 'updateIT') {
      url = "<?php echo base_url(); ?>user_request/update_data_it";
    } else if (save_method == 'addRiwayat') {
      url = "<?php echo base_url(); ?>user_request/friwayat_add_data";
    }
    $('#no_history').prop('disabled', false);
    $('#jenisrequest_2').prop('disabled', false);
    $('#keterangan_2').prop('disabled', false);
    $('#status_2').prop('disabled', false);
    $('#comment_2').prop('disabled', false);

    var data_save = $('#registerFormIT').serializeArray();
    $.ajax({
      url: url,
      type: "POST",
      data: data_save,
      dataType: "JSON",
      success: function(data) {
        if (data.status == 'ok') {
          $('#modalFormIT').modal('hide');

          reload_table();


        } else if (data.status == 'gagal') {
          Swal.fire(
            'FORBIDDEN',
            'Status Selesai tidak bisa diubah',
            'error',
          )
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
      url: "<?php echo base_url(); ?>user_request/edit_data/" + id,
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
          // $('#summernote').summernote('code', data.keterangan);
          $('[name="keterangan"]').val(data.keterangan);
          $('[name="kode"]').val(data.id);
          $('[name="norequest"]').val(data.no_request);
          $('[name="jenisrequest"]').val(data.jenis_request);
          $('#modalForm').modal('show');
          $('.modal-title').text('Edit Perangkat');
          $('.modal-footer').show();
          $('#btnSave').text('Update');
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  };

  function closeRequest(id) {
    Swal.fire({
      title: 'Apakah Anda Yakin?',
      // text: "Data yang di sudah di approve tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Selesai',
      cancelButtonText: 'Tidak, Batal'
    }).then((result) => {
      if (result.isConfirmed) {


        $.ajax({
          url: '<?php echo base_url(); ?>user_request/closeRequest/' + id,
          type: 'PUT',
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
            } else if (result.status == 'gagal') {
              Swal.fire(
                'SORRY',
                result.message,
                'error',
              )
            } else if (result.status == 'ok') {
              Swal.fire(
                'SUCCESS',
                result.message,
                'success',
              )
              $("#" + id).remove();
              reload_table();
            }
          }
        });
      }
    })
  }

  function riwayat(id) {
    getNoHistory(function(noHistory) {
      save_method = 'addRiwayat';
      $('#registerFormIT')[0].reset();
      $('.form-group').removeClass('has-error');
      $(".form-group>div").removeClass("has-error");
      $('.help-block').empty();
      //Ajax Load data from ajax
      $.ajax({
        url: "<?php echo base_url(); ?>user_request/edit_data_friwayat/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 'gagal') {
            Swal.fire(
              'SORRY',
              data.message,
              'error',
            )
          } else {
            var modalContent = $('#form2').html();
            $('#modalContent').html(modalContent);
            $('[name="kode_perangkat_2"]').prop('disabled', false);
            $('[name="keterangan_2"]').val(data.keterangan);
            $('[name="kode_2"]').val(data.id);
            $('[name="norequest_2"]').val(data.no_request);
            $('[name="jenisrequest_2"]').val(data.jenis_request);
            $('[name="kode_2"]').val(data.id);
            $('[name="status_2"]').val(data.status_trans);
            $('[name="comment_2"]').val(data.comment);
            $('#no_history').val(noHistory);
            $('#no_history').prop('disabled', true);
            $('#comment_2').prop('disabled', true);

            $("#kode_perangkat_2").on("keydown", function(event) {
              if (event.key === "Enter") {
                var kode_perangkat = $("#kode_perangkat_2").val();
                event.preventDefault(); // Menghentikan perilaku asli tombol Enter (misalnya, submit form)
                getNamaPerangkat(kode_perangkat);
              }
            });
            $('#summernote').prop('disabled', true);
            $('#summernote_2').summernote('reset');
            $('#modalFormIT').modal('show');
            $('.modal-title').text('Add Riwayat Perangkat');
            $('.modal-footer').show();
            $('#btnSave').text('Save');
          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });
    });
  }

  function cari() {
    var pilih_pt = $('#pilih_pt').val();
    localStorage.setItem("pilih_pt", pilih_pt);
    reload_table();
  }

  function approve_spv_it(id) {
    Swal.fire({
      title: 'Apakah anda Approve?',
      // text: "Data yang di sudah di approve tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Approve',
      cancelButtonText: 'Tidak, Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>user_request/update_approveit/' + id,
          type: 'PUT',
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
            } else if (result.status == 'gagal') {
              Swal.fire(
                'SORRY',
                result.message,
                'error',
              )
            } else if (result.status == 'ok') {
              Swal.fire(
                'SUCCESS',
                result.message,
                'success',
              )
              $("#" + id).remove();
              reload_table();
            }
          }
        });
      }
    })
  };

  //FUNCTINO APPROVE SPV
  function approve_spv_user(id) {
    Swal.fire({
      title: 'Apakah anda Approve?',
      // text: "Data yang di sudah di approve tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Approve',
      cancelButtonText: 'Tidak, Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>user_request/update_approveuser/' + id,
          type: 'PUT',
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
            } else if (result.status == 'gagal') {
              Swal.fire(
                'SORRY',
                result.message,
                'error',
              )
            } else if (result.status == 'ok') {
              Swal.fire(
                'SUCCESS',
                result.message,
                'success',
              )
              $("#" + id).remove();
              reload_table();
            }
          }
        });
      }
    })
  };

  function closeRequestSecaraOtomatis(id) {
    console.log('close autoid ' + id);
    $.ajax({
      url: '<?php echo base_url(); ?>user_request/closeRequest/' + id,
      type: 'PUT',
      error: function() {
        alert('Something is wrong');
      },
      success: function(data) {
        var result = JSON.parse(data);
        if (result.status == 'ok') {
          $("#" + id).remove();
          reload_table();
        }
      }
    });
  }

  function pelaksana(id) {
    save_method = 'updateIT';
    $('#registerFormIT')[0].reset();
    $('.form-group').removeClass('has-error');
    $(".form-group>div").removeClass("has-error");
    $('.help-block').empty();
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url(); ?>user_request/edit_data_pelaksana/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        if (data.status == 'forbidden') {
          Swal.fire(
            'FORBIDDEN',
            'Access Denied',
            'info',
          )
        } else if (data.status == 'gagal') {
          Swal.fire(
            'SORRY',
            data.message,
            'error',
          )
        } else {
          var modalContent = $('#form1').html();
          $('#modalContent').html(modalContent);
          $('[name="kode_1"]').val(data.id);
          $('[name="status_1"]').val(data.status_trans);
          $('[name="comment_1"]').val(data.comment);
          $('#modalFormIT').modal('show');
          $('.modal-title').text('Input Pelaksana');
          $('.modal-footer').show();
          $('#btnSave').text('Update');

        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }



  //FUNCTION RESET
  function reset() {
    $('#registerForm')[0].reset();
    $('.modal-title').text('Tambah Request');
  };

  //FUNCTION RELOAD TABLE
  function reload_table() {
    table.ajax.reload(null, false);
  };

  document.addEventListener("DOMContentLoaded", function(event) {

    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      var start_date = start.format('YYYY-MM-DD');
      var end_date = end.format('YYYY-MM-DD');

      $("#start_date").val(start_date);
      $("#end_date").val(end_date);
    }
    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
          'month')]
      }
    }, cb);
    cb(start, end);

    var pilih_pt = localStorage.getItem("pilih_pt");
    // console.log(pilih_pt);
    if (pilih_pt != null) {
      $('#pilih_pt').val(pilih_pt);
    } else {
      $('#pilih_pt').val('All');
    }
    $('#summernote_2').summernote({
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
      // "fixedHeader": true,
      responsive: false,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?php echo base_url(); ?>user_request/show",
        "type": "POST",
        "data": function(data) {
          data.start_date = $('#start_date').val();
          data.end_date = $('#end_date').val();
          data.pilih_pt = $('#pilih_pt').val();
        }
      },

      "aoColumns": [{
          "No": "No",
          "sClass": "text-right"
        },
        {
          "#": "#",
          "sClass": "text-center",
        },
        {
          "No Request": "No Request",
          "sClass": "text-left"
        },

        {
          "Nama Pegawai": "Nama Pegawai",
          "sClass": "text-left"
        },
        {
          "Department": "Department",
          "sClass": "text-left"
        },
        {
          "Approve Supervisor User": "Approve Supervisor User",
          "sClass": "text-left"
        },
        {
          "Approve Supervisor IT": "Approve Supervisor IT",
          "sClass": "text-left"
        },
        {
          "Status": "Status",
          "sClass": "text-center"
        },
        {
          "Jenis Request": "Jenis Request",
          "sClass": "text-left"
        },
        {
          "Keterangan Request": "Keterangan Request",
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
          "Created at": "Created at",
          "sClass": "text-left"
        },
        {
          "Action": "Action",
          "sClass": "text-left"
        }
      ],
      "columnDefs": [{
        "targets": [0],
        "orderable": false,
        className: 'text-right'
      }, ]
    });

    // Fungsi untuk mereload DataTable
    function refreshDataTable() {
      // Nonaktifkan indikator pemrosesan
      table.settings()[0].oFeatures.bProcessing = false;

      // Reload tabel tanpa mereset halaman saat ini
      table.ajax.reload(null, false);

      // Aktifkan kembali indikator pemrosesan setelah reload selesai
      setTimeout(function() {
        table.settings()[0].oFeatures.bProcessing = true;
      }, 0);
    }

    // Mereload DataTable setiap 5 detik
    setInterval(refreshDataTable, 5000);

    $("#norequest").change(function() {
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