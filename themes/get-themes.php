#!/usr/local/bin/php
<?php
    $html = file_get_contents("themes.html");

    if (preg_match_all("/<a href=\"([^\"]*)\"/s", $html, $matches)) {
        foreach ($matches[1] as $url) {
            print $url."\n";
        }
    }
?>
