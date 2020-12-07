function $(str) { return document.querySelector(str); }
function $$(str) { return document.querySelectorAll(str); }
(function() {
    window.app = {
        init: function() {
            console.log("app.init() called.");
            $(".loader").style.display = "block";
        }
    }

})();
app.init();
if('serviceWorker' in navigator) {
        navigator.serviceWorker.register('sw.js');
};
