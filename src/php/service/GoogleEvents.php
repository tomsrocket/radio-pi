<?php



class GoogleEvents {

/*
2837i5ptnh7rcfbcdadq120slo@group.calendar.google.com -- Freizeit
ankeic1u7it5qpreggu94djadc@group.calendar.google.com -- Familienkalender
3h2n7aq6nr9q3g93ajf01p5blg@group.calendar.google.com -- Wohnzimmer e.V. Münster - Termine 2013
j5qaokilcvhii8rcatdq6lvbg4@group.calendar.google.com -- Geburtstagskalender
 -- thomas werner
hc82sdjshuf1ru9f9eqcfq9bvs@group.calendar.google.com -- Warpzone
#contacts@group.v.calendar.google.com -- Geburtstage
de.french#holiday@group.v.calendar.google.com -- Feiertage in Frankreich
*/

  protected $service;

  function __construct()
  {
    $client = getClient();
    $this->service = new Google_Service_Calendar($client);

  }


  function getCalendars()
  {
    $calendarList = $this->service->calendarList->listCalendarList();

    while(true) {
      foreach ($calendarList->getItems() as $calendarListEntry) {
        echo "<br />" . $calendarListEntry->getId() . ' -- ' . $calendarListEntry->getSummary();

      }
      $pageToken = $calendarList->getNextPageToken();
      if ($pageToken) {
        $optParams = array('pageToken' => $pageToken);
        $calendarList = $service->calendarList->listCalendarList($optParams);
      } else {
        break;
      }
    }

  }


  function getEvents() {
    global $WEB_PATH;

    // Print the next 10 events on the user's calendar.
    $calendarId = 'primary';
    $calendarId = 'ankeic1u7it5qpreggu94djadc@group.calendar.google.com';
    $optParams = array(
      'maxResults' => 3,
      'orderBy' => 'startTime',
      'singleEvents' => TRUE,
      'timeMin' => date('c'),
    );


    $results = $this->service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();
    foreach ( $events as &$eve ) {
      $eve->setTransparency("family"); # div class
    }

/*
    $results = $this->service->events->listEvents('2837i5ptnh7rcfbcdadq120slo@group.calendar.google.com', $optParams);
    $events2 = $results->getItems();
    foreach ( $events2 as &$eve ) {
      $eve->setTransparency("mila"); # div class
    }
    $events = array_merge( $events, $events2);
*/


    $results = $this->service->events->listEvents('primary', $optParams);

    $events = array_merge( $events,$results->getItems());



    foreach ($events as $event) {


        $start = $event->start->dateTime;
        if (empty($start)) {
          $start = $event->start->date;
        }
        $desc = $event->getDescription();
        $icon = "";
        if (preg_match('/\(Sticker_([^\)]+)\)/', $desc, $matches)) {
            $icon = $matches[1];
        }

        $date = strftime("%a %d.%m.",strtotime($start));
        $time = strftime("%R",strtotime($start));

        if ($icon) {
          $iconfile = 'icons/'.$icon.'.png';
          if (file_exists($iconfile)) {
            $icon = '<img src="'.$iconfile.'" />';
          }
        }
        printf('<div class="event '.$event->getTransparency().'">'.$icon.' <span>%s</span> <i>%s</i> <b>%s</b> </div>', $date, $time, $event->getSummary() );

    }

  }


}
