#!/usr/local/bin/php
<?php

//if (!file_exists("themes.json")) {
    file_put_contents("themes.json", file_get_contents("https://registry.jsonresume.org/themes"));
//}
$themes = json_decode(file_get_contents("themes.json"));
$newthemes = array();

$pdf = false;
$html = true;

$skip = array('elite', 'orbit');

foreach ($themes as $theme=>$surl) {
    $theme = preg_replace("/^jsonresume-theme-/", "", $theme);
    $newthemes[] = $theme;
    
    if (in_array($theme, $skip)) { continue; }
    $surl = preg_replace("/thomasdavis/", "chrisrobison", $surl);

    $resume = file_get_contents($surl);
    print $surl."\n";
    
     
    if ($html && !file_exists("generated/{$theme}.html")) {
        try {
            //$html = file_get_contents("https://registry.jsonresume.org/chrisrobison?theme=" . $theme);
            //file_put_contents("generated/{$theme}.html", $html);
            $results = `curl -s -o generated/$theme.html $surl`;
            //$out = `wget -pk https://registry.jsonresume.org/chrisrobison?theme={$theme}`;
            // file_put_contents("generated/{$theme}.html", $out);
            $size = filesize("generated/$theme.html");
            if ($size < 200) {
                print "WARNING: Bad or no content returned for $theme. Removing file...\n";
                $results = `rm generated/$theme.html`;
            } else {
                print "Wrote $size bytes to generated/{$theme}.html\n";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    if ($pdf) {
        if (file_exists("resumes/".$theme.".html")) {
            $cmd = "wkhtmltopdf -R 0 -L 0 -B 0 -T 0 --page-size Letter --print-media-type resumes/" . $theme . ".html pdfs/$theme.pdf";
            print $cmd."\n";
            $results = `$cmd`;
            print $results;
        } else {
            print "*** WARNING: Resume resumes/$theme.html does not exist. Skipping...\n";
        }
    }
    
}



?>
