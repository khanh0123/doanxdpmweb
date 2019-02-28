importScripts('https://www.gstatic.com/firebasejs/5.4.1/firebase.js');

let config = {
    messagingSenderId: "58175360866"
};

let host = location.hostname;

var version = "1.0.0";
var urlsToCache = [
    "/",
];
var static_file_to_cache = [
    '.',
    'index.html',
    '/detail',
    'http://localhost/demo/api/detail.php',
    `manifest.json?v=${version}`,
    `app.bundle.js?v=${version}`,
    `offline.html?v=${version}`,
    `/common-css/bootstrap.css?v=${version}`,
    `/common-css/ionicons.css?v=${version}`,
    `/common-js/scripts.js?v=${version}`,
    `/layout-1/css/styles.css?v=${version}`,
    `/layout-1/css/responsive.css?v=${version}`,
    `/single-post-1/css/styles.css?v=${version}`,
    `/single-post-1/css/responsive.css?v=${version}`
    
];

var file_not_cache = [
    'facebook',
    'google',
    'fontawesome'
];

var CACHE_NAME = "demo-project-ver-" + version;

firebase.initializeApp(config);

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(payload => {
    const title = payload.notification.title ? payload.notification.title : "title";
    const options = {
        body: payload.notification.body ? payload.notification.body : "BODY",
        icon: payload.notification.icon ? payload.notification.icon : "/favicon.ico",
        data: {
            url: '/',
        }
    }
    return window.registration.showNotification(title, options);
});

self.addEventListener("install", function (event) {
    // if (doCache) {
        event.waitUntil(
            caches.open(CACHE_NAME).then(function (cache) {
                fetch("manifest.json")
                    .then(response => {
                        response.json();
                    })
                    .then(assets => {
                        console.log(assets);
                        
                        cache.addAll(urlsToCache);
                        cache.addAll(static_file_to_cache);
                    });
                
            })
        );
    // }
});
self.addEventListener("activate", event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(keyList =>
            Promise.all(
                keyList.map(key => {
                    if (!cacheWhitelist.includes(key)) {
                        return caches.delete(key);
                    }
                })
            )
        )
    );
})

self.addEventListener("message", e => {
    if (e.data.clearNow === true) {
        console.log('Clear cache PWA done');
        return caches.delete(CACHE_NAME);
    }
})


self.addEventListener("fetch", function (event) {
    event.respondWith(
        caches.match(event.request)
          .then(function(response) {
            if (response) {
              console.log('Found ', event.request.url, ' in cache');
              return response;
            }
  
            console.warn('##Service Worker##  Not in Cache... Making Network request for ', event.request.url);
  
            return fetch(event.request)
                    .then(function(response) {
                      if (response.status === 404) {
                        return caches.match('/');
                      }
                      //This code prevents caching Github api responses.
                      if (event.request.url.indexOf('facebook') > -1 || event.request.url.indexOf('google') > -1 || event.request.url.indexOf('fontawesome') > -1 || event.request.url.indexOf('fonts.gstatic.com') > -1 ) {
                          console.info('##Service Worker##  facebook and google , fontawesome requests will not be cached.');
                          return response;
                      }
  
                      return response
                    });
          })
          .catch(function(error) {
            console.error('##Service Worker##  Failed to fetch', event.request.url);
            return caches.match('/offline.html');
          })
      );
});