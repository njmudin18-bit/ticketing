<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class='sidebar-brand' href='<?php echo base_url(); ?>adminx'>
      <span class="sidebar-brand-text align-middle">
        <?php echo $perusahaan->nama; ?>
      </span>
      <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5"
        stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
        <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
        <path d="M20 12L12 16L4 12"></path>
        <path d="M20 16L12 20L4 16"></path>
      </svg>
    </a>

    <div class="sidebar-user">
      <div class="d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='<?php echo base_url(); ?>adminx'">
        <img src="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->logo_name; ?>" class="avatar-sidebar img-fluid rounded me-1" alt="<?php echo strtolower($this->session->userdata('user_realName')); ?>" />
      </div>
    </div>

    <ul class="sidebar-nav">
      <li class="sidebar-header">
        Menu
      </li>
      <?php
				$user_le 	= $this->session->userdata('user_level');
				$tk_c 		= $this->router->class;
				$tk_m 		= $this->router->method;
				$get_permissionsgroup_data =  $this->Dashboard_model->getroles_permissions($user_le);
				foreach ($get_permissionsgroup_data as $get_permissionsgroup) {
					$data_permissions = $this->Dashboard_model->getpermissions($get_permissionsgroup->idpermissions_group, $user_le);
					if ($data_permissions->num_rows() > 0) {
						if ($get_permissionsgroup->permissions_groupname == 'Dashboard') {
						  ?>
							<li class="sidebar-item
            	  <?php
                  $dtget_method = $this->Dashboard_model->getmethod_permission($get_permissionsgroup->idpermissions_group, $tk_m, $tk_c);
                  $get_method = '';
                  $get_class 	= '';
                  $get_group 	= '';
                  if ($dtget_method != NULL) {
                    $get_method = $dtget_method->code_method;
                    $get_class 	= $dtget_method->code_class;
                    $get_group 	= $dtget_method->idpermissions_group;
                  }

                  if ($tk_c == $get_class && $tk_m == $get_method && $get_permissionsgroup->idpermissions_group == $get_group) {
                    echo "active";
                  } else {
                    echo "";
                  }

                  $icon 	    = $get_permissionsgroup->display_icon;
								?>">
                  <a class='sidebar-link' href='<?php echo base_url(); ?>adminx'>
                    <i class="align-middle" data-feather="<?php echo $icon; ?>"></i> 
                    <span class="align-middle"><?php echo $get_permissionsgroup->permissions_groupname; ?></span>
                  </a>
							</li>
					    <?php
						} else {
						  ?>
							  <li class="sidebar-item 
                  <?php
                    $dtget_method = $this->Dashboard_model->getmethod_permission($get_permissionsgroup->idpermissions_group, $tk_m, $tk_c);
                    $get_method = '';
                    $get_class 	= '';
                    $get_group 	= '';
                    if ($dtget_method != NULL) {
                      $get_method = $dtget_method->code_method;
                      $get_class 	= $dtget_method->code_class;
                      $get_group 	= $dtget_method->idpermissions_group;
                    }

                    if ($tk_c == $get_class && $tk_m == $get_method && $get_permissionsgroup->idpermissions_group == $get_group) {
                      echo 'active'; //ini udah fix
                    } else {
                      echo '';
                    }

                    $icon2 	      = $get_permissionsgroup->display_icon;
                    $id_target    = str_replace(' ', '_', strtolower($get_permissionsgroup->permissions_groupname));
                  ?>">
                  <a data-bs-target="#<?php echo $id_target; ?>" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="<?php echo $icon2; ?>"></i> 
                    <span class="align-middle"><?php echo $get_permissionsgroup->permissions_groupname; ?></span>
                  </a>
                  <ul id="<?php echo $id_target; ?>" class="sidebar-dropdown list-unstyled collapse 
                    <?php 
                      if ($tk_c == $get_class && $tk_m == $get_method  && $get_permissionsgroup->idpermissions_group == $get_group) {
                        echo "show"; //ini udah fix
                      } else {
                        echo "";
                      }
                    ?>" data-bs-parent="#sidebar">
                    <?php 
                      $get_permissions_data = $this->Dashboard_model->getpermissions($get_permissionsgroup->idpermissions_group, $user_le);
                      foreach ($get_permissions_data->result() as $get_permissions) {
                        ?>
                          <li class="sidebar-item 
                            <?php 
                              if ($tk_m == $get_permissions->code_method && $tk_c == $get_permissions->code_class && $get_permissionsgroup->idpermissions_group == $get_permissions->idpermissions_group) { 
                                echo 'active';
														  } 
                            ?> ">
                            <a class='sidebar-link' href='<?= base_url() . $get_permissions->code_class . '/' . $get_permissions->code_url; ?>'><?php echo $get_permissions->display_name; ?></a>
                          </li>
                        <?php
                      }
                    ?>
                  </ul>
							  </li>
					    <?php
						}
					}
				}
			?>
    </ul>
  </div>
</nav>