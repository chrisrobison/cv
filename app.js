function $(str) { return document.querySelector(str); }
function $$(str) { return document.querySelectorAll(str); }
(function() {
    window.app = {
        init: function() {
            console.log("app.init() called.");
            $(".loader").style.display = "block";
            fetch("resume.json").then(response=>response.json()).then(function(data) {
                console.dir(data);
                app.data = data;
                app.outline(); 
            });
        },
        outline: function() {
            let out = app.dump(app.data);
            $(".main").innerHTML = out;
        },
        dump: function(obj) {
            let out = '<ul>';

            for (let i in obj) {
                let txt = i.replace(/^(.)/, function(str) { return str.toUpperCase(); });
                out += '<li>';
                if (!obj.length) {
                    out += '<h3>' + txt + '</h3>';
                }

                if ((typeof(obj[i]) === "object") || (typeof(obj[i])==="array")) {
                    out += app.dump(obj[i]);
                } else {
                    let content = "<p>" + obj[i].replace(/\n\n/g, "</p><p>") + "</p>";
                    out += content;
                }
                out += "</li>";
            }
            out += "</ul>";
            return out;
        }
    }

})();
app.init();
if('serviceWorker' in navigator) {
        navigator.serviceWorker.register('sw.js');
};
