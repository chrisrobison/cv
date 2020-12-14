<?php
$in = $_REQUEST;
// print "<h1>" . $in['theme']. "</h1>";
$content = "";
$agereload = 2;

if ((!file_exists("resumes/" . $in['theme'] . ".html")) || (time()-filemtime("resumes/".$in['theme'].".html") > (3600 * $agereload))) {
        // header("Location: https://registry.jsonresume.org/chrisrobison?theme=" . $in['theme']);
        $content = file_get_contents("https://registry.jsonresume.org/chrisrobison?theme=" . $in['theme']);
        file_put_contents("resumes/".$in['theme'].".html", $content);
}

if ($content == "") {
    $content = file_get_contents("resumes/".$in['theme'].".html");
}
    print $content;
?>
