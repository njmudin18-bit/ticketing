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

                      <button type="button" class="btn btn-primary pull-right text-white" onclick="openModal();">

                        <i class="align-middle me-1" data-feather="plus-circle"></i>

                        TAMBAH

                      </button>

                    </span>

                  </h5>

                </div>

                <div class="card-body">

                  <div class="table-responsive">

                    <table id="datatables-reponsive" class="table table-striped" width="180%">

                      <thead>

                        <tr class="bg-primary">

                          <th class="text-white">No</th>

                          <th class="text-white" width="150px">#</th>

                          <th class="text-white">DEPT</th>

                          <th class="text-white">NIP</th>

                          <th class="text-white">Nama</th>

                          <th class="text-white">Email</th>

                          <!-- <th class="text-white">Username</th> -->

                          <th class="text-white">Perusahaan</th>

                          <th class="text-white">Roles</th>

                          <th class="text-white">Aktivasi</th>

                          <th class="text-white">Last login</th>

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



  <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title">Default modal</h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <form action="" method="post" id="registerForm">

            <input type="hidden" value="" name="kode">

            <div class="form-group row mb-3">

              <label class="col-sm-2 col-form-label">Perusahaan</label>

              <div class="col-sm-10">

                <select id="perusahaan" name="perusahaan" class="form-select" onchange="get_department();">

                  <option selected="selected" disabled="disabled">-- Pilih --</option>

                  <?php foreach ($perusahaan_all as $key => $value) : ?>

                    <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>

                  <?php endforeach ?>

                </select>

                <span class="help-block"></span>

              </div>

            </div>

            <div class="form-group department row mb-3">

              <label class="col-sm-2 col-form-label">Department</label>

              <div class="col-sm-10">

                <select id="department" name="department" class="form-select" required="required">



                </select>

                <span class="help-block"></span>

              </div>

            </div>

            <!-- <div class="form-group row mb-3">

                <label class="col-sm-2 col-form-label">Department</label>

                <div class="col-sm-10">

                  <input type="text" name="department" id="department" class="form-control" required="required">

                  <span class="help-block"></span>

                </div>

              </div> -->

            <div class="form-group row mb-3">

              <label class="col-sm-2 col-form-label">NIP</label>

              <div class="col-sm-10">

                <input type="text" name="nip" id="nip" class="form-control" required="required">

                <span class="help-block"></span>

              </div>

            </div>

            <div class="form-group row mb-3">

              <label class="col-sm-2 col-form-label">Karyawan</label>

              <div class="col-sm-10">

                <input type="text" name="nama" id="nama" class="form-control" required="required">

                <span class="help-block"></span>

              </div>

            </div>

            <div class="form-group row mb-3">

              <label class="col-sm-2 col-form-label">Email</label>

              <div class="col-sm-10">

                <input type="email" id="email" name="email" class="form-control" required="required" autocomplete="off">

                <span class="help-block"></span>

              </div>

            </div>

            <!-- <div class="form-group row mb-3">

                <label class="col-sm-2 col-form-label">Username</label>

                <div class="col-sm-10">

                  <input type="text" id="username" name="username" class="form-control" required="required" autocomplete="off">

                  <span class="help-block"></span>

                </div>

              </div> -->

            <div id="pass_div" class="form-group row mb-3">

              <label class="col-sm-2 col-form-label">Password</label>

              <div class="col-sm-10">

                <input type="password" id="password" name="password" minlength="5" class="form-control" required="required" autocomplete="off">

                <span class="help-block"></span>

              </div>

            </div>

            <div class="form-group row mb-3">

              <label class="col-sm-2 col-form-label">Aktivasi</label>

              <div class="col-sm-10">

                <select id="aktivasi" name="aktivasi" class="form-select">

                  <option selected="selected" disabled="disabled">-- Pilih --</option>

                  <option value="Aktif">Aktif</option>

                  <option value="Block">Block</option>

                </select>

                <span class="help-block"></span>

              </div>

            </div>

            <div class="form-group row mb-3">

              <label class="col-sm-2 col-form-label">Roles</label>

              <div class="col-sm-10">

                <select id="user_level" name="user_level" class="form-select">

                  <option selected="selected" disabled="disabled">-- Pilih --</option>

                  <?php foreach ($roles as $key => $value) : ?>

                    <option value="<?php echo $value->idroles; ?>"><?php echo $value->roles_name; ?></option>

                  <?php endforeach ?>

                </select>

                <span class="help-block"></span>

              </div>

            </div>

            <!-- <div class="form-group row">

                <label class="col-sm-2 col-form-label">Perusahaan</label>

                <div class="col-sm-10">

                  <select id="perusahaan" name="perusahaan" class="form-select">

                    <option selected="selected" disabled="disabled">-- Pilih --</option>

                    <?php foreach ($perusahaan_all as $key => $value) : ?>

                      <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>

                    <?php endforeach ?>

                  </select>

                  <span class="help-block"></span>

                </div>

              </div> -->

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



    function reset_password(nip) {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Mengubah password menjadi default!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, hapus',
        cancelButtonText: 'Tidak, Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Jika pengguna menekan "Yes, hapus", lakukan panggilan AJAX
          console.log(nip);
          $.ajax({
            url: '<?php echo base_url(); ?>users/reset_password',
            method: 'POST',
            data: {
              nip: nip
            },
            success: function(response) {
              // Handle the response from the server
              const result = JSON.parse(response);
              Swal.fire({
                title: 'Sukses!',
                text: result.message, // Menampilkan pesan dari respons
                icon: 'success'
              });
            }
          });
        }
      });
    }

    //FUNCTION OPEN MODAL CABANG

    function openModal() {

      save_method = 'add';

      $("#pass_div").show();

      $('#btnSave').text('Save');

      $('#registerForm')[0].reset();
      // $('#department').empty();
      var html = '<option selected="selected" disabled="disabled">-- Pilih --</option>';
      $('#department').html(html);

      // Clear error state of the department select
      // $('.form-group.department').removeClass('has-error');
      // $('.form-group.department .help-block').empty();

      $('.form-group').find(".has-error").removeClass("has-error");

      $('.help-block').empty();

      $('#modalForm').modal('show');

      $('.modal-title').text('Tambah User');

    };



    //FUNCTION CLOSE MODAL

    function closeModal() {

      $('#registerForm')[0].reset();

      $('#modalForm').modal('hide');

      $('.modal-title').text('Tambah User');

    };



    //FUNCTION RESET

    function reset() {

      $('#registerForm')[0].reset();

      $('.modal-title').text('Tambah User');

    };



    //FUNCTION RELOAD TABLE

    function reload_table() {

      table.ajax.reload(null, false);

    };



    //VALIDATION AND ADD USER

    function save()

    {

      $("#btnSave").html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

      $("#btnSave").attr('disabled', true);

      var url;



      if (save_method == 'add') {

        $("#pass_div").show();

        url = "<?php echo base_url(); ?>users/users_add";

      } else {

        $("#pass_div").hide();

        url = "<?php echo base_url(); ?>users/users_update";

      }



      var data_save = $('#registerForm').serializeArray();

      $.ajax({

        url: url,

        type: "POST",

        data: data_save,

        dataType: "JSON",

        success: function(data)

        {

          if (data.status == 'ok')

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

              $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');

              $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);

            }

          }

          $('#btnSave').text('Save');

          $('#btnSave').attr('disabled', false);

        },

        error: function(jqXHR, textStatus, errorThrown)

        {

          alert('Error adding / update data');

          $('#btnSave').text('Save');

          $('#btnSave').attr('disabled', false);

        }

      });



    };



    //FUNCTION EDIT

    // function edit(id) {

    //   save_method = 'update';

    //   $('#registerForm')[0].reset();

    //   $('.form-group').removeClass('has-error');

    //   $(".form-group>div").removeClass("has-error");

    //   $('.help-block').empty();



    //   $("#pass_div").hide();

    //   //Ajax Load data from ajax

    //   $.ajax({

    //     url: "<?php echo base_url(); ?>users/users_edit/" + id,

    //     type: "GET",

    //     dataType: "JSON",

    //     success: function(data)

    //     {

    //       if (data.status == 'forbidden') {

    //         Swal.fire(

    //           'FORBIDDEN',

    //           'Access Denied',

    //           'info',

    //         )

    //       } else {

    //         $('[name="kode"]').val(data.id);



    //         $('[name="nip"]').val(data.nip);

    //         $('[name="nama"]').val(data.nama_pegawai);

    //         $('[name="email"]').val(data.email_pegawai);

    //         //$('[name="username"]').val(data.username);

    //         $('[name="aktivasi"]').val(data.aktivasi);

    //         $('[name="user_level"]').val(data.user_level);

    //         $('[name="perusahaan"]').val(data.perusahaan);
    //         $('#department').empty();
    //         get_department(data.perusahaan, data.dept_id);

    //         // console.log(data.dept_id);
    //         // $("#department :selected").val(data.dept_id);
    //         // $('[name="department"]').val(data.dept_id);
    //         $('#modalForm').modal('show');

    //         $('.modal-title').text('Edit User');

    //         $('#btnSave').text('Update');

    //       }



    //     },

    //     error: function(jqXHR, textStatus, errorThrown)

    //     {

    //       alert('Error get data from ajax');

    //     }

    //   });

    // }
    // FUNCTION EDIT
    function edit(id) {
      save_method = 'update';
      $('#registerForm')[0].reset();
      $('.form-group').removeClass('has-error');
      $(".form-group>div").removeClass("has-error");
      $('.help-block').empty();
      $("#pass_div").hide();

      // Ajax Load data from ajax
      $.ajax({
        url: "<?php echo base_url(); ?>users/users_edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 'forbidden') {
            Swal.fire(
              'FORBIDDEN',
              'Access Denied',
              'info'
            );
          } else {
            $('[name="kode"]').val(data.id);
            $('[name="nip"]').val(data.nip);
            $('[name="nama"]').val(data.nama_pegawai);
            $('[name="email"]').val(data.email_pegawai);
            $('[name="aktivasi"]').val(data.aktivasi);
            $('[name="user_level"]').val(data.user_level);
            $('[name="perusahaan"]').val(data.perusahaan);

            // Clear error state of the department select
            $('.form-group.department').removeClass('has-error');
            $('.form-group.department .help-block').empty();

            // Load and set department options
            get_department(data.perusahaan, data.dept_id);

            $('#modalForm').modal('show');
            $('.modal-title').text('Edit User');
            $('#btnSave').text('Update');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error getting data from ajax');
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
          var html = '<option disabled>-- Pilih --</option>';
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

            url: '<?php echo base_url(); ?>users/users_deleted/' + id,

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

        "processing": true, //Feature control the processing indicator.

        "serverSide": true, //Feature control DataTables' server-side processing mode.

        "order": [], //Initial no order.



        // Load data for the table's content from an Ajax source

        "ajax": {

          "url": "<?php echo base_url(); ?>users/users_list",

          "type": "POST",

        },



        "aoColumns": [

          {
            "No": "No",
            "sClass": "text-right"
          },

          {
            "#": "#",
            "sClass": "text-center"
          },

          {
            "DEPT": "DEPT",
            "sClass": "text-left"
          },

          {
            "NIP": "NIP",
            "sClass": "text-left"
          },

          {
            "Nama": "Nama",
            "sClass": "text-left"
          },

          {
            "Email": "Email",
            "sClass": "text-left"
          },

          // { "Username": "Username" , "sClass": "text-left" },

          {
            "Perusahaan": "Perusahaan",
            "sClass": "text-left"
          },

          {
            "Roles": "Roles",
            "sClass": "text-left"
          },

          {
            "Aktivasi": "Aktivasi",
            "sClass": "text-center"
          },

          {
            "Last login": "Last login",
            "sClass": "text-left"
          }

        ],



        //Set column definition initialisation properties.

        "columnDefs": [

          {

            "targets": [0], //last column

            "orderable": false, //set not orderable

            className: 'text-right'

          },

        ]

      });



      $("#department").change(function() {

        $(this).parent().removeClass('has-error');

        $(this).next().empty();

      });



      $("#nip").change(function() {

        $(this).parent().removeClass('has-error');

        $(this).next().empty();

      });



      $("#nama").change(function() {

        $(this).parent().removeClass('has-error');

        $(this).next().empty();

      });



      $("#email").change(function() {

        $(this).parent().removeClass('has-error');

        $(this).next().empty();

      });



      // $("#username").change(function(){

      //   $(this).parent().removeClass('has-error');

      //   $(this).next().empty();

      // });



      $("#password").change(function() {

        $(this).parent().removeClass('has-error');

        $(this).next().empty();

      });



      $("#aktivasi").change(function() {

        $(this).parent().removeClass('has-error');

        $(this).next().empty();

      });



      $("#user_level").change(function() {

        $(this).parent().removeClass('has-error');

        $(this).next().empty();

      });



     

    });
  </script>

</body>

</html>