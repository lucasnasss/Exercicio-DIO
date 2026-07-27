/* =============================================
   IRON TASK - SPA COMPLETO (FINAL COM TUDO)
   ============================================= */

// ---- CONFIGURAÇÃO INICIAL ----
const CONFIG = {
  loaderDelay: 2000,
  scrollRevealThreshold: 0.12,
  debounceDelay: 250,
  throttleDelay: 100,
  parallaxFactor: 0.4
};

const STATE = {
  currentRoute: null,
  cart: JSON.parse(localStorage.getItem('iron-task-cart') || '[]'),
  theme: localStorage.getItem('iron-task-theme') || 'system',
  scrollPositions: {},
  catalogFilters: {
    categories: [],
    sizes: [],
    maxPrice: 500,
    search: '',
    sort: 'recent'
  },
  selectedProduct: null
};

// ---- DADOS MOCK ----
const MOCK_PRODUCTS = [
  { id:'p1', name:'Regata Forjada', price:179, category:'regatas', sizes:['P','M','G','GG'], colors:['#1A1A1E','#3A3A3E','#C9A44B'], badge:'limitado' },
  { id:'p2', name:'Camiseta Alcateia', price:249, category:'camisetas', sizes:['P','M','G','GG'], colors:['#0A0A0C','#8A8D96','#E85D3A'], badge:null },
  { id:'p3', name:'Shorts Resistência', price:219, category:'shorts', sizes:['M','G','GG'], colors:['#12141A','#2A4B5C'], badge:'novo' },
  { id:'p4', name:'Jaqueta Aço', price:499, category:'jaquetas', sizes:['P','M','G'], colors:['#1A1D26','#C9A44B'], badge:'limitado' },
  { id:'p5', name:'Camiseta Disciplina', price:229, category:'camisetas', sizes:['P','M','G','GG'], colors:['#E85D3A','#0A0A0C'], badge:null },
  { id:'p6', name:'Regata Ímpeto', price:189, category:'regatas', sizes:['M','G','GG'], colors:['#C9A44B','#12141A'], badge:'novo' },
  { id:'p7', name:'Calça Foco', price:349, category:'calcas', sizes:['P','M','G'], colors:['#0A0A0C','#8A8D96'], badge:null },
  { id:'p8', name:'Boné Javali', price:99, category:'acessorios', sizes:['Único'], colors:['#0A0A0C','#C9A44B'], badge:null },
  { id:'p9', name:'Mochila Tática', price:399, category:'acessorios', sizes:['Único'], colors:['#12141A'], badge:'limitado' },
  { id:'p10', name:'Camiseta Legado', price:269, category:'camisetas', sizes:['P','M','G','GG'], colors:['#2A4B5C','#EAEAEC'], badge:null },
  { id:'p11', name:'Short Coragem', price:199, category:'shorts', sizes:['M','G'], colors:['#E85D3A','#0A0A0C'], badge:'novo' },
  { id:'p12', name:'Luva de Treino', price:129, category:'acessorios', sizes:['P','M','G'], colors:['#1A1D26'], badge:null }
];

const MOCK_TESTIMONIALS = [
  { name:'Lucas M.', city:'São Paulo', text:'A qualidade é absurda. Treino pesado há 3 anos e as camisetas estão intactas.' },
  { name:'Rafaela S.', city:'Rio de Janeiro', text:'Finalmente roupas que aguentam o tranco. O estilo é um bônus.' },
  { name:'Thiago P.', city:'Belo Horizonte', text:'A jaqueta Aço virou meu uniforme diário. Leve, resistente e estilosa.' },
  { name:'Marina C.', city:'Curitiba', text:'Comprei a regata Forjada e nunca mais olhei pra trás.' },
  { name:'André F.', city:'Recife', text:'Entrega rápida e o produto superou as fotos.' }
];

const MOCK_ARTICLES = [
  { id:'a1', tag:'Treino', title:'A Filosofia do 5AM Club', excerpt:'Por que os mais disciplinados treinam antes do sol nascer.', date:'12 Jul 2026' },
  { id:'a2', tag:'Moda', title:'Streetwear Funcional: O Novo Padrão', excerpt:'Como a Iron Task está redefinindo o conceito de roupa de treino.', date:'05 Jul 2026' },
  { id:'a3', tag:'Bastidores', title:'A Lenda do Javali: Nosso Símbolo', excerpt:'A história por trás do javali e por que ele representa tudo.', date:'28 Jun 2026' }
];

const MOCK_FAQ = [
  { q:'Qual o prazo de entrega?', a:'3 a 7 dias úteis para capitais, 5 a 12 para interior.' },
  { q:'Como trocar?', a:'30 dias após recebimento. Primeira troca grátis.' },
  { q:'Garantia?', a:'90 dias contra defeitos de fabricação.' },
  { q:'Loja física?', a:'Apenas online, com pop-ups sazonais.' },
  { q:'Tabela de medidas?', a:'P (92-98cm), M (98-104cm), G (104-110cm), GG (110-118cm).' },
  { q:'Cancelamento?', a:'Em até 2 horas após a compra.' }
];

// ---- UTILITÁRIOS ----
const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];

function debounce(fn, delay = CONFIG.debounceDelay) {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => fn.apply(this, args), delay);
  };
}

function throttle(fn, delay = CONFIG.throttleDelay) {
  let last = 0;
  return function (...args) {
    const now = Date.now();
    if (now - last >= delay) {
      last = now;
      fn.apply(this, args);
    }
  };
}

function formatPrice(v) {
  return `R$ ${v.toFixed(2).replace('.', ',')}`;
}

function resolveURL(url) {
  const a = document.createElement('a');
  a.href = url;
  return a.href;
}

