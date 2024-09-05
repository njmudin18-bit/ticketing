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
                <div class="card-body ">
                  <div class="table-responsive">
                    <table id="datatables-reponsive" class="table table-striped" width="150%">
                      <thead>
                        <tr class="bg-primary">
                          <th class="text-center text-white" width="2%">No</th>
                          <th class="text-center text-white" width="12%">#</th>
                          <th class="text-center text-white">No Request</th>
                          <th class="text-center text-white">Nama Pegawai</th>
                          <th class="text-center text-white">Department</th>
                          <th class="text-center text-white">Approve SPV IT</th>
                          <th class="text-center text-white">Status</th>
                          <th class="text-center text-white">Jenis Request</th>
                          <th class="text-center text-white">Nama Request</th>
                          <th class="text-center text-white">Kebutuhan Request</th>
                          <th class="text-center text-white">Created</th>
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
                <input type="text" class="form-control" id="no_request" name="no_request" disabled>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Jenis Request</label>
              <div class="col-sm-8">
                <select id="jenis_request" name="jenis_request" class="form-select">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <option value="SOFTWARE">SOFTWARE</option>
                  <option value="HARDWARE">HARDWARE</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Nama Request</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="nama_request" name="nama_request">
                <span class="help-block"></span>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Keterangan Request</label>
              <div class="col-sm-8">
                <textarea class="form-control" name="kebutuhan_request" id="kebutuhan_request" rows="3"></textarea>
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
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>

  <script>
  var save_method;
  var url

  function getNoRequest(callback) {
    $.ajax({
      url: '<?php echo base_url(); ?>permintaan_fasilitas_kerja/getNoRequest',
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

  function cari() {
    var pilih_pt = $('#pilih_pt').val();
    localStorage.setItem("pilih_pt", pilih_pt);
    reload_table();
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
      $('#no_request').val(norequest);
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
          url: '<?php echo base_url(); ?>permintaan_fasilitas_kerja/delete_data/' + id,
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

  function gantiStatus(id) {
    Swal.fire({
      title: 'Pilih Status',
      input: 'select',
      inputOptions: {
        'Pending': 'Pending',
        'On-order': 'On-order',
        'Reject': 'Reject',
        'Selesai': 'Selesai'
      },
      inputPlaceholder: 'required',
      showCancelButton: true,
      inputValidator: function(value) {
        return new Promise(function(resolve, reject) {
          if (value !== '') {
            resolve();
          } else {
            resolve('Anda harus pilih dahulu!');
          }
        });
      }
    }).then(function(result) {
      if (result.isConfirmed) {
        var pilihStatus = result.value;
        console.log(pilihStatus + ' ' + id);
        $.ajax({
          url: '<?php echo base_url(); ?>permintaan_fasilitas_kerja/update_data_status',
          type: 'POST',
          data: {
            status: pilihStatus,
            kode: id
          },
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
    });
  }

  //VALIDATION AND ADD USER
  function save() {
    $("#btnSave").html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
    $("#btnSave").attr('disabled', true);
    var url;

    if (save_method == 'add') {
      $("#pass_div").show();
      url = "<?php echo base_url(); ?>permintaan_fasilitas_kerja/add_data";
    } else {
      $("#pass_div").hide();
      url = "<?php echo base_url(); ?>permintaan_fasilitas_kerja/update_data";
    }
    $('#no_request').prop('disabled', false);
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
        } else if (data.status == 'gagal') {
          Swal.fire(
            'FORBIDDEN',
            data.message,
            'info',
          );
          $('#modalForm').modal('hide');

        } else {
          for (var i = 0; i < data.inputerror.length; i++) {
            $
            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
          }
        }
        $('#btnSave').text('Save');
        $('#btnSave').attr('disabled', false);
        $('#no_request').prop('disabled', true);
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
      url: "<?php echo base_url(); ?>permintaan_fasilitas_kerja/edit_data/" + id,
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
          console.log(data);
          $('[name="kode"]').val(data.id);
          $('[name="no_request"]').val(data.no_request);
          $('[name="jenis_request"]').val(data.jenis_request);
          $('[name="nama_request"]').val(data.nama_request);
          $('[name="kebutuhan_request"]').val(data.kebutuhan_request);
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

  //FUNCTION RESET
  function reset() {
    $('#registerForm')[0].reset();
    $('.modal-title').text('Tambah Request');
  };

  //FUNCTION RELOAD TABLE
  function reload_table() {
    table.ajax.reload(null, false);
  };

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
          url: '<?php echo base_url(); ?>permintaan_fasilitas_kerja/update_approveit/' + id,
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
      responsive: false,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?php echo base_url(); ?>permintaan_fasilitas_kerja/show",
        "type": "POST",
        "data": function(data) {
          data.start_date = $('#start_date').val();
          data.end_date = $('#end_date').val();
          data.pilih_pt = $('#pilih_pt').val();
        },
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
          "Approve Supervisor IT": "Approve Supervisor IT",
          "sClass": "text-left"
        },
        {
          "Status": "Status",
          "sClass": "text-left"
        },
        {
          "Jenis Request": "Jenis Request",
          "sClass": "text-center"
        },
        {
          "Nama Request": "Nama Request",
          "sClass": "text-left"
        },
        {
          "Kebutuhan Request": "Kebutuhan Request",
          "sClass": "text-left"
        },
        {
          "Created": "Created",
          "sClass": "text-left"
        },

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

    $("#no_request").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#jenis_request").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#nama_request").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#kebutuhan_request").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });


  });
  </script>
</body>

</html>