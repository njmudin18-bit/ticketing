<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?php echo $perusahaan->nama; ?>">
        <meta name="author" content="IT Department - <?php echo $perusahaan->nama; ?>">
        <meta name="keywords" content="<?php echo $perusahaan->nama; ?>">
        <meta http-equiv="refresh" content="30">
        <link rel="preconnect" href="https://fonts.gstatic.com/">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->icon_name; ?>" />
        <link rel="canonical" href="<?php echo base_url(); ?>" />
        <title><?php echo $titles; ?> | Ticketing Apps</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
        <link class="js-stylesheet" href="<?php echo base_url(); ?>assets/css/light.css" rel="stylesheet">
        <link class="js-stylesheet" href="<?php echo base_url(); ?>assets/css/customs.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <style>
          body {
            opacity: 0;
            background-image: url('https://e1.pxfuel.com/desktop-wallpaper/14/319/desktop-wallpaper-big-sur-abstract-backgrounds-and-mac-os-big-sur.jpg');
            background-size: cover;
            background-attachment: fixed;
          }
    
          .center-everything {
            justify-content: center;
          }
        </style>
        <!-- END SETTINGS -->
    </head>
    <body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
        <main class="d-flex w-100 h-100">
		    <div class="container d-flex flex-column">
                <div class="row vh-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                        <div class="d-table-cell align-middle">
                            <div class="text-center mt-4">
                                <h1 class="h2"><?php echo strtoupper($titles); ?></h1>
                                <p class="lead" style="color:#fff;"><?php echo $message; ?></p>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <form>
                                            <div class="text-center mt-3">
                                                <label class="form-label text-center">Click the button bellow for access login page.</label>
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="<?php echo base_url(); ?>" class="btn btn-lg btn-primary">Sign in</a>
                                                <!-- <button type="submit" class="btn btn-lg btn-primary">Reset password</button> -->
                                            </div>
                                        </form>
								    </div>
							    </div>
						    </div>
					    </div>
				    </div>
			    </div>
		    </div>
	    </main>
	    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
			$(function () {
				$.validator.setDefaults({
					submitHandler: loginAction
				});
				$('#login_form').validate({
					rules: {
						email: {
							required: true,
                            email: true,
							minlength: 4,
						}
					},
					errorElement: 'span',
					errorPlacement: function (error, element) {
						error.addClass('invalid-feedback');
						element.closest('.form-group').append(error);
					},
					highlight: function (element, errorClass, validClass) {
						$(element).addClass('is-invalid');
					},
					unhighlight: function (element, errorClass, validClass) {
						$(element).removeClass('is-invalid');
					}
				});
                
				function loginAction() {
					var data = $("#login_form").serialize();
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>welcome/login_proses',
						data: data,
						beforeSend: function () {
							$("#error").fadeOut();
							$("#button_login").prop('disabled', true);
							$("#button_login").html('Login...');
						},
						success: function (response) {
							const res = JSON.parse(response);
							if (res.status_code == 400 || res.status_code == 404 || res.status_code == 401) {
								Swal.fire({
									icon: 'info',
									title: 'Oops...',
									text: res.message
								});
								$("#button_login").html('Log In');
							} else {
								$("#button_login").html('Masuk aplikasi...');
								setTimeout('window.location.href = "' + res.url + '"', 500);
							}
							$("#button_login").prop('disabled', false);
							grecaptcha.reset();
						}
					});
					return false;
				}
                
				var width = $('.g-recaptcha').parent().width();
				if (width < 302) {
					var scale = width / 302;
					$('.g-recaptcha').css('transform', 'scale(' + scale + ')');
					$('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
					$('.g-recaptcha').css('transform-origin', '0 0');
					$('.g-recaptcha').css('-webkit-transform-origin', '0 0');
				}
			});
            
            document.addEventListener("DOMContentLoaded", function(event) {
            
            });
		</script>
    </body>
</html>