// ---- META DESCRIPTION DINÂMICA ----
const metaDescription = document.querySelector('meta[name="description"]');
const defaultDesc = 'Iron Task — Moda esportiva e streetwear de alto nível. Forjado no fogo. Vestido com propósito.';
function updateMetaDescription(view) {
  const descriptions = {
    home: defaultDesc,
    sobre: 'Conheça a história da Iron Task e a lenda do javali. Força, disciplina e resistência.',
    catalogo: 'Explore o catálogo completo de equipamentos Iron Task. Camisetas, regatas, calças e acessórios de alta performance.',
    produto: 'Detalhes do produto Iron Task. Tecido premium, costura reforçada. Vista-se com propósito.',
    colecoes: 'Coleções exclusivas Iron Task. Edições limitadas e lançamentos.',
    blog: 'Blog da Alcateia Iron Task. Artigos sobre treino, disciplina e estilo de vida.',
    carrinho: 'Seu carrinho de compras Iron Task. Revise seus itens e finalize seu pedido.',
    contato: 'Fale com a Iron Task. Dúvidas, sugestões ou parcerias.',
    faq: 'Perguntas frequentes Iron Task. Prazos, trocas, garantia e mais.',
    privacidade: 'Política de Privacidade da Iron Task.',
    termos: 'Termos de Uso da Iron Task.'
  };
  if (metaDescription) metaDescription.setAttribute('content', descriptions[view] || defaultDesc);
}

// ---- TEMA ----
function initTheme() {
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  if (STATE.theme === 'system') {
    document.documentElement.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
  } else {
    document.documentElement.setAttribute('data-theme', STATE.theme);
  }
}

function toggleTheme() {
  const current = document.documentElement.getAttribute('data-theme');
  const next = current === 'dark' ? 'light' : 'dark';
  document.documentElement.setAttribute('data-theme', next);
  STATE.theme = next;
  localStorage.setItem('iron-task-theme', next);
}

// ---- CARRINHO ----
function getCartCount() {
  return STATE.cart.reduce((sum, item) => sum + item.quantity, 0);
}

function addToCart(product) {
  const existing = STATE.cart.find(i => i.id === product.id && i.size === product.size);
  if (existing) {
    existing.quantity += product.quantity || 1;
  } else {
    STATE.cart.push({ ...product, quantity: product.quantity || 1 });
  }
  saveCart();
  updateCartUI();
  showToast(`${product.name} (${product.size}) adicionado ao carrinho`, 'success');
}

function removeFromCart(productId, size) {
  STATE.cart = STATE.cart.filter(i => !(i.id === productId && i.size === size));
  saveCart();
  updateCartUI();
  if (STATE.currentRoute && STATE.currentRoute.includes('/carrinho')) {
    const route = getRouteFromURL();
    renderView(route);
  }
}

function saveCart() {
  localStorage.setItem('iron-task-cart', JSON.stringify(STATE.cart));
}

function updateCartUI() {
  const countEl = document.getElementById('cart-count');
  if (!countEl) return;
  const count = getCartCount();
  countEl.textContent = count;
  if (count > 0) {
    countEl.classList.add('navbar__cart-count--bump');
    setTimeout(() => countEl.classList.remove('navbar__cart-count--bump'), 300);
  }
}

function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;
  const toast = document.createElement('div');
  toast.className = `toast toast--${type}`;
  toast.textContent = message;
  container.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

// ---- LAZY LOAD ----
let lazyObserver;

function initLazyLoad() {
  lazyObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        const src = img.getAttribute('data-src');
        if (src) {
          img.src = src;
          img.removeAttribute('data-src');
          img.classList.add('lazy-loaded');
        }
        lazyObserver.unobserve(img);
      }
    });
  }, { rootMargin: '200px' });
}

function observeNewImages() {
  document.querySelectorAll('img[data-src]').forEach(img => lazyObserver.observe(img));
}

// ---- SCROLL REVEAL ----
function initScrollReveal(container = document) {
  const elements = container.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: CONFIG.scrollRevealThreshold, rootMargin: '0px 0px -40px 0px' });
  elements.forEach(el => observer.observe(el));
}

// ---- PARALLAX ----
function initParallax() {
  const watermark = document.querySelector('.hero__watermark');
  if (!watermark) return;
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    watermark.style.transform = `translateY(${scrolled * CONFIG.parallaxFactor}px)`;
  }, { passive: true });
}

// ---- RIPPLE EFFECT ----
function createRipple(e, btn) {
  const ripple = document.createElement('span');
  ripple.className = 'ripple';
  const rect = btn.getBoundingClientRect();
  const size = Math.max(rect.width, rect.height);
  ripple.style.width = ripple.style.height = `${size}px`;
  ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
  ripple.style.top = `${e.clientY - rect.top - size / 2}px`;
  btn.appendChild(ripple);
  ripple.addEventListener('animationend', () => ripple.remove());
}

document.addEventListener('click', e => {
  const btn = e.target.closest('.btn');
  if (btn) createRipple(e, btn);
});

// ---- ROUTER ----
const routes = {
  '/':              { view: 'home',      title: 'Iron Task — Forjado no Fogo' },
  '/sobre':         { view: 'sobre',     title: 'Sobre | Iron Task' },
  '/catalogo':      { view: 'catalogo',  title: 'Catálogo | Iron Task' },
  '/produto':       { view: 'produto',   title: 'Produto | Iron Task' },
  '/colecoes':      { view: 'colecoes',  title: 'Coleções | Iron Task' },
  '/blog':          { view: 'blog',      title: 'Blog | Iron Task' },
  '/blog/artigo':   { view: 'artigo',    title: 'Artigo | Iron Task' },
  '/contato':       { view: 'contato',   title: 'Contato | Iron Task' },
  '/faq':           { view: 'faq',       title: 'FAQ | Iron Task' },
  '/privacidade':   { view: 'privacidade', title: 'Privacidade | Iron Task' },
  '/termos':        { view: 'termos',    title: 'Termos | Iron Task' },
  '/carrinho':      { view: 'carrinho',  title: 'Carrinho | Iron Task' },
  '/checkout':      { view: 'checkout',  title: 'Checkout | Iron Task' }
};

function parseRoute(pathname) {
  let path = pathname.replace(/\/+/g, '/').replace(/\/$/, '') || '/';
  if (routes[path]) return { ...routes[path], params: {} };
  for (const [rp, rc] of Object.entries(routes)) {
    if (rp !== '/' && path.startsWith(rp)) {
      const qs = path.includes('?') ? path.substring(path.indexOf('?')) : '';
      const params = {};
      if (qs) new URLSearchParams(qs).forEach((v, k) => { params[k] = v; });
      return { ...rc, params };
    }
  }
  return { view: '404', title: '404 | Iron Task', params: {} };
}

function getRouteFromURL() {
  return parseRoute(window.location.pathname + window.location.search);
}

