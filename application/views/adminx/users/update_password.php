<!DOCTYPE html><html lang="en">  <head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    <meta name="description" content="Ticketing Apps - <?php echo $perusahaan->nama; ?>">    <meta name="author" content="IT Department - <?php echo $perusahaan->nama; ?>">    <meta name="keywords" content="Ticketing Apps - <?php echo $perusahaan->nama; ?>">    <link rel="preconnect" href="https://fonts.gstatic.com/">    <link rel="shortcut icon" href="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->icon_name; ?>" />    <link rel="canonical" href="<?php echo base_url(); ?>" />    <title><?php echo $nama_halaman; ?> | <?php echo $perusahaan->nama; ?></title>    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">    <!-- BEGIN SETTINGS -->    <!-- Remove this after purchasing -->    <link class="js-stylesheet" href="<?php echo base_url(); ?>assets/css/light.css" rel="stylesheet">    <link href="<?php echo base_url(); ?>assets/css/customs.css" rel="stylesheet">    <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>    <style>      body {        opacity: 0;      }    </style>    <!-- END SETTINGS -->  </head>  <body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">    <div class="wrapper">            <?php $this->load->view('adminx/components/sidebar'); ?>      <div class="main">        <?php $this->load->view('adminx/components/navbar'); ?>        <main class="content">          <div class="container-fluid p-0">            <div class="row">              <div class="col-12">                <div class="card table">                  <div class="card-header">                    <h5 class="card-title text-center"><?php echo $nama_halaman; ?></h5>                  </div>                  <div class="card-body">                    <form action="" method="post" id="updateForm">                      <div class="form-group mb-1 row">                        <label class="col-form-label col-sm-4 text-sm-start">New Password</label>                        <div class="col-sm-8 input-grouping">                          <input autocomplete="off" id="new_password" name="new_password" type="password" class="form-control" placeholder="Your new password">                        </div>                      </div>                      <div class="form-group mb-1 row">                        <label class="col-form-label col-sm-4 text-sm-start">Confirm New Password</label>                        <div class="col-sm-8 input-grouping">                          <input autocomplete="off" id="confirm_new_password" name="confirm_new_password" type="password" class="form-control" placeholder="Confirm your new password">                        </div>                      </div>                      <div class="mb-3 row">                        <label class="col-form-label col-sm-4 text-sm-start"></label>                        <div class="col-sm-8">                        <button id="btn_update" type="submit" class="btn btn-primary">Ganti sekarang</button>                        </div>                      </div>                    </form>                  </div>                </div>              </div>            </div>          </div>        </main>        <?php $this->load->view('adminx/components/footer'); ?>      </div>    </div>    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>    <script src="<?php echo base_url(); ?>assets/js/customs.js"></script>    <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <script type="text/javascript">			$(function () {				$.validator.setDefaults({					submitHandler: loginAction				});				$('#updateForm').validate({					rules: {						new_password: {							required: true,							minlength: 5,						},						confirm_new_password: {							required: true,							minlength: 5,              equalTo : "#new_password"						}					},					errorElement: 'span',					errorPlacement: function (error, element) {						error.addClass('invalid-feedback');						element.closest('.input-grouping').append(error);					},					highlight: function (element, errorClass, validClass) {						$(element).addClass('is-invalid');					},					unhighlight: function (element, errorClass, validClass) {						$(element).removeClass('is-invalid');					}				});				function loginAction() {					var data = $("#updateForm").serialize();					$.ajax({						type: 'POST',						url: '<?php echo base_url(); ?>users/update_password_action',						data: data,						beforeSend: function () {							$("#error").fadeOut();							$("#btn_update").prop('disabled', true);							$("#btn_update").html('Updating...');						},						success: function (response) {							const res = JSON.parse(response);              Swal.fire({                icon: res.status,                title: capitalizeFirstLetter(res.status),                text: res.message              });              $('#updateForm')[0].reset();							$("#btn_update").html('Ganti sekarang');							$("#btn_update").prop('disabled', false);						}					});					return false;				}			});      document.addEventListener("DOMContentLoaded", function(event) {        $("#new_password").change(function(){          $(this).parent().removeClass('has-error');          $(this).next().empty();        });        $("#confirm_new_password").change(function(){          $(this).parent().removeClass('has-error');          $(this).next().empty();        });              });    </script>  </body></html>