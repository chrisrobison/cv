#!/usr/local/bin/php
<?php

$themes = json_decode(file_get_contents("themes.json"));
$newthemes = array();

$pdf = false;
$html = true;

$skip = array('elite', 'orbit');

foreach ($themes as $theme) {
    $newthemes[] = $theme;
    
    if (in_array($theme, $skip)) { continue; }

    $results = `resume export resumes/{$theme}.html -t ./node_modules/jsonresume-theme-{$theme}/`;
    //$resume = file_get_contents($surl);
    print $theme." processed\n";
    
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
