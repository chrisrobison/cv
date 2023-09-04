#!/usr/local/bin/php
<?php
    $list = file_get_contents("themes.list");
    $items = preg_split("/\n/", $list);
    foreach ($items as $item) {
        if (preg_match("/theme=(.*)/", $item, $matches)) {
            $theme = $matches[1];
            $html = file_get_contents($item);
            if (strlen($html) > 200) {
                file_put_contents("generated/{$theme}.html", $html);
                print "wrote ".strlen($html)." bytes to {$theme}.html\n";
            }
        }
    }
?>