async function navigateTo(url, addToHistory = true) {
  try {
    if (STATE.currentRoute) {
      STATE.scrollPositions[STATE.currentRoute] = window.scrollY;
    }
    const fullURL = resolveURL(url);
    const urlObj = new URL(fullURL);
    const route = parseRoute(urlObj.pathname + urlObj.search);
    if (addToHistory) {
      window.history.pushState({ route, url: fullURL }, route.title, fullURL);
    }
    await renderView(route);
  } catch (err) {
    console.error('Erro na navegação:', err);
    const app = document.getElementById('app');
    if (app) app.innerHTML = `<div class="not-found"><p>Erro ao carregar a página. Tente novamente.</p></div>`;
  }
}

async function renderView(route) {
  try {
    STATE.currentRoute = window.location.pathname + window.location.search;
    document.title = route.title;
    updateMetaDescription(route.view);
    updateActiveNavLink(route.view);

    const app = document.getElementById('app');
    if (!app) return;

    app.style.opacity = '0';
    app.style.transform = 'translateY(8px)';
    await new Promise(resolve => setTimeout(resolve, 100));

    const html = generateViewHTML(route);
    app.innerHTML = html;
    app.classList.add('app-view');

    requestAnimationFrame(() => {
      app.style.opacity = '1';
      app.style.transform = 'translateY(0)';
    });

    const saved = STATE.scrollPositions[STATE.currentRoute];
    window.scrollTo({ top: saved || 0, behavior: 'instant' });

    initViewSpecifics(route.view, route.params);
    observeNewImages();
    initScrollReveal(app);
  } catch (err) {
    console.error('Erro ao renderizar view:', err);
    const app = document.getElementById('app');
    if (app) app.innerHTML = `<div class="not-found"><p>Erro ao carregar conteúdo. Por favor, recarregue a página.</p></div>`;
  }
}

function updateActiveNavLink(view) {
  $$('.navbar__link').forEach(link => {
    link.classList.remove('navbar__link--active');
    const href = link.getAttribute('href');
    if (href === '/' && view === 'home') link.classList.add('navbar__link--active');
    else if (href && href !== '/' && view !== 'home' && view !== '404' && href.includes(view)) link.classList.add('navbar__link--active');
  });
}

// ---- TEMPLATES ----
function productCardHTML(p) {
  const badge = p.badge
    ? `<span class="product-card__badge product-card__badge--${p.badge === 'novo' ? 'new' : 'limited'}">${p.badge}</span>`
    : '';
  const placeholder = `<div class="product-card__placeholder">${p.name.split(' ')[0]}</div>`;
  return `<div class="product-card" onclick="IronTask.navigateTo('/produto?id=${p.id}')" tabindex="0" role="button" aria-label="${p.name}">
    <div class="product-card__image-wrap">${badge}${placeholder}</div>
    <div class="product-card__info">
      <div class="product-card__name">${p.name}</div>
      <div class="product-card__price">${formatPrice(p.price)}</div>
      <div class="product-card__sizes">${p.sizes.map(s => `<span class="product-card__size">${s}</span>`).join('')}</div>
    </div>
  </div>`;
}

function generateViewHTML(route) {
  const { view, params } = route;
  switch (view) {
    case 'home': return generateHomeHTML();
    case 'sobre': return generateSobreHTML();
    case 'catalogo': return generateCatalogoHTML(params);
    case 'produto': return generateProdutoHTML(params);
    case 'colecoes': return generateColecoesHTML();
    case 'blog': return generateBlogHTML();
    case 'artigo': return generateArtigoHTML(params);
    case 'contato': return generateContatoHTML();
    case 'faq': return generateFAQHTML();
    case 'privacidade': return generatePrivacidadeHTML();
    case 'termos': return generateTermosHTML();
    case 'carrinho': return generateCarrinhoHTML();
    case 'checkout': return generateCheckoutHTML();
    default: return generate404HTML();
  }
}

