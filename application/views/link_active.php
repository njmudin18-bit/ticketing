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
             <!--                           <form>-->
             <!--                               <div class="mb-3">-->
             <!--                                   <label class="form-label">Email</label>-->
             <!--                                   <input class="form-control form-control-lg" value="<?php echo $emails; ?>" type="email" name="email" placeholder="Enter your email" />-->
             <!--                               </div>-->
             <!--                               <div class="text-center mt-3">-->
             <!--                                   <button id="button_login" type="button" onclick="auto_login();" class="btn btn-lg btn-primary">Sign in</button> -->
             <!--                               </div>-->
    									<!--</form>-->
    									<form>
                                            <div class="text-center mt-3">
                                                <label class="form-label text-center">Please wait a few moments you will be directed to the dashboard page.</label>
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="#" class="btn btn-lg btn-primary">Sign in</a>
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
        <script>
            // function auto_login() {
            //     $.ajax({
            //         type: 'POST',
            //         url: '<?php echo base_url(); ?>welcome/login_with_email_and_token',
            //         data: {
            //             email: '<?php echo $emails; ?>',
            //             token: '<?php echo $tokens; ?>'
            //         },
            //         beforeSend: function () {
            //             $("#error").fadeOut();
            //             $("#button_login").prop('disabled', true);
            //             $("#button_login").html('Sign in...');
            //         },
            //         success: function (response) {
            //             const res = JSON.parse(response);
            //             if (res.status_code == 400 || res.status_code == 404 || res.status_code == 401) {
            //                 Swal.fire({
            //                     icon: 'info',
            //                     title: 'Oops...',
            //                     text: res.message
            //                 });
            //                 $("#button_login").html('Sign in');
            //             } else {
            //                 $("#button_login").html('Masuk aplikasi...');
            //                 setTimeout('window.location.href = "' + res.url + '"', 500);
            //             }
            //             $("#button_login").prop('disabled', false);
            //         },
            //         error: function(error) {
            //             alert('error when auto sign in');
            //         }
            //     });
            // };
                
            $(document).ready(function() {
                //FUNGSI CALL DATA
                function auto_login() {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>welcome/login_with_email_and_token',
                        data: {
                            email: '<?php echo $emails; ?>',
                            token: '<?php echo $tokens; ?>'
                        },
                        beforeSend: function () {
                            $("#error").fadeOut();
                            $("#button_login").prop('disabled', true);
                            $("#button_login").html('Sign in...');
                        },
                        success: function (response) {
                            const res = JSON.parse(response);
                            if (res.status_code == 404 || res.status_code == 500) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Oops...',
                                    text: res.message
                                });
                                $("#button_login").html('Sign in');
                            } else {
                                $("#button_login").html('Masuk aplikasi...');
                                setTimeout('window.location.href = "' + res.url + '"', 500);
                            }
                            $("#button_login").prop('disabled', false);
                        }
                    });
                };
                
                setTimeout(function() {
                    auto_login()
                }, 1000);
    	    });
	    </script>
    </body>
</html>