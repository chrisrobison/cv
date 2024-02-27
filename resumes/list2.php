<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Lexend", "Helvetica Neue", "Helvetica", sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
            display: flex;
            flex-direction: row;
            height: 100vh;
            width: 100vw;
            box-sizing: border-box;
            background: #fff;
        }

        header {
            background-color: #999;
            color: #eee;
            height: 0vh;
        }
        nav {
            height: 100vh;
            overflow-y: scroll;
        }
        main {
            display: flex;
            width: 74vw;
            height: 100vh;
            overflow-y: scroll;
        }
        main > ul {
            width: 25vw;
        }
        main > iframe {
            width: 75vw;
        }
        footer {
            background-color: #666;
            color: #eee;
            height: 0vh;
        }
li {
    box-sizing: border-box;
  list-style: none;
  border: 1px solid #0006;
  margin-left: 0.5em;
margin-bottom: 0.5em;
  padding-left: 0px;
    width:11rem;
    display: flex;
    flex-direction: column;    
text-align: center;
position:relative;
transition: all 150ms linear;
transform: scale(1);
}
li:has(.thumb:hover) {
    transform: scale(1.1);    
}
h2 {
  /* margin-left: -1em; */
  margin: 0;
  display: inline-block;
    background: #006699;
    color:#fff;
}

ul {
padding-inline-start: 0px; 
display: flex;
flex-direction: row;
flex-wrap: wrap;
justify-content: space-around;
}

.thumb {
    box-shadow: 3px 3px 3px #0006;
    border: 1px solid #0006;
    padding: 3px;
    margin:3px;
    transition: transform 100ms linear 50ms;
    transform-origin: center center;
    transform: scale(1);
    background: #fff;
    box-shadow: 3px 3px 3px #0006;
}
.thumb:hover {
    transform: scale(1.1);
    transform-origin: center center;
}
h1 {
    text-align:center;
    background: #333;
color:#fff;
text-transform:uppercase;
margin:0px;
padding: 0.5em;
}