function generateHomeHTML() {
  const fp = MOCK_PRODUCTS.slice(0, 4);
  return `<div class="home-view">
    <section class="hero">
      <svg class="hero__watermark" viewBox="0 0 120 100"><path fill="var(--accent-primary)" d="M20 60 Q20 30 55 25 Q75 22 90 30 Q100 35 100 50 Q100 65 85 70 Q75 72 60 68 Q45 65 35 55 Q25 45 20 60Z M90 30 Q105 20 108 35 Q110 45 100 50 M55 25 Q50 15 55 10 M65 22 Q62 10 68 8 M75 24 Q75 12 80 10"/></svg>
      <div class="hero__content container reveal">
        <h1 class="hero__title">FORJADO<br>NO FOGO</h1>
        <p class="hero__subtitle">Vestido com propósito. Como você.</p>
        <a href="/catalogo" class="btn btn--primary" data-link>VER CATÁLOGO</a>
      </div>
    </section>
    <section class="section reveal"><div class="container"><h2 class="section__heading">MANIFESTO</h2><p class="manifesto__text">"Não é sobre chegar. É sobre continuar quando todos param."</p><p class="manifesto__text">"Forjado no fogo. Vestido com propósito."</p><p class="manifesto__text">"Roupas que aguentam o tranco. Como você."</p></div></section>
    <section class="section section--dark reveal"><div class="container"><h2 class="section__heading">DESTAQUES</h2><div class="product-grid">${fp.map(p => productCardHTML(p)).join('')}</div></div></section>
    <section class="section reveal"><div class="container"><h2 class="section__heading">COLEÇÕES</h2><div class="collection-grid"><div class="collection-card" onclick="IronTask.navigateTo('/catalogo?cat=camisetas')"><div class="collection-card__content"><div class="collection-card__subtitle">LANÇAMENTO</div><div class="collection-card__title">FORJADO NO FOGO</div></div></div><div class="collection-stack"><div class="collection-card" onclick="IronTask.navigateTo('/catalogo?cat=jaquetas')"><div class="collection-card__content"><div class="collection-card__subtitle">LIMITADO</div><div class="collection-card__title">RESISTÊNCIA</div></div></div><div class="collection-card" onclick="IronTask.navigateTo('/catalogo')"><div class="collection-card__content"><div class="collection-card__subtitle">ATEMPORAL</div><div class="collection-card__title">ESSENTIALS</div></div></div></div></div></div></section>
    <section class="section section--elevated reveal"><div class="container"><h2 class="section__heading">DIFERENCIAIS</h2><div class="benefits-grid"><div class="benefit-card"><svg class="benefit-card__icon" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4 2 7-6.5-4.5L5.5 20l2-7L2 9h7z" stroke="currentColor" stroke-width="1.5" fill="none"/></svg><div class="benefit-card__title">COSTURA REFORÇADA</div><div class="benefit-card__text">Costura dupla em pontos de tensão.</div></div><div class="benefit-card"><svg class="benefit-card__icon" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="1.5" fill="none"/></svg><div class="benefit-card__title">TECIDO PREMIUM</div><div class="benefit-card__text">Algodão egípcio de alta performance.</div></div><div class="benefit-card"><svg class="benefit-card__icon" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M23 7l-7 4 7 4V7z" stroke="currentColor" stroke-width="1.5" fill="none"/></svg><div class="benefit-card__title">FRETE GRÁTIS</div><div class="benefit-card__text">Acima de R$299 para todo Brasil.</div></div><div class="benefit-card"><svg class="benefit-card__icon" viewBox="0 0 24 24"><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.5" fill="none"/></svg><div class="benefit-card__title">TROCA FÁCIL</div><div class="benefit-card__text">30 dias para trocar, sem burocracia.</div></div></div></div></section>
    <section class="section testimonials reveal"><div class="container"><h2 class="section__heading">DEPOIMENTOS</h2><div class="testimonials__track" id="testimonials-track">${MOCK_TESTIMONIALS.map(t => `<div class="testimonial-card"><div class="testimonial-card__quote">"</div><p class="testimonial-card__text">${t.text}</p><div class="testimonial-card__author"><div class="testimonial-card__avatar">${t.name.charAt(0)}</div><div><div class="testimonial-card__name">${t.name}</div><div class="testimonial-card__city">${t.city}</div></div></div></div>`).join('')}</div><div class="testimonials__dots" id="testimonials-dots"></div></div></section>
    <section class="cta-banner reveal"><p class="cta-banner__text">PRONTO PARA ENTRAR NA ARENA?</p><a href="/catalogo" class="btn btn--primary" data-link>VER CATÁLOGO COMPLETO</a></section>
  </div>`;
}

function generateSobreHTML() {
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);">
    <div class="container reveal"><h1 class="section__heading">A LENDA DO JAVALI</h1><p style="color:var(--text-secondary);max-width:650px;margin-bottom:3rem;">A Iron Task nasceu do desconforto. Da insatisfação com roupas que não acompanhavam a intensidade do treino.</p></div>
    <div class="container reveal" style="max-width:700px;"><h2 class="section__heading" style="font-size:1.5rem;">Nossa História</h2>
      <div class="timeline">
        <div class="timeline__item"><div class="timeline__year">2018</div><div class="timeline__title">O Despertar</div><div class="timeline__text">Dois atletas criam sua própria linha.</div></div>
        <div class="timeline__item"><div class="timeline__year">2019</div><div class="timeline__title">Primeira Coleção</div><div class="timeline__text">100 peças esgotadas em 48h.</div></div>
        <div class="timeline__item"><div class="timeline__year">2021</div><div class="timeline__title">Expansão Nacional</div><div class="timeline__text">Envios para todo o Brasil.</div></div>
        <div class="timeline__item"><div class="timeline__year">2026</div><div class="timeline__title">O Futuro</div><div class="timeline__text">Coleções internacionais e sustentáveis.</div></div>
      </div>
    </div>
  </div>`;
}

function getFilteredProducts() {
  let p = [...MOCK_PRODUCTS];
  if (STATE.catalogFilters.categories.length) p = p.filter(x => STATE.catalogFilters.categories.includes(x.category));
  if (STATE.catalogFilters.sizes.length) p = p.filter(x => x.sizes.some(s => STATE.catalogFilters.sizes.includes(s)));
  p = p.filter(x => x.price <= STATE.catalogFilters.maxPrice);
  if (STATE.catalogFilters.search) p = p.filter(x => x.name.toLowerCase().includes(STATE.catalogFilters.search.toLowerCase()));
  switch (STATE.catalogFilters.sort) {
    case 'price-asc': p.sort((a,b) => a.price - b.price); break;
    case 'price-desc': p.sort((a,b) => b.price - a.price); break;
    case 'name': p.sort((a,b) => a.name.localeCompare(b.name)); break;
  }
  return p;
}

function generateCatalogoHTML(params) {
  if (params.cat) STATE.catalogFilters.categories = [params.cat];
  else STATE.catalogFilters.categories = [];
  STATE.catalogFilters.search = '';
  STATE.catalogFilters.sort = 'recent';
  const filtered = getFilteredProducts();
  const cats = ['camisetas','regatas','calcas','shorts','jaquetas','acessorios'];
  const sizes = ['P','M','G','GG'];
  return `<div class="catalog-layout container">
    <aside class="catalog-filters reveal"><h3 class="catalog-filters__heading">FILTROS</h3>
      <div class="catalog-filters__group"><span class="catalog-filters__label">Categoria</span>${cats.map(c => `<label class="catalog-filters__checkbox"><input type="checkbox" value="${c}" ${STATE.catalogFilters.categories.includes(c)?'checked':''} data-filter="category">${c.charAt(0).toUpperCase()+c.slice(1)}</label>`).join('')}</div>
      <div class="catalog-filters__group"><span class="catalog-filters__label">Tamanho</span>${sizes.map(s => `<label class="catalog-filters__checkbox"><input type="checkbox" value="${s}" ${STATE.catalogFilters.sizes.includes(s)?'checked':''} data-filter="size">${s}</label>`).join('')}</div>
      <div class="catalog-filters__group"><span class="catalog-filters__label">Preço Máximo</span><input type="range" min="50" max="500" value="${STATE.catalogFilters.maxPrice}" class="catalog-filters__range" data-filter="price" step="10"><span style="font-size:0.8rem;color:var(--text-secondary);">Até ${formatPrice(STATE.catalogFilters.maxPrice)}</span></div>
      <span class="catalog-filters__clear" id="clear-filters">Limpar Filtros</span>
    </aside>
    <div>
      <div class="catalog-toolbar reveal">
        <div class="catalog-search"><svg class="catalog-search__icon" viewBox="0 0 24 24" width="16" height="16"><circle cx="10.5" cy="10.5" r="6.5" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M15.5 15.5L21 21" stroke="currentColor" stroke-width="1.5"/></svg><input type="text" class="catalog-search__input" placeholder="Buscar..." id="catalog-search"></div>
        <select class="catalog-sort" id="catalog-sort"><option value="recent">Mais Recentes</option><option value="price-asc">Menor Preço</option><option value="price-desc">Maior Preço</option><option value="name">Nome</option></select>
        <span class="catalog-count">${filtered.length} produto(s)</span>
      </div>
      <div class="product-grid reveal" id="product-grid">${filtered.slice(0,8).map(p => productCardHTML(p)).join('')}</div>
      ${filtered.length > 8 ? '<button class="btn btn--outline load-more-btn" id="load-more" data-page="1">CARREGAR MAIS</button>' : ''}
    </div>
  </div>`;
}

