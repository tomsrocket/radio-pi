<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Exo' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="libs/ uikit.almost-flat.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="libs/uik it.min.js"></script>
  <script src="libs/jquery.kinetic.min.js"></script>
	<!--script src="libs/jquery.smoothTouchScroll.js"></script -->

  <style>
    * {font-family: 'Exo', sans-serif}
    div.eventcolumn{float:left}
    div.date {font-size:40px;height:40px;margin:-10px 0 10px}
    div.event {padding:5px 10px;background-color:#99f;margin:0 10px 10px 0;width:200px;height:80px;border-radius:5px}
    div.event img {margin-left:-5px;width:80px;float:left}
    div.event span {font-size:20px}
    div.event b {display:block;}
    div.event.family {background-color:#f99;}
    div.event.mila {background-color:#9f9}
    body {background-color:black}
    .date {color:white}
    #event-scroll{width:3000px}
    .eventdate{color:#eee}
    #event-container {overflow:hidden;}
    .panel, .eventcolumn, #event-scroll {height:220px}
    .panel   { width: 100%; -webkit-overflow-scrolling: touch;
     }
     .overflow { overflow: scroll;overflow-x: hidden;overflow-y: hidden;}
     #time {color:#999}
  </style>

</head>
<body>
<?php
$WEB_PATH = __DIR__ ;

require('vendor/autoload.php');
require('../config/config.php');
require('../src/php/app.php');

?>
  <div class="uk-container uk-container-center">
    <div class="uk-grid uk-grid-small">
      <div class="uk-width-1-1">

        <?php
          echo '<div class="date">'. strftime("%A, %d.%m.", time() ).' <span id="time"></span> KW'
            .strftime('%W').'</div>';
        ?>
 <div class="panel overflow">
          <div id="event-scroll">

          <?php

            $gc = new GoogleEvents;
            $eventsByDay = $gc->getEvents();

            $now = time();
            for ($i=0;$i<10;$i++) {
              $day = strftime("%Y-%m-%d",$now + $i * 60*60*24);

              if ( isset($eventsByDay[$day])) {
                $events = $eventsByDay[$day];

                echo '<div class="eventcolumn"><div class="eventdate">'. strftime("%A, %d.%m.", strtotime($day) ).'</div>';
                $count = 0;
                foreach ($events as $event) {
                  if (++$count%3 == 0) {
                    echo '</div><div class="eventcolumn"><div class="eventdate"> &nbsp; </div>';
                  }
                  printf('<div class="event '.$event['calendar'].'">'.$event['icon'].' <i>%s</i> <b>%s</b> </div>', $event['time'], $event['content'] );
                }
                echo "</div>";
              }
            }

            #    $gc->getCalendars();
          ?>
          </div>
        </div>
        <img width="500" src="http://www.yr.no/place/Germany/North_Rhine-Westphalia/M%C3%BCnster/meteogram.png">
      </div>
    </div>
  </div>

  <script>
  function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('time').innerHTML =
      h + ":" + m + ":" + s;
      var t = setTimeout(startTime, 500);
  }
  function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
  }
  startTime();
  $(".panel").kinetic();
  </script>

</body>
</html>
