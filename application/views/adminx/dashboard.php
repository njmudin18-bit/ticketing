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

  <title>Dashboard | <?php echo $perusahaan->nama; ?></title>

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



          <div class="row mb-2 mb-xl-3">

            <div class="col-auto d-none d-sm-block">

              <h3><strong>Analytics</strong> Dashboard</h3>

            </div>

          </div>

          <div class="row">

            <div class="col-xl-6 col-xxl-5 d-flex">

              <div class="w-100">

                <div class="row">

                  <div class="col-sm-6">

                    <div class="card">

                      <div class="card-body">

                        <div class="row">

                          <div class="col mt-0">

                            <h5 class="card-title">Perangkat</h5>

                          </div>



                          <div class="col-auto">

                            <div class="stat text-primary">

                              <i class="align-middle" data-feather="hard-drive"></i>

                            </div>

                          </div>

                        </div>

                        <h1 id="jlh_perangkat" class="mt-1 mb-3">0</h1>

                        <div class="mb-0">

                          <span class="text-muted">Jumlah perangkat</span>

                        </div>

                      </div>

                    </div>

                    <div class="card">

                      <div class="card-body">

                        <div class="row">

                          <div class="col mt-0">

                            <h5 class="card-title">Users</h5>

                          </div>



                          <div class="col-auto">

                            <div class="stat text-primary">

                              <i class="align-middle" data-feather="users"></i>

                            </div>

                          </div>

                        </div>

                        <h1 id="jlh_user" class="mt-1 mb-3">0</h1>

                        <div class="mb-0">

                          <span class="text-muted">Jumlah pengguna</span>

                        </div>

                      </div>

                    </div>

                  </div>

                  <div class="col-sm-6">

                    <div class="card">

                      <div class="card-body">

                        <div class="row">

                          <div class="col mt-0">

                            <h5 class="card-title">Jenis perangkat</h5>

                          </div>



                          <div class="col-auto">

                            <div class="stat text-primary">

                              <i class="align-middle" data-feather="inbox"></i>

                            </div>

                          </div>

                        </div>

                        <h1 id="jlh_jenis_perangkat" class="mt-1 mb-3">0</h1>

                        <div class="mb-0">

                          <span class="text-muted">Jumlah jenis perangkat</span>

                        </div>

                      </div>

                    </div>

                    <div class="card">

                      <div class="card-body">

                        <div class="row">

                          <div class="col mt-0">

                            <h5 class="card-title">Perusahaan</h5>

                          </div>



                          <div class="col-auto">

                            <div class="stat text-primary">

                              <i class="align-middle" data-feather="home"></i>

                            </div>

                          </div>

                        </div>

                        <h1 id="jlh_perusahaan" class="mt-1 mb-3">0</h1>

                        <div class="mb-0">

                          <span class="text-muted">Jumlah perusahaan</span>

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

                  <h5 class="card-title mb-0">Jumlah Perangkat By Perusahaan</h5>

                </div>

                <div class="card-body pt-3 pb-3">

                  <div class="chart chart-sm">

                    <canvas id="chartjs-perangkat-by-perusahaan"></canvas>

                  </div>

                </div>

              </div>

            </div>

          </div>



          <div class="row">

            <div class="col-12 col-md-5 col-xxl-3 d-flex order-1 order-xxl-3">

              <div class="card flex-fill w-100">

                <div class="card-header">

                  <div class="card-actions float-end"></div>

                  <h5 class="card-title mb-0">Jumlah Perangkat Berdasarkan Jenis</h5>

                </div>

                <div class="card-body d-flex">

                  <div class="align-self-center w-100">

                    <div class="py-3">

                      <div class="chart chart-xs">

                        <canvas id="chartjs-dashboard-pie"></canvas>

                      </div>

                    </div>



                    <table class="table table-striped mb-0">

                      <tbody id="isi_tbl_perangkat">

                      </tbody>

                    </table>

                  </div>

                </div>

              </div>

            </div>

            <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">

              <div class="card flex-fill w-100">

                <div class="card-header">

                  <div class="card-actions float-end">

                    <div class="dropdown position-relative">

                      <a href="#" data-bs-toggle="dropdown" data-bs-display="static">

                        <i class="align-middle" data-feather="more-horizontal"></i>

                      </a>



                      <div class="dropdown-menu dropdown-menu-end">

                        <a class="dropdown-item" href="#">Action</a>

                        <a class="dropdown-item" href="#">Another action</a>

                        <a class="dropdown-item" href="#">Something else here</a>

                      </div>

                    </div>

                  </div>

                  <h5 class="card-title mb-0">Real-Time</h5>

                </div>

                <div class="card-body px-4">

                  <div id="world_map" style="height:350px;"></div>

                </div>

              </div>

            </div>

            <div class="col-12 col-md-7 col-xxl-3 d-flex order-2 order-xxl-1">

              <div class="card flex-fill">

                <div class="card-header">

                  <h5 class="card-title mb-0">Kalendar Jadwal Perawatan</h5>

                </div>

                <div class="card-body d-flex">

                  <div class="align-self-center w-100">

                    <div class="chart">

                      <!-- <div id="datetimepicker-dashboard"></div> -->

                      <div id="fullcalendar"></div>

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>



          <!-- <div class="row">

              <div class="col-12 col-lg-8 col-xxl-9 d-flex">

                <div class="card flex-fill">

                  <div class="card-header">

                    <div class="card-actions float-end">

                      <div class="dropdown position-relative">

                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static">

                          <i class="align-middle" data-feather="more-horizontal"></i>

                        </a>



                        <div class="dropdown-menu dropdown-menu-end">

                          <a class="dropdown-item" href="#">Action</a>

                          <a class="dropdown-item" href="#">Another action</a>

                          <a class="dropdown-item" href="#">Something else here</a>

                        </div>

                      </div>

                    </div>

                    <h5 class="card-title mb-0">Latest Projects</h5>

                  </div>

                  <table class="table table-borderless my-0">

                    <thead>

                      <tr>

                        <th>Name</th>

                        <th class="d-none d-xxl-table-cell">Company</th>

                        <th class="d-none d-xl-table-cell">Author</th>

                        <th>Status</th>

                        <th class="d-none d-xl-table-cell">Action</th>

                      </tr>

                    </thead>

                    <tbody>

                      <tr>

                        <td>

                          <div class="d-flex">

                            <div class="flex-shrink-0">

                              <div class="bg-light rounded-2">

                                <img class="p-2" src="<?php echo base_url(); ?>assets/img/icons/brand-1.svg">

                              </div>

                            </div>

                            <div class="flex-grow-1 ms-3">

                              <strong>Project Apollo</strong>

                              <div class="text-muted">

                                Web, UI/UX Design

                              </div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xxl-table-cell">

                          <strong>Lechters</strong>

                          <div class="text-muted">

                            Real Estate

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <strong>Vanessa Tucker</strong>

                          <div class="text-muted">

                            HTML, JS, React

                          </div>

                        </td>

                        <td>

                          <div class="d-flex flex-column w-100">

                            <span class="me-2 mb-1 text-muted">65%</span>

                            <div class="progress progress-sm bg-success-light w-100">

                              <div class="progress-bar bg-success" role="progressbar" style="width: 65%;"></div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <a href="#" class="btn btn-light">View</a>

                        </td>

                      </tr>

                      <tr>

                        <td>

                          <div class="d-flex">

                            <div class="flex-shrink-0">

                              <div class="bg-light rounded-2">

                                <img class="p-2" src="<?php echo base_url(); ?>assets/img/icons/brand-2.svg">

                              </div>

                            </div>

                            <div class="flex-grow-1 ms-3">

                              <strong>Project Bongo</strong>

                              <div class="text-muted">

                                Web

                              </div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xxl-table-cell">

                          <strong>Cellophane Transportation</strong>

                          <div class="text-muted">

                            Transportation

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <strong>William Harris</strong>

                          <div class="text-muted">

                            HTML, JS, Vue

                          </div>

                        </td>

                        <td>

                          <div class="d-flex flex-column w-100">

                            <span class="me-2 mb-1 text-muted">33%</span>

                            <div class="progress progress-sm bg-danger-light w-100">

                              <div class="progress-bar bg-danger" role="progressbar" style="width: 33%;"></div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <a href="#" class="btn btn-light">View</a>

                        </td>

                      </tr>

                      <tr>

                        <td>

                          <div class="d-flex">

                            <div class="flex-shrink-0">

                              <div class="bg-light rounded-2">

                                <img class="p-2" src="<?php echo base_url(); ?>assets/img/icons/brand-3.svg">

                              </div>

                            </div>

                            <div class="flex-grow-1 ms-3">

                              <strong>Project Canary</strong>

                              <div class="text-muted">

                                Web, UI/UX Design

                              </div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xxl-table-cell">

                          <strong>Clemens</strong>

                          <div class="text-muted">

                            Insurance

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <strong>Sharon Lessman</strong>

                          <div class="text-muted">

                            HTML, JS, Laravel

                          </div>

                        </td>

                        <td>

                          <div class="d-flex flex-column w-100">

                            <span class="me-2 mb-1 text-muted">50%</span>

                            <div class="progress progress-sm bg-warning-light w-100">

                              <div class="progress-bar bg-warning" role="progressbar" style="width: 50%;"></div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <a href="#" class="btn btn-light">View</a>

                        </td>

                      </tr>

                      <tr>

                        <td>

                          <div class="d-flex">

                            <div class="flex-shrink-0">

                              <div class="bg-light rounded-2">

                                <img class="p-2" src="<?php echo base_url(); ?>assets/img/icons/brand-4.svg">

                              </div>

                            </div>

                            <div class="flex-grow-1 ms-3">

                              <strong>Project Edison</strong>

                              <div class="text-muted">

                                UI/UX Design

                              </div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xxl-table-cell">

                          <strong>Affinity Investment Group</strong>

                          <div class="text-muted">

                            Finance

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <strong>Vanessa Tucker</strong>

                          <div class="text-muted">

                            HTML, JS, React

                          </div>

                        </td>

                        <td>

                          <div class="d-flex flex-column w-100">

                            <span class="me-2 mb-1 text-muted">80%</span>

                            <div class="progress progress-sm bg-success-light w-100">

                              <div class="progress-bar bg-success" role="progressbar" style="width: 80%;"></div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <a href="#" class="btn btn-light">View</a>

                        </td>

                      </tr>

                      <tr>

                        <td>

                          <div class="d-flex">

                            <div class="flex-shrink-0">

                              <div class="bg-light rounded-2">

                                <img class="p-2" src="<?php echo base_url(); ?>assets/img/icons/brand-5.svg">

                              </div>

                            </div>

                            <div class="flex-grow-1 ms-3">

                              <strong>Project Indigo</strong>

                              <div class="text-muted">

                                Web, UI/UX Design

                              </div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xxl-table-cell">

                          <strong>Konsili</strong>

                          <div class="text-muted">

                            Retail

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <strong>Christina Mason</strong>

                          <div class="text-muted">

                            HTML, JS, Vue

                          </div>

                        </td>

                        <td>

                          <div class="d-flex flex-column w-100">

                            <span class="me-2 mb-1 text-muted">78%</span>

                            <div class="progress progress-sm bg-primary-light w-100">

                              <div class="progress-bar bg-primary" role="progressbar" style="width: 78%;"></div>

                            </div>

                          </div>

                        </td>

                        <td class="d-none d-xl-table-cell">

                          <a href="#" class="btn btn-light">View</a>

                        </td>

                      </tr>

                    </tbody>

                  </table>

                </div>

              </div>

              <div class="col-12 col-lg-4 col-xxl-3 d-flex">

                <div class="card flex-fill w-100">

                  <div class="card-header">

                    <div class="card-actions float-end">

                      <div class="dropdown position-relative">

                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static">

                          <i class="align-middle" data-feather="more-horizontal"></i>

                        </a>



                        <div class="dropdown-menu dropdown-menu-end">

                          <a class="dropdown-item" href="#">Action</a>

                          <a class="dropdown-item" href="#">Another action</a>

                          <a class="dropdown-item" href="#">Something else here</a>

                        </div>

                      </div>

                    </div>

                    <h5 class="card-title mb-0">Monthly Sales</h5>

                  </div>

                  <div class="card-body d-flex w-100">

                    <div class="align-self-center chart chart-lg">

                      <canvas id="chartjs-dashboard-bar"></canvas>

                    </div>

                  </div>

                </div>

              </div>

            </div> -->



        </div>

      </main>



      <?php $this->load->view('adminx/components/footer'); ?>

    </div>

  </div>



  <div id="loading-screen" class="loading">Loading</div>



  <script src="<?php echo base_url(); ?>assets/js/app.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/fullcalendar.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function(event) {

      $.ajax({

        type: 'POST',

        url: '<?php echo base_url(); ?>adminx/show_count_data',

        beforeSend: function() {

          $("#loading-screen").show();

        },

        success: function(response) {

          let res = JSON.parse(response);

          console.log(res);

          $("#jlh_perangkat").html(res.jumlah_perangkat);

          $("#jlh_jenis_perangkat").html(res.jumlah_jenis_perangkat);

          $("#jlh_user").html(res.jumlah_user);

          $("#jlh_perusahaan").html(res.jumlah_perusahaan);

          $("#loading-screen").hide();

        },

        error: function() {

          alert('Oops something went wrong');

        },

      });

    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      $("#loading-screen").hide();

      // Pie chart

      $.ajax({

        type: 'POST',

        url: '<?php echo base_url(); ?>adminx/show_jadwal_perawatan',

        beforeSend: function() {

          $("#loading-screen").show();

        },

        success: function(response) {

          let res = JSON.parse(response);

          var calendarEl = document.getElementById("fullcalendar");

          var calendar = new FullCalendar.Calendar(calendarEl, {

            themeSystem: "bootstrap",

            initialView: "dayGridMonth",

            //initialDate: "2021-07-07",

            headerToolbar: {

              left: "prev,next today",

              center: "title",

              //right: "dayGridMonth"

              right: "dayGridMonth,timeGridWeek,timeGridDay"

            },

            events: res.data,

            eventClick: function(info) {

              alert('Event: ' + info.event.title);

            }

          });

          setTimeout(function() {

            calendar.render();

          }, 250)



          $("#loading-screen").hide();

        },

        error: function() {

          alert('Oops something went wrong');

        },

      });

    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      $("#loading-screen").hide();

      // Pie chart

      $.ajax({

        type: 'POST',

        url: '<?php echo base_url(); ?>adminx/show_jumlah_perangkat_by_perusahaan',

        beforeSend: function() {

          $("#loading-screen").show();

        },

        success: function(response) {

          let res = JSON.parse(response);

          let nama_perusahaan = [];

          let jumlah_perangkat = [];

          res.data.forEach(function(data) {

            nama_perusahaan.push(data.NAMA_PERUSAHAAN);

            jumlah_perangkat.push(data.JLH_PERANGKAT);

          });



          new Chart(document.getElementById("chartjs-perangkat-by-perusahaan"), {

            type: "pie",

            data: {

              labels: nama_perusahaan,

              datasets: [{

                data: jumlah_perangkat,

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

    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      $("#loading-screen").hide();

      // Pie chart

      $.ajax({

        type: 'POST',

        url: '<?php echo base_url(); ?>adminx/show_jumlah_perangkat_by_jenis',

        beforeSend: function() {

          $("#loading-screen").show();

        },

        success: function(response) {

          let res = JSON.parse(response);

          let jenis_perangkat = [];

          let jumlah_perangkat = [];

          res.data_perangkat.forEach(function(data) {

            jenis_perangkat.push(data.JENIS_PERANGKAT);

            jumlah_perangkat.push(data.JLH_PERANGKAT);

          });



          new Chart(document.getElementById("chartjs-dashboard-pie"), {

            type: "pie",

            data: {

              labels: jenis_perangkat,

              datasets: [{

                data: jumlah_perangkat,

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



          $("#isi_tbl_perangkat").html(res.tbl_perangkat);

          $("#loading-screen").hide();

        },

        error: function() {

          alert('Oops something went wrong');

        },

      });

    });
  </script>

  <!-- <script>

      document.addEventListener("DOMContentLoaded", function() {

        // Bar chart

        new Chart(document.getElementById("chartjs-dashboard-bar"), {

          type: "bar",

          data: {

            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],

            datasets: [{

              label: "This year",

              backgroundColor: window.theme.primary,

              borderColor: window.theme.primary,

              hoverBackgroundColor: window.theme.primary,

              hoverBorderColor: window.theme.primary,

              data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],

              barPercentage: .75,

              categoryPercentage: .5

            }]

          },

          options: {

            maintainAspectRatio: false,

            legend: {

              display: false

            },

            scales: {

              yAxes: [{

                gridLines: {

                  display: false

                },

                stacked: false,

                ticks: {

                  stepSize: 20

                }

              }],

              xAxes: [{

                stacked: false,

                gridLines: {

                  color: "transparent"

                }

              }]

            }

          }

        });

      });

    </script> -->

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      var markers = [{

          coords: [31.230391, 121.473701],

          name: "Shanghai"

        },

        {

          coords: [28.704060, 77.102493],

          name: "Delhi"

        },

        {

          coords: [6.524379, 3.379206],

          name: "Lagos"

        },

        {

          coords: [35.689487, 139.691711],

          name: "Tokyo"

        },

        {

          coords: [23.129110, 113.264381],

          name: "Guangzhou"

        },

        {

          coords: [40.7127837, -74.0059413],

          name: "New York"

        },

        {

          coords: [34.052235, -118.243683],

          name: "Los Angeles"

        },

        {

          coords: [41.878113, -87.629799],

          name: "Chicago"

        },

        {

          coords: [51.507351, -0.127758],

          name: "London"

        },

        {

          coords: [40.416775, -3.703790],

          name: "Madrid "

        }

      ];

      var map = new jsVectorMap({

        map: "world",

        selector: "#world_map",

        zoomButtons: true,

        markers: markers,

        markerStyle: {

          initial: {

            r: 9,

            stroke: window.theme.white,

            strokeWidth: 7,

            stokeOpacity: .4,

            fill: window.theme.primary

          },

          hover: {

            fill: window.theme.primary,

            stroke: window.theme.primary

          }

        },

        regionStyle: {

          initial: {

            fill: window.theme["gray-200"]

          }

        },

        zoomOnScroll: false

      });

      window.addEventListener("resize", () => {

        map.updateSize();

      });

      setTimeout(function() {

        map.updateSize();

      }, 250);

    });
  </script>

  <script>
    // document.addEventListener("DOMContentLoaded", function() {

    //   var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);

    //   var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();

    //   console.log(date);

    //   console.log(defaultDate);

    //   document.getElementById("datetimepicker-dashboard").flatpickr({

    //     inline: true,

    //     prevArrow: "<span class=\"fas fa-chevron-left\" title=\"Previous month\"></span>",

    //     nextArrow: "<span class=\"fas fa-chevron-right\" title=\"Next month\"></span>",

    //     defaultDate: defaultDate

    //   });

    // });
  </script>

  <script>
    
  </script>

</body>

</html>