function generateProdutoHTML(params) {
  const product = MOCK_PRODUCTS.find(p => p.id === params.id) || MOCK_PRODUCTS[0];
  STATE.selectedProduct = product;
  const related = MOCK_PRODUCTS.filter(p => p.id !== product.id && p.category === product.category).slice(0,4);
  return `<div class="product-view container">
    <div class="breadcrumb reveal"><a href="/" data-link>Home</a> <span class="breadcrumb__sep">/</span> <a href="/catalogo" data-link>Catálogo</a> <span class="breadcrumb__sep">/</span> <span>${product.name}</span></div>
    <div style="display:grid; grid-template-columns:1fr; gap:2rem;">
      <div class="product-gallery reveal">
        <div class="product-gallery__thumbnails" id="product-thumbnails">
          <div class="product-gallery__thumb product-gallery__thumb--active"><div class="product-card__placeholder" style="font-size:0.8rem;">FRENTE</div></div>
          <div class="product-gallery__thumb"><div class="product-card__placeholder" style="font-size:0.8rem;">COSTAS</div></div>
        </div>
        <div class="product-gallery__main"><div class="product-card__placeholder" style="font-size:3rem;">${product.name.split(' ')[0]}</div></div>
      </div>
      <div class="product-info reveal">
        <h1 class="product-info__name">${product.name}</h1>
        <div class="product-info__price">${formatPrice(product.price)}</div>
        <div class="product-info__installments">ou 3x de ${formatPrice(product.price/3)}</div>
        <div class="product-info__size-label">Tamanho</div>
        <div class="product-info__sizes" id="product-sizes">${product.sizes.map(s => `<button class="product-info__size" data-size="${s}">${s}</button>`).join('')}</div>
        <div class="product-info__actions"><button class="btn btn--primary" id="btn-add-cart">ADICIONAR AO CARRINHO</button></div>
        <div class="accordion"><div class="accordion__header" aria-expanded="true">DESCRIÇÃO<svg class="accordion__icon" viewBox="0 0 12 8" width="12" height="8"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg></div><div class="accordion__body" aria-hidden="false"><div class="accordion__content"><p>Peça essencial Iron Task. Tecido premium, costura reforçada.</p></div></div></div>
        <div class="accordion"><div class="accordion__header" aria-expanded="false">GUIA DE MEDIDAS<svg class="accordion__icon" viewBox="0 0 12 8" width="12" height="8"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg></div><div class="accordion__body" aria-hidden="true"><div class="accordion__content"><table class="size-table"><tr><th>Tamanho</th><th>Peito</th></tr><tr><td>P</td><td>92-98cm</td></tr><tr><td>M</td><td>98-104cm</td></tr><tr><td>G</td><td>104-110cm</td></tr><tr><td>GG</td><td>110-118cm</td></tr></table></div></div></div>
      </div>
    </div>
    ${related.length ? `<div class="reveal" style="margin-top:4rem;"><h2 class="section__heading" style="font-size:1.5rem;">VOCÊ TAMBÉM PODE GOSTAR</h2><div class="related-products">${related.map(p => productCardHTML(p)).join('')}</div></div>` : ''}
  </div>`;
}

function generateColecoesHTML() {
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);"><div class="container reveal"><h1 class="section__heading">COLEÇÕES</h1><p style="color:var(--text-secondary);max-width:500px;">Edições que marcam época.</p></div><div class="container reveal" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;"><div class="collection-card" onclick="IronTask.navigateTo('/catalogo?cat=camisetas')"><div class="collection-card__content"><div class="collection-card__subtitle">LANÇAMENTO</div><div class="collection-card__title">FORJADO NO FOGO</div></div></div><div class="collection-card" onclick="IronTask.navigateTo('/catalogo?cat=jaquetas')"><div class="collection-card__content"><div class="collection-card__subtitle">LIMITADO</div><div class="collection-card__title">RESISTÊNCIA</div></div></div><div class="collection-card" onclick="IronTask.navigateTo('/catalogo')"><div class="collection-card__content"><div class="collection-card__subtitle">ATEMPORAL</div><div class="collection-card__title">ESSENTIALS</div></div></div></div></div>`;
}

function generateBlogHTML() {
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);"><div class="container reveal"><h1 class="section__heading">BLOG</h1><div class="blog-grid">${MOCK_ARTICLES.map(a => `<div class="blog-card" onclick="IronTask.navigateTo('/blog/artigo?id=${a.id}')"><div class="blog-card__image">${a.tag}</div><div class="blog-card__body"><div class="blog-card__tag">${a.tag}</div><h3 class="blog-card__title">${a.title}</h3><p class="blog-card__excerpt">${a.excerpt}</p><span class="blog-card__date">${a.date}</span></div></div>`).join('')}</div></div></div>`;
}

function generateArtigoHTML(params) {
  const a = MOCK_ARTICLES.find(x => x.id === params.id) || MOCK_ARTICLES[0];
  return `<article class="article-view reveal"><div class="breadcrumb"><a href="/" data-link>Home</a> <span class="breadcrumb__sep">/</span> <a href="/blog" data-link>Blog</a> <span class="breadcrumb__sep">/</span> <span>${a.title}</span></div><span class="blog-card__tag">${a.tag}</span><h1>${a.title}</h1><div class="article-meta">${a.date} · Equipe Iron Task</div><div class="article-body"><p>${a.excerpt}</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. A Iron Task acredita que cada repetição forja o caráter.</p></div></article>`;
}

