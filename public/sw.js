importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-sw.js');

const CACHE_NAME = 'inventory-app-cache-v1';
const OFFLINE_PAGE = '/offline';
const QUEUE_NAME = 'inventory-app-queue';

const PRECACHE_ASSETS = [
  '/public/'
]


self.addEventListener('install', event => {
  event.waitUntil((async () => {
      const cache = await caches.open(CACHE_NAME);
      cache.addAll(PRECACHE_ASSETS);
  })());
});

self.addEventListener('activate', event => {
  event.waitUntil(clients.claim());
});

self.addEventListener('beforeinstallprompt', saveBeforeInstallPromptEvent);

let deferredInstallPrompt;

function saveBeforeInstallPromptEvent(evt) {
  deferredInstallPrompt = evt;
}

workbox.routing.registerRoute(
  new RegExp('/api/.*'),
  new workbox.strategies.NetworkFirst({
    cacheName: CACHE_NAME,
  })
);

// Show install prompt
self.addEventListener('beforeinstallprompt', (event) => {
  event.preventDefault();
  deferredInstallPrompt.prompt();
  deferredInstallPrompt.userChoice.then((choiceResult) => {
    if (choiceResult.outcome === 'accepted') {
      console.log('User accepted the prompt');
    } else {
      console.log('User dismissed the prompt');
    }
    deferredInstallPrompt = null;
  });
});


self.addEventListener('fetch', event => {
  event.respondWith((async () => {
      const cache = await caches.open(CACHE_NAME);

      // Try the cache first like last time.
      const cachedResponse = await cache.match(event.request);
      if (cachedResponse !== undefined) {
          // Now, we fetch a new response and cache it in the background
          fetch(event.request).then( response => {
              cache.put(event.request, response.clone());
          });
          // We don't await the above line, so we return our cachedResponse right away
          return cachedResponse;
      } else {
          // Go to the network otherwise
      }
  }))
});

async function shareLink(shareTitle, shareText, link) {
  const shareData = {
    title: shareTitle,
    text: shareText,
    url: link,
  };
  try {
    await navigator.share(shareData);
  } catch (e) {
    console.error(e);
  }
}

self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});
