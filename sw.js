self.importScripts('resume.js');

var cacheName = 'resume-v1.02';
var filesToCache = [
      'app.js',
      'resume.js',
      'style.css',
      'scripts.js',
      'img/cdr-suit.jpg',
      'offline.html',
      'index.html',
      './',
];

self.addEventListener('install', function(e) {
      console.log('[ServiceWorker] Install');
      e.waitUntil(
              caches.open(cacheName).then(function(cache) {
                        console.log('[ServiceWorker] Caching app shell');
                        return cache.addAll(filesToCache);
                      })
            );
});

self.addEventListener('fetch', function(e) {
    e.respondWith(
        caches.match(e.request).then(function(r) {
            console.log('[Service Worker] Fetching resource: '+e.request.url);
            return r || fetch(e.request).then(function(response) {
            return caches.open(cacheName).then(function(cache) {
                console.log('[Service Worker] Caching new resource: '+e.request.url);
                cache.put(e.request, response.clone());
                console.dir(e);
                console.dir(response);
                return response;
                });
            });
        })
    );
});
self.addEventListener('activate', (e) => {
      e.waitUntil(
              caches.keys().then((keyList) => {
                            return Promise.all(keyList.map((key) => {
                                        if(key !== cacheName) {
                                                      return caches.delete(key);
                                                    }
                                      }));
                      })
            );
});