function generateContatoHTML() {
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);"><div class="container reveal" style="max-width:600px;"><h1 class="section__heading">CONTATO</h1><form class="contact-form" id="contact-form" novalidate><div class="form-group"><label class="form-label" for="contact-name">Nome</label><input id="contact-name" class="form-input" required><span class="form-error">Obrigatório.</span></div><div class="form-group"><label class="form-label" for="contact-email">E-mail</label><input type="email" id="contact-email" class="form-input" required><span class="form-error">E-mail inválido.</span></div><div class="form-group"><label class="form-label" for="contact-subject">Assunto</label><input id="contact-subject" class="form-input" required><span class="form-error">Obrigatório.</span></div><div class="form-group"><label class="form-label" for="contact-message">Mensagem</label><textarea id="contact-message" class="form-textarea" required></textarea><span class="form-error">Obrigatório.</span></div><button type="submit" class="btn btn--primary">ENVIAR</button></form></div></div>`;
}

function generateFAQHTML() {
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);"><div class="container reveal" style="max-width:700px;"><h1 class="section__heading">FAQ</h1><div class="faq-list">${MOCK_FAQ.map((f,i) => `<div class="faq-item accordion"><div class="accordion__header" aria-expanded="${i===0}">${f.q}<svg class="accordion__icon" viewBox="0 0 12 8" width="12" height="8"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg></div><div class="accordion__body" aria-hidden="${i!==0}"><div class="accordion__content"><p>${f.a}</p></div></div></div>`).join('')}</div></div></div>`;
}

function generatePrivacidadeHTML() {
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);"><div class="container"><h1 class="section__heading reveal">PRIVACIDADE</h1><div class="policy-layout reveal"><aside class="policy-summary"><div class="policy-summary__title">SUMÁRIO</div><a href="#coleta">Coleta</a><a href="#uso">Uso</a></aside><div class="policy-content"><h3 id="coleta">Coleta de Dados</h3><p>Coletamos apenas dados necessários para seu pedido.</p><h3 id="uso">Uso</h3><p>Usados exclusivamente para processamento e comunicação.</p></div></div></div></div>`;
}

function generateTermosHTML() {
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);"><div class="container"><h1 class="section__heading reveal">TERMOS DE USO</h1><div class="policy-layout reveal"><aside class="policy-summary"><div class="policy-summary__title">SUMÁRIO</div><a href="#aceite">Aceite</a></aside><div class="policy-content"><h3 id="aceite">Aceite</h3><p>Ao usar o site, você concorda com estes termos.</p></div></div></div></div>`;
}

function generateCarrinhoHTML() {
  if (STATE.cart.length === 0) {
    return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);">
      <div class="container reveal" style="text-align:center;">
        <h1 class="section__heading">CARRINHO VAZIO</h1>
        <p style="color:var(--text-secondary); margin-bottom:2rem;">Seu carrinho está vazio. Vá para o catálogo e adicione produtos.</p>
        <a href="/catalogo" class="btn btn--primary" data-link>VER CATÁLOGO</a>
      </div>
    </div>`;
  }
  const total = STATE.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);">
    <div class="container reveal">
      <h1 class="section__heading">SEU CARRINHO</h1>
      <div class="cart-items" style="margin-bottom:2rem;">
        ${STATE.cart.map(item => `
          <div class="cart-item" style="display:flex; align-items:center; gap:1.5rem; padding:1.5rem 0; border-bottom:var(--border-thin);">
            <div style="width:80px; height:100px; background:var(--bg-elevated); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; font-family:var(--font-display); color:var(--accent-primary); font-size:1.5rem; letter-spacing:2px;">${item.name.split(' ')[0]}</div>
            <div style="flex:1;">
              <div style="font-family:var(--font-display); letter-spacing:1px;">${item.name}</div>
              <div style="color:var(--text-secondary); font-size:0.85rem;">Tamanho: ${item.size}</div>
              <div style="color:var(--accent-primary); font-weight:600;">${formatPrice(item.price)}</div>
            </div>
            <div style="text-align:right;">
              <div style="font-weight:600; color:var(--text-primary);">${formatPrice(item.price * item.quantity)}</div>
              <button class="btn btn--outline" style="margin-top:0.5rem; padding:0.3rem 0.8rem; font-size:0.7rem;" onclick="IronTask.removeFromCart('${item.id}', '${item.size}')">REMOVER</button>
            </div>
          </div>
        `).join('')}
      </div>
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <div style="font-family:var(--font-display); font-size:1.5rem; letter-spacing:2px;">TOTAL: ${formatPrice(total)}</div>
        <button class="btn btn--primary" onclick="IronTask.navigateTo('/checkout')">FINALIZAR COMPRA</button>
      </div>
    </div>
  </div>`;
}

function generateCheckoutHTML() {
  if (STATE.cart.length === 0) {
    return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);"><div class="container reveal" style="text-align:center;"><h1 class="section__heading">CARRINHO VAZIO</h1><p style="color:var(--text-secondary);">Adicione produtos antes de finalizar.</p><a href="/catalogo" class="btn btn--primary" data-link>VER CATÁLOGO</a></div></div>`;
  }
  const total = STATE.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
  return `<div class="section" style="padding-top:calc(var(--navbar-height) + 3rem);">
    <div class="container reveal">
      <h1 class="section__heading">FINALIZAR PEDIDO</h1>
      <p style="color:var(--text-secondary); margin-bottom:2rem;">Revise seu pedido e confirme.</p>
      <div style="background:var(--bg-elevated); padding:1.5rem; border-radius:var(--radius-lg); margin-bottom:2rem;">
        ${STATE.cart.map(item => `
          <div style="display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px solid rgba(255,255,255,0.05);">
            <span>${item.name} (${item.size}) x${item.quantity}</span>
            <span>${formatPrice(item.price * item.quantity)}</span>
          </div>
        `).join('')}
        <div style="display:flex; justify-content:space-between; margin-top:1rem; font-family:var(--font-display); font-size:1.3rem; letter-spacing:2px;">
          <span>TOTAL</span>
          <span>${formatPrice(total)}</span>
        </div>
      </div>
      <button class="btn btn--primary" id="btn-confirm-order" style="margin-right:1rem;">CONFIRMAR PEDIDO</button>
      <button class="btn btn--outline" onclick="IronTask.navigateTo('/carrinho')">VOLTAR</button>
    </div>
  </div>`;
}

