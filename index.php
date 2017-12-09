<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>nfl scores</title>
  </head>
  <body>
    <?php
      $url = "http://www.nfl.com/liveupdate/scorestrip/ss.xml";
      $xmlfile = file_get_contents($url);
      $object = simplexml_load_string($xmlfile);

      $json = json_encode($object);

      $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($json, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

      foreach ($jsonIterator as $key => $val) {
        if(is_array($val)) {
          //echo "<b>$key:</b><br />";
        } else {
          //echo "$key: $val<br />";
          if ($key == "vnn") {
            $awayTeam = $val;
          } elseif ($key == "hnn") {
            $homeTeam = $val;
          } elseif ($key == "eid") {
            $gamedateraw = date_create_from_format('Ymd', substr($val, 0, -2 ));
            $gamedate = date_format($gamedateraw, 'd.m.Y');
          } elseif ($key == "t") {
            $gametime = date("h:i", strtotime($val));
          } elseif ($key == "w") {
            $currentWeek = $val;
          }
        }
      }

      echo "<h1>Woche $currentWeek</h1>";
      echo "$gamedate, $gametime $awayTeam @ $homeTeam";


    ?>
  </body>
</html>
