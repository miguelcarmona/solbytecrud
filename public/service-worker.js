self.addEventListener('install', (event) => {
    console.log('Service Worker instalado');
    event.waitUntil(
      caches.open('v1').then((cache) => {
        return cache.addAll([
          '/css/app.css',
          '/js/app.js',
          '/manifest.json',
          '/icon-192x192.png',
          '/icon-512x512.png'
        ]);
      })
    );
  });
  
  self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((response) => {
        return response || fetch(event.request);
      })
    );
  });
  