function generate404HTML() {
  return `<div class="not-found reveal"><div><svg class="not-found__icon" viewBox="0 0 120 100"><path fill="var(--accent-primary)" d="M20 60 Q20 30 55 25 Q75 22 90 30 Q100 35 100 50 Q100 65 85 70 Q75 72 60 68 Q45 65 35 55 Q25 45 20 60Z M90 30 Q105 20 108 35 Q110 45 100 50 M55 25 Q50 15 55 10 M65 22 Q62 10 68 8 M75 24 Q75 12 80 10"/></svg><h1 class="not-found__title">JAVALI PERDIDO</h1><p class="not-found__text">Esta trilha não existe. Retorne ao caminho certo.</p><a href="/" class="btn btn--primary" data-link>VOLTAR À ARENA</a></div></div>`;
}

// ---- INICIALIZAÇÕES POR VIEW ----
function initViewSpecifics(view, params) {
  if (view === 'home') { initTestimonialsCarousel(); initParallax(); }
  if (view === 'catalogo') { initCatalogFilters(); initCatalogSearch(); initCatalogSort(); initLoadMore(); }
  if (view === 'produto') { initProductSizeSelector(); initAddToCartButton(); initAccordions(); }
  if (view === 'faq') initAccordions();
  if (view === 'contato') initContactForm();
  if (view === 'carrinho') {}
  if (view === 'checkout') initCheckout();
  if (document.querySelector('.accordion') && view !== 'produto' && view !== 'faq') initAccordions();
}

function initTestimonialsCarousel() {
  const track = document.getElementById('testimonials-track');
  const dotsC = document.getElementById('testimonials-dots');
  if (!track || !dotsC) return;
  const cards = track.querySelectorAll('.testimonial-card');
  dotsC.innerHTML = cards.map((_, i) => `<span class="testimonials__dot${i === 0 ? ' testimonials__dot--active' : ''}" data-index="${i}"></span>`).join('');
  const dots = dotsC.querySelectorAll('.testimonials__dot');
  function updateDots(idx) { dots.forEach((d, i) => d.classList.toggle('testimonials__dot--active', i === idx)); }
  track.addEventListener('scroll', throttle(() => {
    const w = cards[0].offsetWidth + 24;
    const idx = Math.round(track.scrollLeft / w);
    updateDots(Math.min(idx, cards.length - 1));
  }, 100));
  dots.forEach(d => d.addEventListener('click', () => {
    const idx = parseInt(d.dataset.index);
    track.scrollTo({ left: idx * (cards[0].offsetWidth + 24), behavior: 'smooth' });
    updateDots(idx);
  }));
}

function initCatalogFilters() {
  document.querySelectorAll('[data-filter]').forEach(input => {
    input.addEventListener('change', () => {
      if (input.dataset.filter === 'category') STATE.catalogFilters.categories = [...document.querySelectorAll('[data-filter="category"]:checked')].map(c => c.value);
      else if (input.dataset.filter === 'size') STATE.catalogFilters.sizes = [...document.querySelectorAll('[data-filter="size"]:checked')].map(c => c.value);
      else if (input.dataset.filter === 'price') STATE.catalogFilters.maxPrice = parseInt(input.value);
      refreshCatalogGrid();
    });
  });
  const clearBtn = document.getElementById('clear-filters');
  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      STATE.catalogFilters.categories = [];
      STATE.catalogFilters.sizes = [];
      STATE.catalogFilters.maxPrice = 500;
      STATE.catalogFilters.search = '';
      document.querySelectorAll('[data-filter]').forEach(el => {
        if (el.type === 'checkbox') el.checked = false;
        if (el.type === 'range') el.value = 500;
      });
      const searchInput = document.getElementById('catalog-search');
      if (searchInput) searchInput.value = '';
      refreshCatalogGrid();
    });
  }
}

function initCatalogSearch() {
  const input = document.getElementById('catalog-search');
  if (input) input.addEventListener('input', debounce(() => { STATE.catalogFilters.search = input.value.trim(); refreshCatalogGrid(); }, 300));
}

function initCatalogSort() {
  const sel = document.getElementById('catalog-sort');
  if (sel) sel.addEventListener('change', () => { STATE.catalogFilters.sort = sel.value; refreshCatalogGrid(); });
}

function initLoadMore() {
  const btn = document.getElementById('load-more');
  if (!btn) return;
  btn.addEventListener('click', () => {
    const page = parseInt(btn.dataset.page);
    const filtered = getFilteredProducts();
    const next = filtered.slice(page * 8, page * 8 + 8);
    const grid = document.getElementById('product-grid');
    if (grid) {
      grid.insertAdjacentHTML('beforeend', next.map(p => productCardHTML(p)).join(''));
      observeNewImages();
    }
    if ((page + 1) * 8 >= filtered.length) btn.remove();
    else btn.dataset.page = page + 1;
  });
}

function refreshCatalogGrid() {
  const filtered = getFilteredProducts();
  const grid = document.getElementById('product-grid');
  const btn = document.getElementById('load-more');
  const count = document.querySelector('.catalog-count');
  if (grid) {
    grid.innerHTML = filtered.slice(0, 8).map(p => productCardHTML(p)).join('');
    observeNewImages();
  }
  if (count) count.textContent = `${filtered.length} produto(s)`;
  if (btn) btn.style.display = filtered.length > 8 ? 'block' : 'none';
}

function initProductSizeSelector() {
  document.querySelectorAll('.product-info__size').forEach(b => b.addEventListener('click', () => {
    document.querySelectorAll('.product-info__size').forEach(x => x.classList.remove('product-info__size--selected'));
    b.classList.add('product-info__size--selected');
  }));
}

function initAddToCartButton() {
  const btn = document.getElementById('btn-add-cart');
  if (!btn) return;
  btn.addEventListener('click', () => {
    const sizeEl = document.querySelector('.product-info__size--selected');
    if (!sizeEl) {
      showToast('Selecione um tamanho', 'error');
      return;
    }
    const size = sizeEl.dataset.size;
    if (!STATE.selectedProduct) {
      const params = new URLSearchParams(window.location.search);
      const id = params.get('id');
      STATE.selectedProduct = MOCK_PRODUCTS.find(p => p.id === id) || MOCK_PRODUCTS[0];
    }
    const product = STATE.selectedProduct;
    addToCart({ id: product.id, name: product.name, price: product.price, size, quantity: 1 });
  });
}

