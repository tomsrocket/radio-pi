<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Exo' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/uikit.almost-flat.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="/uikit.min.js"></script>

  <style>
    * {font-family: 'Exo', sans-serif;}
    div.date {font-size:40px;height:40px;margin:-10px 0 10px}
    div.event {padding:5px 10px;background-color:#99f;float:left;margin:0 10px 10px 0;width:230px;height:80px;border-radius:5px}
    div.event img {margin-left:-5px;width:80px;float:left}
    div.event span {font-size:20px}
    div.event b {display:block;}
    div.event.family {background-color:#f99;}
    div.event.mila {background-color:#9f9}
    body {background-color:black}
    .date {color:white}
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
        <div class="date"><?php
          echo strftime("%A, %d.%m.", time() + 3600*4 );

        ?></div>

          <?php

                    $gc = new GoogleEvents;
                    $gc->getEvents();
                #    $gc->getCalendars();

                    ?>
        <img width="500" src="http://www.yr.no/place/Germany/North_Rhine-Westphalia/M%C3%BCnster/meteogram.png">
      </div>
    </div>
  </div>
</body>
</html>