a.rating {
    text-decoration:none;
    color:#666;
    display: inline-block;
    width: 18px;
    height: 2em;
    text-align: left;
}
.star {
}
a.star::before {
    display: inline-block;
    position: absolute;
    top: 2px; 
    margin-left: -0.5em;
    content: "⭐";
    height: 2em;
    width: 18px;
    transform: scale(1);
    transition: transform 200ms;
    filter: drop-shadow(1px 1px 0px #0008);

}
a.halfstar::before {
    display: inline-block;
    position: absolute;
    top: 2px; 
    margin-left: -0.5em;
    content: "⭐";
    height: 2em;
    width: 8px;
    transform: scale(1);
    transition: transform 200ms;
    filter: drop-shadow(1px 1px 0px #0008);
    overflow: hidden;
}
a.dot::before {
    display: inline-block;
    position: absolute;
    top: 2px; 
    content: "⚬";
    height: 1em;
    width: 18px;
    transform: scale(1);
    transition: transform 200ms;
}
a.dot:hover::before, a.star:hover::before, a.halfstar:hover::before {
    content: "⭐";
    display: inline-block;
    position:absolute;
    height: 1em;
    width: 18px;
    top:2px;
    margin-left:-0.5em;
    transform: scale(1.5);
    transition: transform 200ms;
}
.rating {
    position:relative;
    background:#ddd;
    display: flex;
    align-items: center;
    justify-content: center;
}
.rating_votes {
    font-family: "Lexend","HelveticaNeue",sans-serif;
    font-weight: 300;
    font-size: 0.8em;

}
.rating_avg {
    padding-right: 0.5em;
    font-family: "Lexend","HelveticaNeue",sans-serif;
    font-weight: 300;
    font-size: 0.8em;
}
#toolbar {
    padding-top: 1em;
    padding-left: 1em;
}
.selected {
    background-color: #ff06;
}
@media print {
    nav { display: none; }
    main { width: 100vw; }
}
    </style>
</head>

<body>
<nav>
<h1>Resume Themes</h1>
<div id='toolbar'>
    <label for='sort'>Sort</label> 
    <select id='sort' onchange="app.doSort(this.options[this.selectedIndex].value)">
        <option>Alphabetically</option>
        <option value='popular' SELECTED>Popularity</option>
        <option value='none'>None</option>
    </select>
</div>
<ul id='themes' onclick="return app.handleClick(event, this)">
<?php
$files = glob("*.html");
$wstar = "☆";
$sstar = "★";
$estar = "⭐";
$edot = "🔘";
$dot = ""; // "⚬";

$ignore = array("cora", "el-santo", "flat-fr", "kards", "modern", "one", "onepageresume", "paper", "simple-red","slick","spartan","srt","techlead");
    $out = array();
    foreach ($files as $file) {
        $parts = preg_split("/\./", $file);
        if (!in_array($parts[0], $ignore)) {
            $theme = $parts[0];
            $name = ucfirst($theme);
            $json = file_get_contents("https://cdr2.com/cv/resumes/rate.php?x=get&theme={$theme}");
            $obj = json_decode($json);
            $rating = sprintf("%.1f", floor($obj->ratings->{$theme} * 10) / 10);
            if (!$rating) {
                $rating = '0.0';
           }
            print "<li id='theme-{$theme}' data-theme='{$theme}' data-rating='{$rating}' data-votes='{$obj->ratings->{$theme.'_votes'}}' class='theme'><h2>{$name}</h2><span><a href=\"$file\" class='framelink'><img src=\"{$parts[0]}_thumb.png\" width=\"100\" height=\"100\" class='thumb'></a><br><a href=\"$file\" class='framelink'>HTML</a>  | <a class='framelink' href=\"{$parts[0]}.pdf\">PDF</a> | <a class=\"framelink\" href=\"{$parts[0]}.docx\">DOCX</a></span><div class='rating' data-rating='$rating' data-theme='$theme' id='rating_$theme'> ";
            $obj2 = new stdClass();
            $obj2->theme = $theme;
            $obj2->rating = $rating;
            $obj2->url = $parts[0].".html";
            $obj2->pdf = $parts[0].".pdf";
            $obj2->docx = $parts[0].".docx";
            if ($rating > $best) {
                $best = $rating;
                $mostpopular = $theme;
            } 
            for ($i=1; $i<6; $i++) {
                if ($i <= $rating) {
                    print "<a href='#' id='rating-$theme-$i' class='star rating' data-theme=\"$theme\" data-rating=\"$i\">$dot</a>\n";
                } else if (($rating < $i) && ($rating > ($i - 1))) {
                    $fraction = 100;
                    
                    $fraction = ($rating - floor($rating)) * 100;
                    // print "Rating: $rating<br>\nFraction: $fraction<br>\n";
                    print "<a href='#' id='rating-$theme-$i' class='halfstar rating' data-theme=\"$theme\" data-rating=\"$i\">$dot</a>\n";
                } else {
                    print "<a href='#' id='rating-$theme-$i' class='dot rating' data-theme=\"$theme\" data-rating=\"$i\">$dot</a>\n";
                }
            }
            print "<span id='rating_avg_$theme' class='rating_avg'>$rating</span><span class='rating_votes'>(<span id='rating_votes_$theme'>".$obj->ratings->{$theme.'_votes'}."</span>)</span>";
            print "</div></li>\n";
            $out[] = $obj2;
        }
    }
?>
    </ul>
</nav>
    <script>
        function resizeIframe(iframe) {
            if (iframe.src.match(/\.pdf/i)) {
                iframe.height = "100%";
                iframe.style.height = "100vh";
            } else {
                iframe.height = iframe.contentWindow.document.body.scrollHeight + "px"; 
            }
        }
        const $ = str => document.querySelector(str);
        const $$ = str => document.querySelectorAll(str);

        (function() {
            const app = {
                init() {
                    app.state.loaded = true;
                    console.info("Loaded.");
                    app.themes = <?php print json_encode($out); ?>;
                    app.doSort('popular');
                },
                handleClick: function(evt, obj) {
                    // if (evt.target.localName = "ul") return;
                    let tgt = evt.target.closest(".theme");

                    let theme = tgt.id.replace(/^theme\-/, '');

                    app.selectTheme(theme);
                    if ((evt.target.classList.contains("rating")) || (evt.target.parentNode.classList.contains("rating"))) { 
                        app.rateResume(tgt.dataset.theme, evt.target.dataset.rating);
                        evt.preventDefault();
                        evt.stopPropagation();
                        return false;
                    }

                    if ((evt.target.classList.contains("framelink")) || (evt.target.parentNode.classList.contains("framelink"))) {
console.log("someone has a framelink");
                        if (evt.target.nodeName === "A") {
console.log("we have an A node");
                            parent.app.loadTab(evt.target.href, tgt.querySelector("h2").innerText, tgt.querySelector("h2").innerText.replace(/\W/g, ''), true, evt);
                            return false;
                        } else if (evt.target.parentNode.nodeName === "A") {
console.log("our parent is an A node");
                            parent.app.loadTab(evt.target.parentNode.href, tgt.querySelector("h2").innerText, tgt.querySelector("h2").innerText.replace(/\W/g, ''), true, evt);
                            return false;
                        } else {
                            console.log("Must've clicked on the thumbnail");
                        }
                    } 
                    if ((evt.target.nodeName === "IMG") && (evt.target.className==="thumb")) {
console.log("We have an image!");
                        let li = evt.target.closest(".theme");
console.log("closest theme el:");
console.dir(li);
                        if (li) {
                            let theme = li.dataset.theme;
                            let title = li.querySelector("h2").innerText;
                            
                            parent.app.loadTab(`${theme}.html`, title.replace(/^([a-z])/, function(str) { return str.toUpperCase(); }), title.replace(/\W/g, ''), true, evt);

                        }
                    }
                    // if we get here, load html version as last resort
                    parent.app.loadTab(`/cv/resumes/${theme}.html`, theme, theme, true, evt);

                    return false;
                },
                selectTheme: function(theme) {
                    $$(".selected").forEach((el) => { el.classList.remove('selected'); });
                    $(`#theme-${theme}`).classList.add('selected');
                },
                state: {
                    loaded: false
                },
                doSort: function(sortBy) {
                    console.log(`doSort( ${sortBy} )`);
                    let themes = [...$$(".theme")];
                    let outhtml = "";

                    if (sortBy == "popular") {
                        themes.sort(function(a, b) {
                            let aRating = a.dataset.rating;
                            let bRating = b.dataset.rating;
                            return Number(bRating) - Number(aRating);
                        });
                        outhtml = themes.reduce((a, el) => a + el.outerHTML, "");
                    } else {
                        themes.sort(function(a, b) {
                            let aRating = a.dataset.theme;
                            let bRating = b.dataset.theme;
                            if (aRating < bRating) {
                                return -1;
                            } else if (aRating > bRating) {
                                return 1;
                            } else {
                                return 0;
                            }
                        });
                        outhtml = themes.reduce((a, el) => a + el.outerHTML, "");
                    }
                    $("#themes").innerHTML = outhtml;
                },
                rateResume: function(theme, rating) {
                    fetch(`rate.php?x=rate&theme=${theme}&rating=${rating}`).then(resp=>resp.json()).then(data=>{

                        console.log("rateResume results");
                        console.dir(data);

                        let themeWrap = $(`#theme-${theme}`);
                        if (themeWrap) {
                            themeWrap.dataset.rating = data.ratings[theme];
                            themeWrap.dataset.votes = data.ratings[theme+'_votes'];
                        }
                        let rateWrap = $(`#rating_${theme}`);
                        if (data.ratings[theme]) {
                            rateWrap.dataset.rating = data.ratings[theme];
                            rateWrap.dataset.votes = data.ratings[theme+'_votes'];
                            console.log(`Set rating to ${data.ratings[theme]} (${data.ratings[theme+'_votes']}) for ${theme}`);
                            app.updateRatings(rateWrap, theme);
                            let mysort = $("#sort").options[$("#sort").selectedIndex].value;
                            console.log("Sorting by " + mysort);
                            app.doSort(mysort);
                        }
                    });
                    return false;
                },
                updateRatings: function(el, theme) {
                    let rating = el.dataset.rating;
                    let votes = el.dataset.votes;
                    let cls = '';

                    for (let i=1; i<6; i++) {
                        cls = (i <= rating) ? 'star' : 'dot';
                        if ((i > rating) && ((i - 1) < rating)) {
                           cls = 'halfstar';
                        }
                        $(`#rating-${theme}-${i}`).className = "rating " + cls;
                    }
                    $(`#rating_avg_${theme}`).innerHTML = rating;
                    $(`#rating_votes_${theme}`).innerHTML = votes;
                }
            }
            window.app = app;
            app.init();
        })();
    </script>
</body>

</html>
