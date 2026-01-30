// ==================== SERVICE WORKER - AMIGO DO BOLSO ====================
const CACHE_VERSION = 'amigo-bolso-v1.0.0';
const CACHE_STATIC = `${CACHE_VERSION}-static`;
const CACHE_DYNAMIC = `${CACHE_VERSION}-dynamic`;
const CACHE_API = `${CACHE_VERSION}-api`;

// Arquivos essenciais para cache (offline-first)
const STATIC_FILES = [
  '/',
  '/assets/images/logoOficial.png',
  '/css/styles.css',
  '/js/main.js',
  '/offline.html'
];

// ========== INSTALL - Cache arquivos estáticos ==========
self.addEventListener('install', (event) => {
  console.log('[SW] Instalando Service Worker...');
  
  event.waitUntil(
    caches.open(CACHE_STATIC)
      .then((cache) => {
        console.log('[SW] Cacheando arquivos estáticos');
        return cache.addAll(STATIC_FILES);
      })
      .catch((error) => {
        console.error('[SW] Erro ao cachear arquivos:', error);
      })
  );
  
  self.skipWaiting();
});

// ========== ACTIVATE - Limpa caches antigos ==========
self.addEventListener('activate', (event) => {
  console.log('[SW] Ativando Service Worker...');
  
  event.waitUntil(
    caches.keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames
            .filter((name) => name.startsWith('amigo-bolso-') && name !== CACHE_STATIC && name !== CACHE_DYNAMIC && name !== CACHE_API)
            .map((name) => {
              console.log('[SW] Removendo cache antigo:', name);
              return caches.delete(name);
            })
        );
      })
  );
  
  return self.clients.claim();
});

// ========== FETCH - Estratégia de Cache ==========
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);
  
  // Ignora requisições de outros domínios (CDNs, etc)
  if (url.origin !== location.origin) {
    return;
  }
  
  // Ignora requisições POST/PUT/DELETE (apenas GET)
  if (request.method !== 'GET') {
    return;
  }
  
  event.respondWith(handleFetch(request));
});

// ========== ESTRATÉGIA DE CACHE ==========
async function handleFetch(request) {
  const url = new URL(request.url);
  
  // 1. Rotas de API: Network-First (sempre tenta buscar atualizado)
  if (url.pathname.startsWith('/api/')) {
    return networkFirst(request, CACHE_API);
  }
  
  // 2. Assets estáticos (CSS, JS, imagens): Cache-First
  if (
    url.pathname.endsWith('.css') ||
    url.pathname.endsWith('.js') ||
    url.pathname.endsWith('.png') ||
    url.pathname.endsWith('.jpg') ||
    url.pathname.endsWith('.svg') ||
    url.pathname.includes('/assets/')
  ) {
    return cacheFirst(request, CACHE_STATIC);
  }
  
  // 3. Páginas HTML: Network-First (para ter conteúdo atualizado)
  return networkFirst(request, CACHE_DYNAMIC);
}

// ========== CACHE-FIRST (assets estáticos) ==========
async function cacheFirst(request, cacheName) {
  const cached = await caches.match(request);
  
  if (cached) {
    return cached;
  }
  
  try {
    const response = await fetch(request);
    
    if (response.ok) {
      const cache = await caches.open(cacheName);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    console.error('[SW] Erro ao buscar:', error);
    
    // Se for imagem e falhar, retorna placeholder
    if (request.destination === 'image') {
      return new Response(
        '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="#ddd" width="200" height="200"/><text x="50%" y="50%" text-anchor="middle" fill="#999">Sem imagem</text></svg>',
        { headers: { 'Content-Type': 'image/svg+xml' } }
      );
    }
    
    throw error;
  }
}

// ========== NETWORK-FIRST (páginas e API) ==========
async function networkFirst(request, cacheName) {
  try {
    const response = await fetch(request);
    
    if (response.ok) {
      const cache = await caches.open(cacheName);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    console.log('[SW] Rede indisponível, buscando no cache...');
    
    const cached = await caches.match(request);
    
    if (cached) {
      return cached;
    }
    
    // Se não tem cache e está offline, retorna página offline
    if (request.mode === 'navigate') {
      const offlinePage = await caches.match('/offline.html');
      if (offlinePage) {
        return offlinePage;
      }
    }
    
    throw error;
  }
}

// ========== SINCRONIZAÇÃO EM BACKGROUND ==========
self.addEventListener('sync', (event) => {
  console.log('[SW] Background Sync:', event.tag);
  
  if (event.tag === 'sync-transactions') {
    event.waitUntil(syncTransactions());
  }
});

async function syncTransactions() {
  // Implementar lógica de sincronização quando voltar online
  console.log('[SW] Sincronizando transações...');
}

// ========== NOTIFICAÇÕES PUSH ==========
self.addEventListener('push', (event) => {
  const data = event.data ? event.data.json() : {};
  
  const options = {
    body: data.body || 'Nova notificação do Amigo do Bolso',
    icon: '/assets/icons/icon-192.png',
    badge: '/assets/icons/badge-72.png',
    vibrate: [200, 100, 200],
    tag: data.tag || 'notification',
    data: data.url || '/'
  };
  
  event.waitUntil(
    self.registration.showNotification(data.title || 'Amigo do Bolso', options)
  );
});

self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  
  event.waitUntil(
    clients.openWindow(event.notification.data || '/')
  );
});

// ========== LOG DE MENSAGENS ==========
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
  
  if (event.data && event.data.type === 'CLEAR_CACHE') {
    event.waitUntil(
      caches.keys().then((names) => {
        return Promise.all(names.map((name) => caches.delete(name)));
      })
    );
  }
});