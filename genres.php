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
        $cmd = "wkhtmltopdf https://registry.jsonresume.org/chrisrobison?theme=" . $theme . " pdfs/$theme.pdf";
        print $cmd."\n";
        $results = `$cmd`;
        print $results;
    }

    if ($html && !file_exists("generated/{$theme}.html")) {
        try {
            $html = file_get_contents("https://registry.jsonresume.org/chrisrobison?theme=" . $theme);
            file_put_contents("generated/{$theme}.html", $html);
            print "Wrote " . strlen($html) . " bytes to generated/{$theme}.html\n";
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}



?>
