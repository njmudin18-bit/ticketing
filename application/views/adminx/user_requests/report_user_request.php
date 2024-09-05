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
  <title>Report User Request | <?php echo $perusahaan->nama; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
  <!-- BEGIN SETTINGS -->
  <!-- Remove this after purchasing -->
  <link class="js-stylesheet" href="<?php echo base_url(); ?>assets/css/light.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/customs.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
  <style>
    body {
      opacity: 0;
    }

    @media (max-width: 767px) {

      /* Stil untuk layar kecil (sm) */
      .mt-sm {
        margin-top: 10px;
      }
    }

    @media (min-width: 768px) {

      /* Stil untuk layar sedang (md) atau lebih besar */
      .mt-md {
        margin-top: 0;
      }
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
          <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
              <h3><strong>Report</strong> User Request</h3>
            </div>
            <div class="mb-2 mt-2">
              <hr>
              <div class="form-group row">
                <label class="col-md-2 col-sm-12 col-form-label m-t-30">Filter data by</label>
                <div class="col-md-4 col-sm-12 m-t-30">
                  <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span>
                  </div>
                  <input type="hidden" name="start_date" id="start_date">
                  <input type="hidden" name="end_date" id="end_date">
                </div>
                <!-- <div class="col-md-2 col-sm-12 m-t-30">
                                    <select class="form-control" name="pilih_pr_mpr" id="pilih_pr_mpr" required="required">
                                      <option disabled="disabled">-- Pilih --</option>
                                      <option value="All" selected="selected">All</option>
                                      <option value="WH-A">WH-A</option>
                                      <option value="WH-B">WH-B</option>
                                    </select>
                                </div> -->
                <div class="col-md-3 col-sm-12 mt-sm mt-md">
                  <button id="btnCari" type="button" class="btn btn-info btn-full-mobile" onclick="cari();">TAMPILKAN</button>
                </div>
              </div>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-6 col-xxl-5 d-flex">
              <div class="w-100">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col mt-0">
                            <h5 class="card-title">Software</h5>
                          </div>
                          <div class="col-auto">
                            <div class="stat text-primary">
                              <i class="align-middle" data-feather="hard-drive"></i>
                            </div>
                          </div>
                        </div>
                        <div class="container">
                          <div class="row">
                            <div class="col-6">
                              <div id="jlh_software" class="mt-1 mb-3">
                                0
                              </div>
                            </div>
                            <div class="col-6">
                              <div id="persen_software" class="mt-1 mb-3"> 0</div>
                            </div>
                          </div>
                        </div>
                        <div class="mb-0">
                          <span class="text-muted">Request Selesai Software</span>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col mt-0">
                            <h5 class="card-title">Hardware</h5>
                          </div>
                          <div class="col-auto">
                            <div class="stat text-primary">
                              <i class="align-middle" data-feather="users"></i>
                            </div>
                          </div>
                        </div>
                        <div class="container">
                          <div class="row">
                            <div class="col-6">
                              <div id="jlh_hardware" class="mt-1 mb-3">
                                0
                              </div>
                            </div>
                            <div class="col-6">
                              <div id="persen_hardware" class="mt-1 mb-3"> 0</div>
                            </div>
                          </div>
                        </div>

                        <div class="mb-0">
                          <span class="text-muted">Request Selesai Hardware</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-xxl-7">
              <div class="card flex-fill w-100">
                <div class="card-header">
                  <div class="float-end"></div>
                  <h5 class="card-title mb-0">Jumlah Request yang selesai By Perusahaan</h5>
                </div>
                <div class="card-body pt-3 pb-3">
                  <div class="chart chart-sm">
                    <canvas id="chartjs-perangkat-by-perusahaan"></canvas>
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
  <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>

  <script>
    //RANGE DATE PICKER
    $(function() {
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
    });

    $(document).ready(function() {
      cari()
    });

    function cari() {
      reload();
      reload_pie();
    }

    function reload() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>report_user_request/show_count_data',
        data: {
          start_date: $('#start_date').val(),
          end_date: $('#end_date').val()
        },
        beforeSend: function() {
          $("#loading-screen").show();
        },
        success: function(response) {
          let res = JSON.parse(response);


          let persen_software = ((res.get_software_selesai / res.get_software_total) * 100);
          if (isNaN(persen_software)) {
            persen_software = 0;
          }

          let persen_hardware = ((res.get_hardware_selesai / res.get_hardware_total) * 100);
          if (isNaN(persen_hardware)) {
            persen_hardware = 0;
          }
          let software = res.get_software_selesai + " / " + res.get_software_total;
          let hardware = res.get_hardware_selesai + " / " + res.get_hardware_total;

          $("#jlh_software").html("<h1>" + software + "</h1>");
          $("#persen_software").html("<h1>" + persen_software.toFixed(1) + "%" + "</h1>");
          $("#jlh_hardware").html("<h1>" + hardware + "</h1>");
          $("#persen_hardware").html("<h1>" + persen_hardware.toFixed(1) + "%" + "</h1>");
          $("#loading-screen").hide();
        },
        error: function() {
          alert('Oops something went wrong');
        },
      });
    };

    function reload_pie() {
      $("#loading-screen").hide();

      // Hapus grafik yang ada sebelum membuat yang baru
      let chartElement = document.getElementById("chartjs-perangkat-by-perusahaan");
      if (window.myChart !== undefined && window.myChart !== null) {
        window.myChart.destroy();
      }

      // Pie chart
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>report_user_request/show_jumlah_perangkat_by_perusahaan',
        data: {
          start_date: $('#start_date').val(),
          end_date: $('#end_date').val()
        },
        beforeSend: function() {
          $("#loading-screen").show();
        },
        success: function(response) {
          let res = JSON.parse(response);
          let status_trans = [];
          let jumlah = [];
          res.data.forEach(function(data) {
            status_trans.push(data.status_trans);
            jumlah.push(data.jumlah);
          });

          window.myChart = new Chart(document.getElementById("chartjs-perangkat-by-perusahaan"), {
            type: "pie",
            data: {
              labels: status_trans,
              datasets: [{
                data: jumlah,
                backgroundColor: [
                  window.theme.primary,
                  window.theme.warning,
                  window.theme.danger,
                  "#E8EAED"
                ],
                borderWidth: 5,
                borderColor: window.theme.white
              }]
            },
            options: {
              responsive: !window.MSInputMethodContext,
              maintainAspectRatio: false,
              legend: {
                display: false
              },
              cutoutPercentage: 70
            }
          });
          $("#loading-screen").hide();
        },
        error: function() {
          alert('Oops something went wrong');
        },
      });
    }
  </script>
</body>

</html>