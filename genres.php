#!/usr/bin/php
<?php

if (!file_exists("themes.json")) {
    file_put_contents("themes.json", file_get_contents("https://registry.jsonresume.org/themes"));
}
$themes = json_decode(file_get_contents("themes.json"));
$newthemes = array();

$pdf = true;
$html = false;

$skip = array('elite', 'orbit');

foreach ($themes as $idx=>$theme) {
    $theme = preg_replace("/^jsonresume-theme-/", "", $theme);
    $newthemes[] = $theme;

    if (in_array($theme, $skip)) { continue; }
    if ($pdf) {
        if (file_exists("resumes/".$theme.".html")) {
            $cmd = "wkhtmltopdf -R 0 -L 0 -B 0 -T 0 --page-size Letter --print-media-type resumes/" . $theme . ".html pdfs/$theme.pdf";
            print $cmd."\n";
            $results = `$cmd`;
            print $results;
        } else {
            print "*** Error: Resume resumes/$theme.html does not exist.\n";
            exit;
        }
    }

    if ($html && !file_exists("generated/{$theme}.html")) {
        try {
            //$html = file_get_contents("https://registry.jsonresume.org/chrisrobison?theme=" . $theme);
            //file_put_contents("generated/{$theme}.html", $html);
            $out = `wget -pk https://registry.jsonresume.org/chrisrobison?theme={$theme}`;
            file_put_contents("generated/{$theme}.html", $out);
           
            print "Wrote " . strlen($html) . " bytes to resumes/{$theme}.html\n";
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}



?>