function initAccordions() {
  document.querySelectorAll('.accordion__header').forEach(header => {
    header.addEventListener('click', () => {
      const body = header.nextElementSibling;
      const expanded = header.getAttribute('aria-expanded') === 'true';
      header.setAttribute('aria-expanded', !expanded);
      body.setAttribute('aria-hidden', expanded);
    });
    header.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); header.click(); } });
  });
}

function initContactForm() {
  const form = document.getElementById('contact-form');
  if (!form) return;
  form.addEventListener('submit', e => {
    e.preventDefault();
    let valid = true;
    form.querySelectorAll('.form-input, .form-textarea').forEach(input => {
      const err = input.nextElementSibling;
      input.classList.remove('error');
      if (err) err.style.display = 'none';
      if (!input.value.trim() || (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value))) {
        input.classList.add('error');
        if (err) err.style.display = 'block';
        valid = false;
      }
    });
    if (valid) {
      showToast('Mensagem enviada com sucesso!', 'success');
      form.reset();
    } else {
      showToast('Preencha todos os campos corretamente.', 'error');
    }
  });
}

function initCheckout() {
  const btn = document.getElementById('btn-confirm-order');
  if (btn) btn.addEventListener('click', () => {
    STATE.cart = [];
    saveCart();
    updateCartUI();
    showToast('Pedido confirmado com sucesso! Entraremos em contato.', 'success');
    navigateTo('/');
  });
}

// ---- MENUS E NAVEGAÇÃO ----
function initMobileMenu() {
  const btnMenu = document.getElementById('btn-menu');
  const btnClose = document.getElementById('btn-menu-close');
  const menu = document.getElementById('mobile-menu');
  const overlay = document.getElementById('mobile-overlay');
  if (!btnMenu || !menu) return;
  function open() {
    menu.classList.add('mobile-menu--open'); menu.setAttribute('aria-hidden', 'false');
    overlay.classList.add('mobile-overlay--visible'); overlay.setAttribute('aria-hidden', 'false');
    btnMenu.classList.add('navbar__hamburger--open'); btnMenu.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }
  function close() {
    menu.classList.remove('mobile-menu--open'); menu.setAttribute('aria-hidden', 'true');
    overlay.classList.remove('mobile-overlay--visible'); overlay.setAttribute('aria-hidden', 'true');
    btnMenu.classList.remove('navbar__hamburger--open'); btnMenu.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }
  btnMenu.addEventListener('click', open);
  if (btnClose) btnClose.addEventListener('click', close);
  overlay.addEventListener('click', close);
  menu.querySelectorAll('a[data-link]').forEach(link => link.addEventListener('click', close));
  const subToggle = menu.querySelector('.mobile-menu__sub-toggle');
  if (subToggle) {
    subToggle.addEventListener('click', () => {
      const ul = subToggle.nextElementSibling;
      const expanded = subToggle.getAttribute('aria-expanded') === 'true';
      subToggle.setAttribute('aria-expanded', !expanded);
      ul.hidden = expanded;
    });
  }
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && menu.classList.contains('mobile-menu--open')) close(); });
}

function initMegaMenu() {
  const trigger = document.querySelector('[data-mega-trigger]');
  const menu = document.getElementById('mega-menu');
  let hideTimeout;
  if (!trigger || !menu) return;
  function show() { clearTimeout(hideTimeout); menu.classList.add('mega-menu--visible'); menu.setAttribute('aria-hidden', 'false'); }
  function hide() { hideTimeout = setTimeout(() => { menu.classList.remove('mega-menu--visible'); menu.setAttribute('aria-hidden', 'true'); }, 200); }
  trigger.addEventListener('mouseenter', show); trigger.addEventListener('focus', show);
  menu.addEventListener('mouseenter', show);
  menu.addEventListener('mouseleave', hide); trigger.addEventListener('mouseleave', hide); trigger.addEventListener('blur', hide);
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && menu.classList.contains('mega-menu--visible')) hide(); });
}

function initNavigation() {
  document.addEventListener('click', e => {
    const link = e.target.closest('a[data-link]');
    if (!link) return;
    const href = link.getAttribute('href');
    if (!href) return;
    if (link.hostname && link.hostname !== window.location.hostname) return;
    e.preventDefault();
    navigateTo(href);
  });
  const cartBtn = document.getElementById('btn-cart');
  if (cartBtn) {
    cartBtn.addEventListener('click', (e) => {
      e.preventDefault();
      navigateTo('/carrinho');
    });
  }
  window.addEventListener('popstate', e => {
    const route = e.state?.route || getRouteFromURL();
    renderView(route);
  });
}

// ---- INICIALIZAÇÃO GERAL ----
function init() {
  initTheme();
  initMobileMenu();
  initMegaMenu();
  initNavigation();

  const btnTheme = document.getElementById('btn-theme');
  if (btnTheme) btnTheme.addEventListener('click', toggleTheme);

  const newsletterForm = document.getElementById('newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', e => {
      e.preventDefault();
      const input = newsletterForm.querySelector('input');
      if (input && input.value.includes('@')) {
        showToast('Inscrito com sucesso!', 'success');
        input.value = '';
      } else {
        showToast('Por favor, insira um e-mail válido.', 'error');
      }
    });
  }

  const btnSearch = document.getElementById('btn-search');
  if (btnSearch) btnSearch.addEventListener('click', () => navigateTo('/catalogo'));

  updateCartUI();

  const loader = document.getElementById('loader');
  if (loader) {
    const startTime = performance.now();
    const hideLoader = () => {
      loader.classList.add('loader--hidden');
      setTimeout(() => loader.remove(), 500);
    };
    window.addEventListener('load', () => {
      const elapsed = performance.now() - startTime;
      const remaining = Math.max(0, CONFIG.loaderDelay - elapsed);
      setTimeout(hideLoader, remaining);
    });
    setTimeout(() => { if (!loader.classList.contains('loader--hidden')) hideLoader(); }, 4000);
  }

  initLazyLoad();
  const initialRoute = getRouteFromURL();
  renderView(initialRoute);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}

// API global
window.IronTask = { navigateTo, addToCart, removeFromCart, getCartCount, toggleTheme, STATE };