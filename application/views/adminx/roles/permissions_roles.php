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
                      <?php echo $nama_halaman; ?><span class="text-danger"><?php echo $roles_detail->roles_name; ?></span>
                    </h5>
                  </div>
                  <div class="card-body">
                    <form action="<?php echo base_url() ?>rolespermissions/insert_roles_permissions" method="post" accept-charset="utf-8">
                      <div class="dt-responsive table-responsive">
                        <table class="table table-striped table-bordered nowrap">
                          <thead>
                            <tr class="bg-primary">
                              <th class="text-center text-white">No</th>
                              <th class="text-center text-white">Permission Group</th>
                              <th class="text-center text-white">Permissions</th>
                            </tr>
                            <input type="hidden" name="idroles_edit" value="<?php echo $idroles_edit; ?>">
                          </thead>
                          <tbody>
                            <?php
                            $start = 0;
                            foreach ($getpermissions_group_data as $getpermissions_group) {
                            ?>
                              <tr>
                                <td class="text-right"><?php echo ++$start; ?></td>
                                <td>
                                  <i class="<?= $getpermissions_group->display_icon; ?>"></i>
                                  &nbsp;<?= $getpermissions_group->permissions_groupname; ?>
                                </td>
                                <td>
                                  <?php
                                    $list_permissions =  $this->Rolespermissions_model->get_permissions($getpermissions_group->idpermissions_group, $idroles_edit);
                                  ?>
                                  <?php
                                    foreach ($list_permissions as $permissions) {
                                      $checkedlist_permission =  $this->Rolespermissions_model->get_checkedlist_permissions($permissions->idpermissions, $idroles_edit);
                                  ?>
                                      <div class="row m-b-20 align-items-center">
                                        <div class="col-md-9">
                                          <div class="form-check form-check-inline mb-3">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input" name="permissions[]" value="<?= $permissions->idpermissions; ?>" <?php if ($checkedlist_permission->num_rows() > 0) {
                                                                                                                                                                echo "checked";
                                                                                                                                                              } ?>>
                                              <i class="<?= $permissions->display_icon; ?>"></i>
                                              &nbsp;<span class="text-info"><?= $permissions->display_name; ?></span>
                                            </label>
                                          </div>

                                          <input type="hidden" name="permissions_group[]" value="<?= $permissions->idpermissions_group; ?>" />
                                        </div>
                                        <div class="col-md-3">
                                          <?php
                                            switch ($permissions->type) {
                                              case 'TRUE':
                                                echo '<button class="btn btn-primary btn-sm" style="width:100%;" type="button">SIDEBAR</button>';
                                                break;

                                              case 'NAV':
                                                echo '<button class="btn btn-warning btn-sm" style="width:100%;" type="button">NAVBAR</button>';
                                                break;

                                              default:
                                                echo '<button class="btn btn-danger btn-sm" style="width:100%;" type="button">FUNCTION</button>';
                                                break;
                                            }
                                          ?>
                                        </div>
                                      </div>
                                  <?php
                                    }
                                  ?>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                      <br />
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                          SUBMIT
                        </button>
                      </div>
                      <br />
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </main>

        <?php $this->load->view('adminx/components/footer'); ?>
      </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>