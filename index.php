<!DOCTYPE html>
<html>
  <head>
    <meta charset='UTF-8'>
    <title>nfl scores</title>
  </head>
  <style>
    ul {
      list-style-type: none;
      padding: 0;
      line-height: 24px;
    }

    li {
      padding: 0;
    }
  </style>
  <body>
    <?php
      $url = 'http://www.nfl.com/liveupdate/scorestrip/ss.xml';
      $xml = simplexml_load_file($url);


      function getGameDate($gameDateInput) {
        $gameDateRaw = date_create_from_format('Ymd', substr($gameDateInput, 0, -2 ));
        $gameDate = date_format($gameDateRaw, 'd.m.');
        $output .= print($gameDate . ' ');
      }

      function getGameTime($gameTimeInput) {
        $gameTime = date('h:i', strtotime($gameTimeInput));
        $output .= print($gameTime . ' ');
      }

      function replaceTeamName($teamInput) {
        $teamName = '<img src="img/' . $teamInput . '.png" style="width:18px; height:18px;"/>';
        return $teamName;
      }


      $currentWeek = $xml->gms[0]['w'];
      echo '<h1>Week ' . $currentWeek . '</h1>';
      echo '<ul>';


      foreach ($xml->gms->g as $game) {
        echo '<li>';

        getGameDate($game['eid']);
        echo $output;

        echo $game['h'] . " ";

        echo replaceTeamName($game['vnn']) . '@' . replaceTeamName($game['hnn']) . ' ';

        echo $game['v'] . ' ';

        if ($game['q'] == 'P') {
          getGameTime($game['t']);
        } else {
          echo $game['vs'] . '-' . $game['hs'];
        }
        echo '</li>';
      }

      echo '</ul>';


    ?>
  </body>
</html>
