<?php

class Weather {


  private $muensterUrl = 'http://www.yr.no/place/Germany/North_Rhine-Westphalia/M%C3%BCnster/forecast.xml';


  /*
    <time from="2016-02-25T00:00:00" to="2016-02-25T06:00:00" period="0">
      <!--
       Valid from 2016-02-25T00:00:00 to 2016-02-25T06:00:00
      -->
      <symbol number="2" numberEx="2" name="Fair" var="mf/02n.58"/>
      <precipitation value="0"/>
      <!--  Valid at 2016-02-25T00:00:00  -->
      <windDirection deg="235.5" code="SW" name="Southwest"/>
      <windSpeed mps="2.2" name="Light breeze"/>
      <temperature unit="celsius" value="0"/>
      <pressure unit="hPa" value="1013.4"/>
    </time>
  */


  public function getMuenster() {

    $xml = file_get_contents( $this->muensterUrl );

    $weatherdata = simplexml_load_string($xml);

    $updatedAt = $weatherdata->meta->lastupdate;

    $time  = $weatherdata->forecast->tabular->time[0];

    $weather = [
      'rain' => $time->precipitation['value'],
      'temperature' => $time->temperature['value'],
      'symbol' => $time->symbol['name'],
      'symbolId'=> $time->symbol['number'],
      'image' => 'http://symbol.yr.no/grafikk/sym/b38/'.$time->symbol['var'].'.png'
    ];

    return $weather;

  }






}
/*
°, °

'http://api.met.no/weatherapi/locationforecast/1.9/?lat=51.962944;lon=7.628694;msl=60'

http://api.met.no/weatherapi/locationforecast/1.9/?lat=51.962944;lon=7.628694;msl=60



http://www.yr.no/place/Germany/North_Rhine-Westphalia/M%C3%BCnster/forecast.xml


http://www.yr.no/place/Norway/Telemark/Sauherad/Gvarv/forecast.xml

*/
