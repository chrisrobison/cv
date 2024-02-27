<?php

include($_SERVER['DOCUMENT_ROOT'] . '/.env');
$in = $_REQUEST;
$out = array();
$link = mysqli_connect($env->db->host, $env->db->user, $env->db->pass, "general");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (array_key_exists("x", $in)) {
     switch($in['x']) {
         case "rate":
            $out = rateTheme($link, $in);
            break;
         case "getall":
            $out = getAllRatings($link, $in);
            break;
         case "get":
            $out = getRating($link, $in['theme']);
            break;
    }
    
    header("Content-type: application/json; charset=utf-8");
    print json_encode($out);

}


function rateTheme($link, $in) {
   $sql = "INSERT INTO rate_resume (id, theme, rating, `by`) VALUES (null, '".$in['theme']."', ". $in['rating'] .", '".$_SERVER['REMOTE_ADDR']."')";
   $results = mysqli_query($link, $sql);
   $out = getRating($link, $in['theme']);
   $out['results'] = 'ok';
   return $out;
}

function getAllRatings($link, $in) {
   $sql = "SELECT theme, AVG(rating) as avgRating from rate_resume GROUP BY theme";
   $results = mysqli_query($link, $sql);

   $out = array();
   $out['ratings'] = array();

   if ($results) {
      while ($row = $results->fetch_assoc()) {
         $out['ratings'][$row['theme']] = $row['avgRating'];
      }
   }

   return $out;
}

function getRating($link, $theme) {
   $sql = "SELECT theme, AVG(rating) as avgRating from rate_resume WHERE theme='{$theme}' GROUP BY theme";
   $results = mysqli_query($link, $sql);
   $out = array();
   $out['ratings'] = array();

   if ($results) {
      while ($row = $results->fetch_assoc()) {
         $out['ratings'][$theme] = sprintf("%.1f", $row['avgRating']);
      }
   }
   
   $sql = "SELECT count(rating) as votes from rate_resume WHERE theme='{$theme}'";
   $results = mysqli_query($link, $sql);
   
   if ($results) {
      while ($row = $results->fetch_assoc()) {
         $out['ratings'][$theme.'_votes'] = $row['votes'];
      }
   } 
   return $out;
}
?>
