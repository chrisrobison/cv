<?php
$in = $_REQUEST;
// print "<h1>" . $in['theme']. "</h1>";
$content = "";
$agereload = 2;
$production = true;
$base = "";

if (!$production && (!file_exists("resumes/" . $in['theme'] . ".html"))) {
        // header("Location: https://registry.jsonresume.org/chrisrobison?theme=" . $in['theme']);
        $content = file_get_contents("https://registry.jsonresume.org/chrisrobison?theme=" . $in['theme']);
        file_put_contents("resumes/".$in['theme'].".html", $content);
}

if ($content == "") {
    if (file_exists("resumes/".$in['theme'].".html")) {
        $content = file_get_contents("resumes/".$in['theme'].".html");
    } else {
        $content = file_get_contents("https://registry.jsonresume.org/chrisrobison?theme=" . $in['theme']);
        $base = "https://registry.jsonresume.org/chrisrobison?theme=" . $in['theme'];
    }
}
if ($base) {

print "<base href=\"".$base."\"/>\n";
}
    print $content;
?>
