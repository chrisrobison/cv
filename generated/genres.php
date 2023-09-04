#!/usr/local/bin/php
<?php

//if (!file_exists("themes.json")) {
    file_put_contents("themes.json", file_get_contents("https://registry.jsonresume.org/api/themes"));
//}
$themes = json_decode(file_get_contents("themes.json"));
$newthemes = array();
print_r($themes);

$doPdf = true;
$doHtml = true;

$skip = array('elite', 'orbit');

foreach ($themes as $theme=>$surl) {
    $theme = preg_replace("/^jsonresume-theme-/", "", $theme);
    $newthemes[] = $theme;
    
    if (in_array($theme, $skip)) { continue; }
    $surl = preg_replace("/thomasdavis/", "chrisrobison", $surl);

    $resume = file_get_contents($surl);
    print "Generating $theme resume\n"; 
    if ($doHtml) {
        try {
            $results = `curl -s -o $theme.html $surl`;
            $size = filesize("$theme.html");
            if ($size < 200) {
                print "WARNING: Bad or no content returned for $theme. Removing file...\n";
                $results = `rm $theme.html`;
            } else {
                print "Wrote $size bytes to {$theme}.html\n";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    if ($doPdf) {
        if (file_exists("$theme.html")) {
            $cmd = "wkhtmltopdf -R 0 -L 0 -B 0 -T 0 --page-size Letter --print-media-type $theme.html $theme.pdf";
            print $cmd."\n";
            $results = `$cmd`;
            print $results;
        } else {
            print "*** WARNING: Resume $theme.html does not exist. Skipping...\n";
        }
    }
    
}



?>
