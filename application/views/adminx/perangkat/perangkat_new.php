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

  /* Style untuk dropdown konten */
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: -160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 8px;
    /* Rounded corners */
    overflow: hidden;
    /* Mengatasi sudut yang melengkung */
  }

  .dropdown-content a {
    padding: 10px;
    display: block;
  }

  /* Style untuk menampilkan dropdown konten saat tombol dihover */
  .dropdown:hover .dropdown-content {
    display: block;
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
                          <th class="text-center text-white" width="7%">No</th>
                          <th class="text-center text-white">Kode Asset</th>
                          <th class="text-center text-white">Status</th>
                          <th class="text-center text-white">Perusahaan</th>
                          <th class="text-center text-white">Department</th>
                          <th class="text-center text-white">Jenis Perangkat</th>
                          <th class="text-center text-white">Nama Perangkat</th>
                          <th class="text-center text-white">Spesifikasi</th>
                          <th class="text-center text-white">Current User</th>
                          <th class="text-center text-white">IP Address</th>
                          <th class="text-center text-white">Password Komputer</th>
                          <th class="text-center text-white" width="10%">#</th>
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
        <div class="modal-body-info p-3">
          <div class=" row mb-3 border-bottom pb-3">
            <div class="col-sm-4">Perusahaan</div>
            <div class="col-sm-8" name="pt"></div>
          </div>
          <div class=" row mb-3 border-bottom pb-3">
            <div class="col-sm-4">Department</div>
            <div class="col-sm-8" name="dept"></div>
          </div>
          <div class=" row mb-3 border-bottom pb-3">
            <div class="col-sm-4">Jenis Perangkat</div>
            <div class="col-sm-8" name="jenisPerangkat"></div>
          </div>
          <div class=" row mb-3 border-bottom pb-3">
            <div class="col-sm-4">Nama Perangkat</div>
            <div class="col-sm-8" name="nama_perangkat"></div>
          </div>
          <div class=" row mb-3 border-bottom pb-3">
            <div class="col-sm-4">Spesifikasi</div>
            <div class="col-sm-8" name="spec"></div>
          </div>
          <div class=" row mb-3 border-bottom pb-3">
            <div class="col-sm-4">Status</div>
            <div class="col-sm-8" name="status_info"></div>
          </div>
          <div class=" row mb-3 border-bottom pb-3">
            <div id="panel-container"></div>
          </div>

        </div>
        <div class="modal-body">
          <form action="" method="post" id="registerForm">
            <input type="hidden" value="" name="kode">
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Perusahaan</label>
              <div class="col-sm-8">
                <select id="perusahaan" name="perusahaan" class="form-select"
                  onchange="get_department(); get_kode_perangkat();">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <?php foreach ($perusahaan_all as $key => $value) : ?>
                  <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>
                  <?php endforeach ?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group department row mb-3">
              <label class="col-sm-4 col-form-label">Department</label>
              <div class="col-sm-8">
                <select id="department" name="department" class="form-select" onchange="get_current_user()"
                  required="required">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group department row mb-3">
              <label class="col-sm-4 col-form-label">Current User</label>
              <div class="col-sm-8">
                <select id="current_user" name="current_user" class="form-select" required="required">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Jenis Perangkat</label>
              <div class="col-sm-8">
                <select id="jenis_perangkat" name="jenis_perangkat" class="form-select">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <?php foreach ($jenis_perangkat as $key => $value) : ?>
                  <option value="<?php echo $value->id; ?>"><?php echo $value->jenis; ?></option>
                  <?php endforeach ?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group  row mb-3">
              <label class="col-sm-4 col-form-label">Kode Perangkat</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="kode_perangkat" name="kode_perangkat">
              </div>
            </div>

            <div class="form-group  row mb-3">
              <label class="col-sm-4 col-form-label">Kode Asset</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="kode_asset" name="kode_asset">
              </div>
            </div>

            <div class="form-group  row mb-3">
              <label class="col-sm-4 col-form-label">Nama Perangkat</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="nama_perangkat" name="nama_perangkat">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Spesifikasi</label>
              <div class="col-sm-8">
                <textarea id="summernote" name="spesifikasi" class="form-control" required></textarea>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Status</label>
              <div class="col-sm-8">
                <select id="status" name="status" class="form-select">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <option value="AKTIF">AKTIF</option>
                  <option value="NON-AKTIF">NON-AKTIF</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group  row mb-3">
              <label class="col-sm-4 col-form-label">IP Address</label>
              <div class="col-sm-8">
                <input type="text" class="form-control input-box" id="ipAddress" name="ip_address"
                  placeholder="xxx.xxx.xxx.xx" autocomplete="off">
              </div>
            </div>

            <div class="form-group  row mb-3">
              <label class="col-sm-4 col-form-label">Password Komputer</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="pass_kom" name="pass_kom">
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
  <script>
  var save_method;
  var url

  function info(id) {
    save_method = 'update';
    $('#registerForm')[0].reset();
    $('.form-group').removeClass('has-error');
    $(".form-group>div").removeClass("has-error");
    $('.help-block').empty();
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url(); ?>perangkat_new/perangkat_edit_2/" + id,
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
          // console.log(data);
          get_historyPerangkat(data.id);
          // get_department2(data.company_id);
          $('#summernote').summernote('code', data.spesifikasi);
          $('[name="pt"]').html(data.nama);
          $('[name="dept"]').html(data.nama_dept);
          $('[name="jenisPerangkat"]').html(data.jenis);
          $('[name="nama_perangkat"]').html(data.nama_perangkat);
          $('[name="spec"]').html(data.spesifikasi);
          $('[name="status_info"]').html(data.status);
          $('[name="kode"]').val(data.id);
          $('[name="perusahaan"]').val(data.company_id);
          $('[name="jenis_perangkat"]').val(data.id_jenis_perangkat);
          $('#modalForm').modal('show');
          $('.modal-title').text('Info Perangkat');
          $('.modal-body-info').show();
          $('.modal-body').hide();
          $('#btnSave').hide();
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function print(id) {
    $.ajax({
      url: '<?php echo base_url(); ?>perangkat_new/print/' + id,
      type: "POST",
      dataType: "JSON",
      success: function(response) {
        // Hapus iframe yang sudah ada (jika ada)
        var existingIframe = document.querySelector('iframe');
        if (existingIframe) {
          existingIframe.parentNode.removeChild(existingIframe);
        }

        var iframe = document.createElement('iframe');
        iframe.style.visibility = 'hidden';
        iframe.style.position = 'absolute';
        iframe.src = response.pdfUrl;
        document.body.appendChild(iframe);

        iframe.onload = function() {
          // Fokuskan iframe dan lakukan pencetakan
          window.frames[0].focus();
          window.frames[0].print();
        };

        // Tambahkan event listener untuk menghapus iframe setelah pencetakan selesai
        window.onafterprint = function() {
          document.body.removeChild(iframe);
        };
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  }


  function print_old(id) {
    $.ajax({
      url: '<?php echo base_url(); ?>perangkat_new/print/' + id,
      type: "POST",
      dataType: "JSON",
      success: function(response) {
        // Hapus iframe yang sudah ada (jika ada)
        var existingIframe = document.querySelector('iframe');
        if (existingIframe) {
          existingIframe.parentNode.removeChild(existingIframe);
        }

        var iframe = document.createElement('iframe');
        iframe.style.visibility = 'hidden';
        iframe.style.position = 'absolute';
        iframe.src = response.pdfUrl;
        document.body.appendChild(iframe);
        iframe.onload = function() {
          // Fokuskan iframe dan lakukan pencetakan
          window.frames[0].focus();
          window.frames[0].print();
          //update print 
          // $.ajax({
          //   url: "<?php echo base_url(); ?>extrude_list/update_print",
          //   type: "POST",
          //   data: {
          //     id: id
          //   },
          //   success: function() {
          //     console.log("Kolom print diupdate.");
          //   },
          //   error: function() {
          //     console.log("Gagal mengupdate kolom print.");
          //     document.body.removeChild(iframe);
          //   }
          // });
        };
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  }

  function get_historyPerangkat(kode_perangkat) {
    var panelContainer = document.getElementById("panel-container");
    while (panelContainer.firstChild) {
      panelContainer.removeChild(panelContainer.firstChild);
    }
    $.ajax({
      url: '<?php echo base_url(); ?>perangkat_new/getHistoryPerangkat/' + kode_perangkat,
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        // console.log(data);
        var panelContainer = document.getElementById("panel-container");

        var panelDiv = document.createElement("div");
        panelDiv.classList.add("panel", "panel-danger");

        var panelHeadingDiv = document.createElement("div");
        panelHeadingDiv.classList.add("panel-heading");

        var panelTitle = document.createElement("h3");
        panelTitle.classList.add("panel-title");
        panelTitle.textContent = "Riwayat";
        panelHeadingDiv.appendChild(panelTitle);
        panelDiv.appendChild(panelHeadingDiv);
        for (var i = 0; i < data.length; i++) {

          var panelBodyDiv = document.createElement("div");
          panelBodyDiv.classList.add("panel-body");
          panelBodyDiv.textContent = data[i].created_at + " -> " + data[i].no_history + " : " + data[i]
            .keterangan;

          panelDiv.appendChild(panelBodyDiv);

        }
        panelContainer.appendChild(panelDiv);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        $('#btnSave').text('Save');
        $('#btnSave').attr('disabled', false);
      }
    });
  }

  function get_kode_perangkat() {
    var ids = $("#perusahaan :selected").val();
    if (ids == 1) {
      pt = "MAS";
    } else {
      pt = "MAIN";
    }
    // console.log(ids);
    $.ajax({
      url: '<?php echo base_url(); ?>perangkat_new/getKodePerangkat',
      type: "POST",
      data: {
        pt: pt
      },
      dataType: "JSON",
      success: function(data) {
        $('#kode_perangkat').val(data);
        $('#kode_perangkat').attr('disabled', true);

        $('.form-group.kode_perangkat').find(".has-error").removeClass("has-error");
        $('.form-group.kode_perangkat').find(".help-block").empty();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        $('#btnSave').text('Save');
        $('#btnSave').attr('disabled', false);
      }
    });
  }

  function get_current_user(deptID, selectedCurrentUser) {
    var id_dept = deptID || $("#department :selected").val();
    $.ajax({
      url: '<?php echo base_url(); ?>perangkat_new/get_current_user',
      type: "POST",
      data: {
        id_dept: id_dept
      },
      dataType: "JSON",
      success: function(data) {
        console.log(data);
        var html = '';
        var i;
        html = '<option selected="selected" disabled="disabled">-- Pilih --</option>';
        for (i = 0; i < data.length; i++) {
          var selected = (data[i].id == selectedCurrentUser) ? 'selected' : '';
          html += '<option value="' + data[i].id + '"' + selected + '>' + data[i].nama_pegawai + '</option>';
        }
        $('#current_user').html(html);
        // $('#current_user').attr('disabled', true);

        $('.form-group.current_user').find(".has-error").removeClass("has-error");
        $('.form-group.current_user').find(".help-block").empty();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        $('#btnSave').text('Save');
        $('#btnSave').attr('disabled', false);
      }
    });
  }


  function get_department(companyId, selectedDepartmentId) {
    var ids = companyId || $("#perusahaan :selected").val();

    $.ajax({
      url: '<?php echo base_url(); ?>departments/get_department_by_company',
      type: 'POST',
      data: {
        id: ids
      },
      dataType: 'JSON',
      success: function(data) {
        var html = '<option selected="selected" disabled="disabled">-- Pilih --</option>';
        for (var i = 0; i < data.length; i++) {
          var selected = (data[i].id == selectedDepartmentId) ? 'selected' : '';
          html += '<option value="' + data[i].id + '" ' + selected + '>' + data[i].nama_dept + '</option>';
        }
        $('#department').html(html);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error fetching department data');
        $('#btnSave').text('Save');
        $('#btnSave').attr('disabled', false);
      }
    });
  }

  //FUNCTION OPEN MODAL CABANG
  function openModal() {
    save_method = 'add';
    $("#pass_div").show();
    $('#btnSave').text('Save');
    $('#btnSave').show();
    $('#registerForm')[0].reset();
    //$('.form-group').removeClass('has-error');
    $('.form-group').find(".has-error").removeClass("has-error");
    var html = '<option selected="selected" disabled="disabled">-- Pilih --</option>';
    $('#department').html(html);
    $('#current_user').html(html);
    $('.help-block').empty();
    $('#modalForm').modal('show');
    $('.modal-body').show();
    $('.modal-body-info').hide();
    $('.modal-title').text('Tambah Perangkat');
    $('#summernote').summernote('reset');
  };

  //FUNCTION CLOSE MODAL
  function closeModal() {
    $('#registerForm')[0].reset();
    $('#modalForm').modal('hide');
    $('.modal-title').text('Tambah Perangkat');
  };

  //FUNCTION RESET
  function reset() {
    $('#registerForm')[0].reset();
    $('.modal-title').text('Tambah Perangkat');
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
      url = "<?php echo base_url(); ?>perangkat_new/perangkat_add";
    } else {
      $("#pass_div").hide();
      url = "<?php echo base_url(); ?>perangkat_new/perangkat_update";
    }
    $('#kode_perangkat').attr('disabled', false);
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
      url: "<?php echo base_url(); ?>perangkat_new/perangkat_edit/" + id,
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
          console.log(data);
          $('[name="perusahaan"]').val(data.company_id);
          // Clear error state of the department select
          $('.form-group.department').removeClass('has-error');
          $('.form-group.department .help-block').empty();

          // Load and set department options
          get_department(data.perusahaan, data.dept_id);
          // Clear error state of the department select
          $('.form-group.current_user').removeClass('has-error');
          $('.form-group.current_user .help-block').empty();
          get_current_user(data.dept_id, data.id_current_user);
          $('#summernote').summernote('code', data.spesifikasi);
          $('[name="kode"]').val(data.id);

          $('[name="kode_perangkat"]').val(data.kode_perangkat);
          $('#kode_perangkat').attr('disabled', true);
          $('[name="jenis_perangkat"]').val(data.id_jenis_perangkat);
          $('[name="nama_perangkat"]').val(data.nama_perangkat);
          $('[name="kode_asset"]').val(data.kode_asset);
          $('[name="status"]').val(data.status);
          $('[name="ip_address"]').val(data.ip_address);
          $('[name="pass_kom"]').val(data.pass_pc);
          $('#modalForm').modal('show');
          $('.modal-body').show();
          $('.modal-body-info').hide();
          $('.modal-title').text('Edit Perangkat');
          $('#btnSave').show();
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
          url: '<?php echo base_url(); ?>perangkat_new/perangkat_deleted/' + id,
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
        "url": "<?php echo base_url(); ?>perangkat_new/perangkat_list",
        "type": "POST",
      },

      "aoColumns": [{
          "No": "No",
          "sClass": "text-right"
        },
        {
          "Kode Asset": "Kode Asset",
          "sClass": "text-center"
        },
        {
          "Status": "Status",
          "sClass": "text-center"
        },
        {
          "Perusahaan": "Perusahaan",
          "sClass": "text-left"
        },
        {
          "Department": "Department",
          "sClass": "text-left"
        },
        {
          "Jenis Perangkat": "Jenis Perangkat",
          "sClass": "text-left"
        },
        {
          "Nama Perangkat": "Nama Perangkat",
          "sClass": "text-left"
        },
        {
          "Spesifikasi": "Spesifikasi",
          "sClass": "text-left"
        },
        {
          "Current User": "Current User",
          "sClass": "text-left"
        },
        {
          "IP Address": "IP Address",
          "sClass": "text-left"
        },
        {
          "Password Komputer": "Password Komputer",
          "sClass": "text-left"
        },
        {
          "#": "#",
          "sClass": "text-center"
        }
      ],
      "columnDefs": [{
        "targets": [0],
        "orderable": false,
        className: 'text-right'
      }, ]
    });

    $("#perusahaan").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#department").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#jenis_perangkat").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#status").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#nama_perangkat").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $(".spesifikasi").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });


  });
  </script>
</body>

</html>