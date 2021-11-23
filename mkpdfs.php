#!/usr/bin/php
<?php

/*
 * if (!file_exists("themes.json")) {
    file_put_contents("themes.json", file_get_contents("https://registry.jsonresume.org/themes"));
}
$themes = json_decode(file_get_contents("themes.json"));
$newthemes = array();
 */
chdir("resumes");
$files = glob("*.html");

$pdf = true;
$html = false;

foreach ($files as $idx=>$file) {
	$theme = preg_replace("/\.html/", '', $file);

	if ($pdf) {
        if (file_exists($theme.".html")) {
            $cmd = "wkhtmltopdf -R 0 -L 0 -B 0 -T 0 --page-size Letter --print-media-type " . $theme . ".html ../pdfs/$theme.pdf";
            print $cmd."\n";
            $results = `$cmd`;
            print $results;
        } else {
            print "*** Error: Resume resumes/$theme.html does not exist.\n";
            exit;
        }
    }
}



?>
