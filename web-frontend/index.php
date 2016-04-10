<!DOCTYPE html>
<html lang="de">
<head>
  <?php
  $WEB_PATH = __DIR__ ;

  require('vendor/autoload.php');
  require('../config/config.php');
  require('../src/php/app.php');

  ?>

  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Exo' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="libs/jquery.kinetic.min.js"></script>
	<!--script src="libs/jquery.smoothTouchScroll.js"></script -->

  <style>
    * {font-family: 'Exo', sans-serif}
    div.eventcolumn{float:left}
    div.date {font-size:40px;height:40px;margin:-10px 0 10px}
    div.event {
      padding:0px 7px 10px 7px;
      background-color:#99f;
      margin:0 10px 10px 0;
      width:200px;height:80px;
      border-radius:5px;
      word-wrap: break-word;
    }
    div.event table td {vertical-align:top}
    div.event img {margin-left:-5px;width:80px;float:left}
    div.event span {font-size:20px}
    div.event b {display:block;font-weight:300; font-size:18px;line-height:20px}
    div.event.family {background-color:#f99;}
    div.event.mila {background-color:#9f9}
    .weather.cold {color:#33e}
    .weather.warm {color:#e99}
    .weather.normal {color:#ddd}
    img.weatherIcon {float:left;margin:9px 9px 0 0}
    body {background-color:<?= RandomColor::one(array('luminosity' => 'random', 'hue' => 'dark')); ?>}
    .date {color:white}
    #time {width: 170px;
    display: inline-block;}
    #event-scroll{width:3000px}
    .eventdate{color:#eee}
    #event-container {overflow:hidden;}
    .panel, .eventcolumn, #event-scroll {height:220px}
    .panel   { width: 100%; -webkit-overflow-scrolling: touch;
     }
     .overflow { overflow: scroll;overflow-x: hidden;overflow-y: hidden;}
     #time {color:#999}
     div.weather {width:750px;height:160px;overflow:hidden;border-radius:5px}
     div.weather img {width:800px;margin-top:-30px;margin-left:-5px}
  </style>

</head>

<body>

  <div class="uk-container uk-container-center">
    <div class="uk-grid uk-grid-small">
      <div class="uk-width-1-1">

        <div class="date">
        <?php
          echo strftime("%A, %d.%m.", time() ).' <span id="time"></span> KW'
            .strftime('%W');

        ?>


        <?php
          $weatherService = new Weather;
          $weather = $weatherService->getMuenster();
          $temp = ((string)$weather['temperature']);
          $tempCol = 'normal';
          if ($temp <= 5) {
            $tempCol = 'cold';
          }
          if ($temp >= 15) {
            $tempCol = 'warm';
          }

          echo '<span class="weather '.$tempCol.'">' . $temp.'°C</span>';
          echo '<img class="weatherIcon" src="'.$weather['image'].'" />';
         ?>
        </div>

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
                  printf('
                    <div class="event '.$event['calendar'].'">
                    <table><tr><td>
                    '.$event['icon'].'</td><td>
                        <i>%s</i> <b>%s</b>
                      </td></tr></table>
                    </div>', $event['time'], $event['content'] );
                }
                if ($count%2 != 0) {
                  echo '<div class="event" style="background-color:'.RandomColor::one(array('luminosity' => 'random', 'hue' => 'light')).'"></div>';
                }


                echo "</div>";
              }
            }

            #    $gc->getCalendars();
          ?>
          </div>
        </div>
        <div class="weather">
          <img src="http://www.yr.no/place/Germany/North_Rhine-Westphalia/M%C3%BCnster/meteogram.png">
        </div>

        <?php
        $ursprung = mktime(18,31,18,12,22,1999);
        $akt_date = time();
        define('ZYCLUS', floor(29.530588861 * 86400));
        $mondphase = round(((($akt_date - $ursprung) / ZYCLUS) - floor(($akt_date - $ursprung) / ZYCLUS)) * 100, 0);

        $mondphasen_img = round(($mondphase /50),1) *50;
        if ($mondphasen_img == 100) $mondphasen_img == 0;

        if ($mondphase <= 1 || $mondphase >= 99 ) $phase_text = 'Vollmond';
        elseif ($mondphase > 1 && $mondphase < 49) $phase_text = 'abnehmender Mond';
        elseif ($mondphase >= 49 && $mondphase <= 51) $phase_text = 'Neumond';
        else $phase_text = 'zunehmender Mond';

        echo "MOND" . $mondphase;

        ?>

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
