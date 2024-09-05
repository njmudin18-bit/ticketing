<!DOCTYPE html>

<html>

<head>

  <meta charset='utf-8' />

  <title><?php echo $nama_halaman; ?> | <?php echo $perusahaan->nama; ?></title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

  <link rel="shortcut icon" href="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->icon_name; ?>" />

  <link rel="canonical" href="<?php echo base_url(); ?>" />

  <link href='https://fullcalendar.io/docs/dist/demo-to-codepen.css' rel='stylesheet' />

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

  <script src='https://fullcalendar.io/docs/dist/demo-to-codepen.js'></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      $.ajax({

        url: "<?php echo base_url(); ?>perawatan/view_list/" + "<?php echo $id_perawatan; ?>",

        type: "GET",

        dataType: "JSON",

        success: function(data)

        {

          console.log(data);



          var calendarEl = document.getElementById('calendar');

          var calendar = new FullCalendar.Calendar(calendarEl, {

            timeZone: 'UTC',

            initialView: 'multiMonthYear',

            editable: true,

            events: data,

            //eventBackgroundColor: '#1cbb8c',

            eventColor: '#378006',

            dayHeaders: true,

            eventClick: function(info) {

              alert('Event: ' + info.event.title);



              // change the border color just for fun

              //info.el.style.borderColor = 'red';

            }

          });



          calendar.render();



        },

        error: function(jqXHR, textStatus, errorThrown)

        {

          alert('Error get data from ajax');

        }

      });



      // var calendarEl = document.getElementById('calendar');

      // var calendar = new FullCalendar.Calendar(calendarEl, {

      //   timeZone: 'UTC',

      //   initialView: 'multiMonthYear',

      //   editable: true,

      //   events: 'https://fullcalendar.io/api/demo-feeds/events.json?start=2023-01-01T00%3A00%3A00Z&end=2024-01-01T00%3A00%3A00Z&timeZone=UTC'

      // });



      // calendar.render();

    });
  </script>

  <style>
    html,
    body {

      margin: 0;

      padding: 0;

      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;

      font-size: 14px;

    }

    #calendar {

      max-width: 1200px;

      margin: 40px auto;

    }



    .fc-day-sat {

      background-color: #fcb92c;

      color: #fff;

    }



    .fc-day-sun {

      background-color: #dc3545;

      color: #fff;

    }
  </style>

</head>

<body>

  <div class='demo-topbar' style="text-align: center;">

    <?php echo "Document No. : #" . $detail->document_id . " - " . $detail->judul; ?>

  </div>

  <div id='calendar'></div>

</body>

</html>